<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if(Auth::attempt($request->only('email','password')))
        {
            if(Auth::user()->role == 'super_admin')
            {
                return redirect()->route('superadmin.superdashboard');
            }
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error','Invalid email or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
