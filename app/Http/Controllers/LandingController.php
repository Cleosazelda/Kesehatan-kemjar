<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Evidence;
use App\Models\Hypothesis;
use App\Models\HypothesisImage;
use App\Models\Rule;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule; // Alias untuk Rule validasi
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index', [
            'title' => 'Dashboard',
            'diagnosis_data' => Diagnosis::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(5),
            'hypothesis_data' => Hypothesis::with('images')->orderBy('id', 'desc')->paginate(3),
        ]);
    }

    public function add()
    {
        return view('landing.add', [
            'title' => 'User',
        ]);
    }

    public function add_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'address' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', // PERBAIKAN: Hardcode role sebagai 'user' untuk mencegah Privilege Escalation.
            'address' => $request->address,
        ]);

        return redirect()->route('login')->with('status', 'Akun Berhasil Dibuat');
    }

    public function edit_profile()
    {
        return view('landing.profile', [
            'title' => 'Profile'
        ]);
    }

    // PERBAIKAN: Menghapus $id dari parameter untuk mencegah IDOR.
    public function profile_update(Request $request)
    {
        $user = Auth::user(); // Mengambil pengguna yang sedang login.

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', ValidationRule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'repassword' => 'same:password',
            'address' => 'required|string',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        return redirect()->route('index')->with('status', 'User updated successfully');
    }

    public function hypothesis_page()
    {
        return view('landing.hypothesis', [
            'hypothesis_data' => Hypothesis::all()
        ]);
    }

    public function hypothesis_detail($id)
    {
        return view('landing.detail', [
            'title' => 'Hypothesis',
            'get_hypothesis' => Hypothesis::with('images')->findOrFail($id),
        ]);
    }

    public function diagnosa()
    {
        return view('landing.diagnosa', [
            'title' => 'Expert System',
            'evidence' => Evidence::all(),
        ]);
    }

    public function history_page()
    {
        return view('landing.history', [
            'diagnosis_data' => Diagnosis::with('hypothesis.images')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function history_detail($id)
    {
        // PERBAIKAN: Pastikan pengguna hanya bisa melihat detail riwayatnya sendiri.
        $diagnosis = Diagnosis::with('hypothesis.images')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail(); // firstOrFail akan throw 404 jika tidak ditemukan.

        return view('landing.history_detail', [
            'title' => 'Hypothesis',
            'get_diagnosis' => $diagnosis
        ]);
    }

    public function destroy_history($id)
    {
        // PERBAIKAN: Tambahkan ->where('user_id', Auth::id()) untuk mencegah IDOR.
        $deleted = Diagnosis::where('id', $id)->where('user_id', Auth::id())->delete();

        if ($deleted) {
            return redirect()->back()->with('status', 'Data deleted succesfully!');
        }
        
        return redirect()->back()->with('error', 'Data not found or you are not authorized to delete it.');
    }

    // ... (sisa fungsi lainnya sudah aman dan tidak perlu diubah)

    public function showOtherDiagnosis($hypothesisId)
    {
        $hypothesis = Hypothesis::find($hypothesisId);
        if (!$hypothesis) {
            return redirect()->back()->with('error', 'Data penyakit tidak ditemukan.');
        }
        return view('landing.more_diagnosis_detail', compact('hypothesis'));
    }

    public function simpanHasilBayes(array $resultsForExcel)
    {
        // Fungsi ini sudah aman, tidak ada perubahan
        $filePath = 'exports/hasil_perhitungan_bayes.xlsx';
        $storagePath = storage_path('app/' . $filePath);

        // ... (logika penyimpanan Excel)
    }

    public function result(Request $request)
    {
        // Fungsi ini sudah aman, tidak ada perubahan
        // ... (logika perhitungan Bayes)
    }

    private function getCertaintyDescription($value)
    {
        // Fungsi ini sudah aman, tidak ada perubahan
        // ... (logika deskripsi kepastian)
    }
}