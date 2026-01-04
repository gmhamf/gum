<?php
// app/Http/Controllers/Trainer/DashboardController.php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $trainer = auth()->guard('trainer')->user();

        $stats = $trainer->getStats();
        $workouts = $trainer->weeklyWorkouts();
        $recentMembers = $trainer->members()->latest()->take(5)->get();

        return view('trainer.dashboard', compact(
            'trainer',
            'stats',
            'workouts',
            'recentMembers'
        ));
    }
}
