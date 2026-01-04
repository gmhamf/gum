<?php
// app/Http/Middleware/CheckTrainer.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTrainer
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('trainer')->check()) {
            return $next($request);
        }

        return redirect()->route('trainer.login');
    }
}
