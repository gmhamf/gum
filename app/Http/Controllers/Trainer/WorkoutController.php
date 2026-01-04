<?php
// app/Http/Controllers/Trainer/WorkoutController.php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Member;
use Carbon\Carbon;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        $trainer = auth()->guard('trainer')->user();

        $query = $trainer->workouts()->with('member');

        // البحث بالتمرين أو اسم العضو
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('exercise_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('member', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // التصفية باليوم
        if ($request->has('day') && $request->day != '') {
            $query->where('day', $request->day);
        }

        // التصفية بالعضو
        if ($request->has('member_id') && $request->member_id != '') {
            $query->where('member_id', $request->member_id);
        }

        $workouts = $query->orderBy('day', 'desc')->orderBy('created_at', 'desc')->get();

        $members = $trainer->members()->where('status', true)->get();
        $search = $request->search;
        $selectedDay = $request->day;
        $selectedMember = $request->member_id;

        return view('trainer.workouts.index', compact(
            'workouts',
            'members',
            'search',
            'selectedDay',
            'selectedMember'
        ));
    }

    public function create()
    {
        $trainer = auth()->guard('trainer')->user();
        $members = $trainer->members()->where('status', true)->get();

        return view('trainer.workouts.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'day' => 'required|date',
            'exercise_name' => 'required|string|max:255',
            'sets' => 'required|integer|min:1',
            'reps' => 'required|integer|min:1',
            'rest_time' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'video_url' => 'nullable|url'
        ]);

        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن العضو يتبع هذا المدرب
        $member = $trainer->members()->where('id', $request->member_id)->first();
        if (!$member) {
            return back()->withErrors(['member_id' => 'هذا العضو غير مسجل لديك']);
        }

        Workout::create([
            'trainer_id' => $trainer->id,
            'member_id' => $request->member_id,
            'day' => $request->day,
            'exercise_name' => $request->exercise_name,
            'sets' => $request->sets,
            'reps' => $request->reps,
            'rest_time' => $request->rest_time,
            'notes' => $request->notes,
            'video_url' => $request->video_url
        ]);

        return redirect()->route('trainer.workouts.index')->with('success', 'تم إضافة التمرين بنجاح');
    }

    public function edit(Workout $workout)
    {
        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن التمرين يخص هذا المدرب
        if ($workout->trainer_id !== $trainer->id) {
            abort(403);
        }

        $members = $trainer->members()->where('status', true)->get();

        return view('trainer.workouts.edit', compact('workout', 'members'));
    }

    public function update(Request $request, Workout $workout)
    {
        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن التمرين يخص هذا المدرب
        if ($workout->trainer_id !== $trainer->id) {
            abort(403);
        }

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'day' => 'required|date',
            'exercise_name' => 'required|string|max:255',
            'sets' => 'required|integer|min:1',
            'reps' => 'required|integer|min:1',
            'rest_time' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'video_url' => 'nullable|url'
        ]);

        $workout->update($request->all());

        return redirect()->route('trainer.workouts.index')->with('success', 'تم تحديث التمرين بنجاح');
    }

    public function destroy(Workout $workout)
    {
        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن التمرين يخص هذا المدرب
        if ($workout->trainer_id !== $trainer->id) {
            abort(403);
        }

        $workout->delete();

        return redirect()->route('trainer.workouts.index')->with('success', 'تم حذف التمرين بنجاح');
    }
}
