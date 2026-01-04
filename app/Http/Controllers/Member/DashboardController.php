<?php
// app/Http/Controllers/Member/DashboardController.php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $member = auth()->guard('member')->user();

        $workouts = $member->weeklyWorkouts();
        $diets = $member->weeklyDiets();
        $recentProgress = $member->progress()->latest()->take(5)->get();
        $unreadNotifications = $member->notifications()->where('seen', false)->count();
        $latestProgress = $member->latestProgress();

        return view('member.dashboard', compact(
            'member',
            'workouts',
            'diets',
            'recentProgress',
            'unreadNotifications',
            'latestProgress'
        ));
    }
}
