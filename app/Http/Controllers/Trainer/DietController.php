<?php
// app/Http/Controllers/Trainer/DietController.php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diet;
use App\Models\Member;

class DietController extends Controller
{
    public function index(Request $request)
    {
        $trainer = auth()->guard('trainer')->user();

        $query = Diet::whereHas('member', function($q) use ($trainer) {
            $q->where('trainer_id', $trainer->id);
        })->with('member');

        // البحث باسم الوجبة أو العضو
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('meal_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
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

        $diets = $query->orderBy('day', 'desc')->orderBy('time')->paginate(10);


        $members = $trainer->members()->where('status', true)->get();
        $search = $request->search;
        $selectedDay = $request->day;
        $selectedMember = $request->member_id;

        return view('trainer.diets.index', compact(
            'diets',
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

        return view('trainer.diets.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'day' => 'required|string',
            'meal_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'calories' => 'nullable|integer|min:0',
            'time' => 'required|string|max:50'
        ]);

        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن العضو يتبع هذا المدرب
        $member = $trainer->members()->where('id', $request->member_id)->first();
        if (!$member) {
            return back()->withErrors(['member_id' => 'هذا العضو غير مسجل لديك']);
        }

        Diet::create([
            'member_id' => $request->member_id,
            'day' => $request->day,
            'meal_name' => $request->meal_name,
            'description' => $request->description,
            'calories' => $request->calories,
            'time' => $request->time
        ]);

        return redirect()->route('trainer.diets.index')->with('success', 'تم إضافة الوجبة بنجاح');
    }

    public function edit(Diet $diet)
    {
        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن الوجبة تخص عضو يتبع هذا المدرب
        if ($diet->member->trainer_id !== $trainer->id) {
            abort(403);
        }

        $members = $trainer->members()->where('status', true)->get();

        return view('trainer.diets.edit', compact('diet', 'members'));
    }

    public function update(Request $request, Diet $diet)
    {
        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن الوجبة تخص عضو يتبع هذا المدرب
        if ($diet->member->trainer_id !== $trainer->id) {
            abort(403);
        }

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'day' => 'required|string',
            'meal_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'calories' => 'nullable|integer|min:0',
            'time' => 'required|string|max:50'
        ]);

        $diet->update($request->all());

        return redirect()->route('trainer.diets.index')->with('success', 'تم تحديث الوجبة بنجاح');
    }

    public function destroy(Diet $diet)
    {
        $trainer = auth()->guard('trainer')->user();

        // التأكد من أن الوجبة تخص عضو يتبع هذا المدرب
        if ($diet->member->trainer_id !== $trainer->id) {
            abort(403);
        }

        $diet->delete();

        return redirect()->route('trainer.diets.index')->with('success', 'تم حذف الوجبة بنجاح');
    }
}
