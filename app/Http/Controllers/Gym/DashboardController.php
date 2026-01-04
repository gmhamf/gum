<?php
// app/Http/Controllers/Gym/DashboardController.php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Subscription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $gym = auth()->guard('gym')->user();

        $stats = [
            'total_members' => Member::where('gym_id', $gym->id)->count(),
            'total_trainers' => Trainer::where('gym_id', $gym->id)->count(),
            'active_subscriptions' => Subscription::whereHas('member', function($query) use ($gym) {
                $query->where('gym_id', $gym->id);
            })->where('status', 'active')->count(),
            'expiring_soon' => Subscription::whereHas('member', function($query) use ($gym) {
                $query->where('gym_id', $gym->id);
            })->where('end_date', '<=', Carbon::now()->addDays(7))
              ->where('end_date', '>=', Carbon::now())
              ->where('status', 'active')
              ->count()
        ];

        $expiringSubscriptions = Subscription::whereHas('member', function($query) use ($gym) {
            $query->where('gym_id', $gym->id);
        })->where('end_date', '<=', Carbon::now()->addDays(7))
          ->where('end_date', '>=', Carbon::now())
          ->where('status', 'active')
          ->with('member')
          ->get();

        return view('gym.dashboard', compact('stats', 'expiringSubscriptions'));
    }
}
