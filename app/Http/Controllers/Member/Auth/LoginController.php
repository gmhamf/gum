<?php
// app/Http/Controllers/Member/Auth/LoginController.php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Gym;
use App\Models\Member;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:member')->except('logout');
    }

    public function showLoginForm()
    {
        $gyms = Gym::where('status', true)->get();
        return view('member.auth.login', compact('gyms'));
    }

    public function login(Request $request)
    {
        // التحقق من الصحة
        $request->validate([
            'gym_id' => 'required|exists:gyms,id',
            'member_code' => 'required',
            'password' => 'required'
        ]);

        try {
            // البحث عن العضو
            $member = Member::where('gym_id', $request->gym_id)
                ->where('member_code', $request->member_code)
                ->where('status', true)
                ->first();

            if ($member && Hash::check($request->password, $member->password)) {
                if (Auth::guard('member')->attempt([
                    'gym_id' => $request->gym_id,
                    'member_code' => $request->member_code,
                    'password' => $request->password
                ], $request->filled('remember'))) {

                    $request->session()->regenerate();
                    return redirect()->intended('/member/dashboard');
                }
            }

            return back()->withErrors([
                'member_code' => 'بيانات الدخول غير صحيحة',
            ])->withInput($request->only('member_code', 'gym_id'));

        } catch (\Exception $e) {
            return back()->withErrors([
                'member_code' => 'حدث خطأ في النظام. يرجى المحاولة مرة أخرى.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/member/login');
    }
}
