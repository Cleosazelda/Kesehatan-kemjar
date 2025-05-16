<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'address' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $defaultAvatarPath = 'avatars/default-avatar.png';

        // Periksa apakah pengguna mengunggah avatar
        if ($request->hasFile('avatar')) {
            $userName = $request->input('name');
            $safeUserName = str_replace(' ', '_', $userName);
            // Simpan avatar yang diunggah ke dalam storage/public/avatars
            $avatarPath = $request->file('avatar');
            $imageName = 'avatar' . $safeUserName . '.' . $avatarPath->getClientOriginalExtension();
            $avatarPath->storeAs('Public/Avatar-Image', $imageName);
        } else {
            // Gunakan avatar default jika tidak ada yang diunggah
            $avatarPath = $defaultAvatarPath;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:6|nullable',
            'repassword' => 'same:password|nullable',
            'address' => 'required'
        ]);

        if ($request->password == '') {
            $password = User::findOrFail($id)->password;
        } else {
            $password = bcrypt($request->password);
        }

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('status', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('user.index')->with('status', 'User deleted successfully');
    }
}
