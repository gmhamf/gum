<?php
// app/Http/Controllers/Trainer/Auth/LoginController.php

namespace App\Http\Controllers\Trainer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('trainer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('trainer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/trainer/dashboard');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('trainer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/trainer/login');
    }
}
