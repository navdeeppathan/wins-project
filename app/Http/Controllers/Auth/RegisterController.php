<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $users = User::where('parent_id', auth()->user()->id)->get();
        return view('superadmin.users.index', compact('users'));
    }


     public function adminIndex()
    {
        $users = User::where('parent_id', auth()->user()->id)->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function adminCreate()
    {
        $states = State::orderBy('name')->get();

        return view('admin.users.create', compact('states'));
    }

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
                // 'size:15',
                // 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                // 'unique:users,gst_number',
            ],
        ]);



      $user =  User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'auth_person_name'=> $request->auth_person_name,
            'gst_number' => strtoupper($request->gst_number),
            'password'=> Hash::make($request->password),
            'role' => 'admin',

        ]);

        //also login
        // auth()->login($user);

        return redirect()->route('/login')->with('success','Account created, please login.');
    }

    public function userCreate(Request $request)
    {
       $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'state' => 'nullable|string',
            'monthly_salary'=>'nullable',
            'date_of_joining' => 'required|date',
            'date_of_leaving' => 'nullable|date',
            'phone' => 'required|numeric',
            'designation' => 'nullable|string',

        ]);



      $user =  User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'state' => $request->state,
            'date_of_joining' => $request->date_of_joining,
            'date_of_leaving' => $request->date_of_leaving,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'monthly_salary' => $request->monthly_salary ? $request->monthly_salary : 0,
            'role' => 'staff',
            'parent_id' => auth()->user()->id,
        ]);

        //also login
        // auth()->login($user);

        return redirect()->route('admin.users.index')->with('success','Account created successfully.');
    }

}
