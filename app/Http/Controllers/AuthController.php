<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|'
        ]);

        if(Auth::attempt($credentials)){
            return redirect('/');
        }

        return redirect('/login')->with('status','Login Gagal!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function profile()
    {
        return view('auth.profile', [
            'title' => 'Profile'
        ]);
    }

    public function profile_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:6|nullable',
            'repassword' => 'same:password|nullable',
        ]);

        if($request->password == ''){
            $password = User::findOrFail($id)->password;
        } else {
            $password = bcrypt($request->password);
        }

        User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);

        return redirect()->route('profile.index')->with('status','User updated successfully');
    }
}
