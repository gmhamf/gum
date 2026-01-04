<?php
// app/Http/Controllers/Gym/GymReportController.php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Subscription;
use App\Models\Trainer;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $gym = auth()->guard('gym')->user();

        $stats = [
            'total_members' => Member::where('gym_id', $gym->id)->count(),
            'active_members' => Member::where('gym_id', $gym->id)->where('status', true)->count(),
            'total_trainers' => Trainer::where('gym_id', $gym->id)->count(),
            'active_subscriptions' => Subscription::whereHas('member', function($query) use ($gym) {
                $query->where('gym_id', $gym->id);
            })->where('status', 'active')->count(),
            'monthly_income' => Subscription::whereHas('member', function($query) use ($gym) {
                $query->where('gym_id', $gym->id);
            })->whereMonth('created_at', now()->month)->sum('amount')
        ];

        $recentMembers = Member::where('gym_id', $gym->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('gym.reports.index', compact('stats', 'recentMembers'));
    }
}
