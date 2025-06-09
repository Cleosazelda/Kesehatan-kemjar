<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // PERBAIKAN: Tambahkan baris ini untuk mengimpor Auth Facade
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting.user.index', [
            'title' => 'User',
            'user_data' => User::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting.user.create', [
            'title' => 'User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'address' => 'required|string',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $avatarPath = 'avatars/default-avatar.png';

        if ($request->hasFile('avatar')) {
            $userName = str_replace(' ', '_', $request->input('name'));
            $file = $request->file('avatar');
            $imageName = 'avatar-' . $userName . '-' . time() . '.' . $file->getClientOriginalExtension();
            $avatarPath = $file->storeAs('public/avatars', $imageName);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => $request->role,
            'image' => $avatarPath
        ]);

        return redirect()->route('user.index')->with('status', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('setting.user.edit', [
            'title' => 'User',
            'get_user' => User::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'repassword' => 'same:password|nullable',
            'address' => 'required|string',
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);
        
        $updateData = $request->only(['name', 'email', 'address', 'role']);

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('user.index')->with('status', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Untuk mencegah admin menghapus akunnya sendiri secara tidak sengaja
        if (Auth::id() == $id) {
            return redirect()->route('user.index')->with('error', 'You cannot delete your own account.');
        }

        User::destroy($id);
        return redirect()->route('user.index')->with('status', 'User deleted successfully');
    }
}