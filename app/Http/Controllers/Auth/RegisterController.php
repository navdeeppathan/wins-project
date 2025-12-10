<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:50',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6|confirmed',
        ]);

        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role' => 'admin'
        ]);

        return redirect()->route('login.form')->with('success','Account created, please login.');
    }
}
