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
        // Peningkatan: Tambahkan pengecekan null untuk menghindari error
        $setting_hypothesis = Setting::where('component', 'hypothesis')->first();
        $title_hypothesis = $setting_hypothesis ? $setting_hypothesis->value : 'Hypothesis';

        return view('hypothesis.index', [
            'title' => 'Hypothesis - ' . $title_hypothesis,
            'hypothesis_data' => Hypothesis::with('images')->orderBy('id', 'desc')->get() // Eager load images
        ]);
    }

    public function autoCode()
    {
        $lates_hypothesis = Hypothesis::orderby('id', 'desc')->first();
        // Pengecekan jika tabel hipotesis masih kosong (sudah baik)
        if (!$lates_hypothesis) {
            return "P001";
        }
        $code = $lates_hypothesis->code;
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
        // Validasi Input yang sudah baik dan diperketat
        $request->validate([
            'code' => 'required|unique:hypotheses,code',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'solution' => 'required|string',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $hypothesis = Hypothesis::create($request->except('image'));

        // Proses Upload File yang Aman
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $fileName = 'hypothesis-' . $hypothesis->id . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/hypothesis-images', $fileName);

                HypothesisImage::create([
                    'hypothesis_id' => $hypothesis->id,
                    'image_path' => $fileName,
                ]);
            }
        }

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
            'get_hypothesis' => Hypothesis::with('images')->findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hypothesis = Hypothesis::findOrFail($id);
        
        $request->validate([
            'code' => 'required|unique:hypotheses,code,' . $hypothesis->id,
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'solution' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $hypothesis->update($request->except(['_token', '_method', 'image']));

        if ($request->hasFile('image')) {
            $oldImages = HypothesisImage::where('hypothesis_id', $hypothesis->id)->get();
            foreach ($oldImages as $oldImage) {
                Storage::delete('public/hypothesis-images/' . $oldImage->image_path);
                $oldImage->delete();
            }

            foreach ($request->file('image') as $image) {
                $fileName = 'hypothesis-' . $hypothesis->id . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/hypothesis-images', $fileName);

                HypothesisImage::create([
                    'hypothesis_id' => $hypothesis->id,
                    'image_path' => $fileName,
                ]);
            }
        }
        
        return redirect()->route('hypothesis.index')->with('status', 'Data updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hypothesis = Hypothesis::findOrFail($id);
        $images = HypothesisImage::where('hypothesis_id', $hypothesis->id)->get();

        foreach ($images as $image) {
            Storage::delete('public/hypothesis-images/' . $image->image_path);
            $image->delete();
        }

        Diagnosis::where('hypothesis_id', $id)->delete();
        Rule::where('hypothesis_id', $id)->delete();
        $hypothesis->delete();

        return redirect()->route('hypothesis.index')->with('status', 'Data deleted succesfully!');
    }
}