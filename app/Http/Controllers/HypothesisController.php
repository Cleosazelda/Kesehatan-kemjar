<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Evidence;
use App\Models\Hypothesis;
use App\Models\HypothesisImage;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import class Str untuk slug

class HypothesisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hypothesis.index', [
            'title' => 'Hypothesis - ' . Setting::where('component', 'hypothesis')->first()->value,
            'hypothesis_data' => Hypothesis::orderBy('id', 'desc')->get()
        ]);
    }

    public function autoCode()
    {
        $lates_evidence = Hypothesis::orderby('id', 'desc')->first();
        // Tambahkan pengecekan jika tabel hipotesis masih kosong
        if (!$lates_evidence) {
            return "P001";
        }
        $code = $lates_evidence->code;
        $order = (int) substr($code, 2, 3);
        $order++;
        $letter = "P";
        $code = $letter . sprintf("%03s", $order);
        return $code;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hypothesis.create', [
            'title' => 'Hypothesis',
            'get_auto_code' => $this->autoCode()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input yang Diperketat
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'solution' => 'required|string',
            // Validasi file gambar lebih spesifik dan aman
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB per gambar
        ]);

        // Buat data Hypothesis
        $hypothesis = Hypothesis::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'solution' => $request->solution,
        ]);

        // 2. Proses Upload File yang Aman
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                // Buat nama file yang unik dan aman untuk mencegah konflik dan path traversal
                $fileName = 'hypothesis-' . $hypothesis->id . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $image->getClientOriginalExtension();

                // Simpan file ke 'storage/app/public/hypothesis-images'
                // Cara ini lebih aman daripada menyimpan langsung di folder public
                $image->storeAs('public/hypothesis-images', $fileName);

                // Simpan nama file yang aman ke database
                HypothesisImage::create([
                    'hypothesis_id' => $hypothesis->id,
                    'image_path' => $fileName, // Gunakan 'image_path' sesuai model Anda
                ]);
            }
        }

        // Buat data Rule untuk setiap Evidence
        foreach (Evidence::all() as $value) {
            Rule::create([
                'evidence_id' => $value->id,
                'hypothesis_id' => $hypothesis->id,
                'weight' => 0.1
            ]);
        }

        return redirect()->route('hypothesis.index')->with('status', 'Data created succesfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Hypothesis $hypothesis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('hypothesis.edit', [
            'title' => 'Hypothesis',
            'get_hypothesis' => Hypothesis::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi yang konsisten dengan store
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'solution' => 'required|string',
            // Gambar boleh kosong saat update
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $hypothesis = Hypothesis::findOrFail($id);

        // Jika ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari penyimpanan dan database
            $oldImages = HypothesisImage::where('hypothesis_id', $hypothesis->id)->get();
            foreach ($oldImages as $oldImage) {
                // Hapus file lama dari 'storage/app/public/hypothesis-images'
                Storage::delete('public/hypothesis-images/' . $oldImage->image_path);
                // Hapus record dari database
                $oldImage->delete();
            }

            // Simpan gambar baru dengan cara yang aman
            foreach ($request->file('image') as $image) {
                $fileName = 'hypothesis-' . $hypothesis->id . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/hypothesis-images', $fileName);

                HypothesisImage::create([
                    'hypothesis_id' => $hypothesis->id,
                    'image_path' => $fileName,
                ]);
            }
        }

        // Update data lainnya
        $hypothesis->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'solution' => $request->solution,
        ]);

        return redirect()->route('hypothesis.index')->with('status', 'Data updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hypothesis = Hypothesis::findOrFail($id);
        $images = HypothesisImage::where('hypothesis_id', $hypothesis->id)->get();

        // Hapus semua file gambar terkait dari storage
        foreach ($images as $image) {
            Storage::delete('public/hypothesis-images/' . $image->image_path);
            $image->delete(); // Hapus record dari database
        }

        // Hapus data terkait sebelum menghapus hipotesis utama
        Diagnosis::where('hypothesis_id', $id)->delete();
        Rule::where('hypothesis_id', $id)->delete();
        $hypothesis->delete(); // Hapus hipotesis

        return redirect()->route('hypothesis.index')->with('status', 'Data deleted succesfully!');
    }
}