<?php
// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // تحديد صفحة تسجيل الدخول حسب المسار
            if ($request->is('gym/*')) {
                return route('gym.login');
            } elseif ($request->is('trainer/*')) {
                return route('trainer.login');
            } elseif ($request->is('member/*')) {
                return route('member.login');
            }
        }

        return null;
    }
}
