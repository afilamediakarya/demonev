<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function doLogin(Request $request)
    {
        if (auth()->attempt($request->only(['username', 'password']))) {
            return redirect()->to('dashboard');
        }
        return redirect()->back();
    }

    public function logout()
    {
        if (auth()->check())
            auth()->logout();
        return redirect()->route('login');
    }
}
