<?php
// app/Http/Middleware/CheckGymOwner.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGymOwner
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('gym')->check()) {
            return $next($request);
        }

        return redirect()->route('gym.login');
    }
}
