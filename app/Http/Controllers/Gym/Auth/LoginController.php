<?php
// app/Http/Controllers/Gym/Auth/LoginController.php

namespace App\Http\Controllers\Gym\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('gym.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('gym')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/gym/dashboard');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('gym')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/gym/login');
    }
}
