<?php
// app/Http/Controllers/Member/WorkoutController.php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout;
use Carbon\Carbon;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        $member = auth()->guard('member')->user();

        $query = $member->workouts()->with('trainer');

        // البحث بالتمرين
        if ($request->has('search') && $request->search != '') {
            $query->where('exercise_name', 'like', '%' . $request->search . '%');
        }

        // التصفية باليوم
        if ($request->has('day') && $request->day != '') {
            $query->where('day', $request->day);
        }

        $workouts = $query->orderBy('day', 'desc')->get();

        $search = $request->search;
        $selectedDay = $request->day;

        // أيام الأسبوع للفلتر
        $daysOfWeek = [
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة',
            'saturday' => 'السبت',
            'sunday' => 'الأحد'
        ];

        return view('member.workouts.index', compact(
            'workouts',
            'search',
            'selectedDay',
            'daysOfWeek'
        ));
    }

    public function show(Workout $workout)
    {
        // التأكد من أن التمرين يخص اللاعب
        if ($workout->member_id !== auth()->guard('member')->id()) {
            abort(403);
        }

        return view('member.workouts.show', compact('workout'));
    }
}
