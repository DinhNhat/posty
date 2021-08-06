<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {
//        dd($request->remember);

        $this->validate($request,
            [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ],
            [
                'email.required' => 'Please Provide Your Email Address For Better Communication, Thank You.',
                'password.required' => 'Password Is Required For Your Information Safety, Thank You.'
            ] // customize the error message
        );

        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('status', 'Invalid login details');
        }

//        dd(auth()->user()->posts);

        return redirect()->route('dashboard');
    }
}
