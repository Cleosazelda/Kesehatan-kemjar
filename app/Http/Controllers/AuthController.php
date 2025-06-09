<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Import Rule untuk validasi email unik

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function login_process(Request $request)
    {
        // Menghilangkan | di akhir untuk best practice
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate session untuk keamanan
            return redirect('/');
        }

        return back()->with('status','Login Gagal!'); // Gunakan back() untuk kembali ke halaman sebelumnya
    }

    public function logout(Request $request) // Tambahkan Request
    {
        Auth::logout();

        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/login');
    }

    public function profile()
    {
        return view('auth.profile', [
            'title' => 'Profile'
        ]);
    }

    /**
     * Memperbarui profil pengguna yang sedang terotentikasi.
     * Kerentanan IDOR sudah diperbaiki dengan tidak menggunakan $id dari URL.
     */
    public function profile_update(Request $request)
    {
        // 1. Dapatkan pengguna yang sedang login. Ini cara yang aman.
        $user = Auth::user();

        // 2. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan email unik, tapi abaikan email milik pengguna saat ini
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'repassword' => 'same:password',
        ]);

        // 3. Siapkan data untuk diupdate
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // 4. Periksa apakah pengguna mengisi field password baru
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        // 5. Lakukan update
        $user->update($updateData);

        return redirect()->route('profile.index')->with('status', 'User updated successfully');
    }
}