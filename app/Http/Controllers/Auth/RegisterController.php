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
        'name' => 'required|string|max:50',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'auth_person_name' => 'required|string|max:50',

        // GST validation
        'gst_number' => [
            'required',
            'string',
            'size:15',
            'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'unique:users,gst_number',
        ],
    ]);

        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'auth_person_name'=> $request->auth_person_name,
            'gst_number' => strtoupper($request->gst_number),
            'password'=> Hash::make($request->password),
            'role' => 'admin'
        ]);

        return redirect()->route('login.form')->with('success','Account created, please login.');
    }
}
