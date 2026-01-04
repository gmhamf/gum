<?php
// app/Http/Controllers/Trainer/MemberController.php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $trainer = auth()->guard('trainer')->user();

        $query = $trainer->members()->with(['subscriptions', 'trainer']);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('member_code', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $members = $query->orderBy('created_at', 'desc')->get();
        $search = $request->search;
        $selectedStatus = $request->status;

        return view('trainer.members.index', compact('members', 'search', 'selectedStatus'));
    }

    public function create()
    {
        return view('trainer.members.create');
    }

    public function store(Request $request)
    {
        $trainer = auth()->guard('trainer')->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'member_code' => 'required|string|max:50|unique:members',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'status' => 'required|boolean',
            'join_date' => 'required|date',
        ]);

        $data['trainer_id'] = $trainer->id;

        Member::create($data);

        return redirect()->route('trainer.members.index')->with('success', 'تم إضافة العضو بنجاح.');
    }

    public function show(Member $member)
    {
        $trainer = auth()->guard('trainer')->user();
        if ($member->trainer_id !== $trainer->id) abort(403);

        $member->load(['subscriptions', 'workouts', 'diets', 'progress']);
        $activeSubscription = $member->activeSubscription();
        $daysRemaining = $activeSubscription ? $activeSubscription->end_date->diffInDays(now()) : 0;

        return view('trainer.members.show', compact('member', 'activeSubscription', 'daysRemaining'));
    }

    public function edit(Member $member)
    {
        $trainer = auth()->guard('trainer')->user();
        if ($member->trainer_id !== $trainer->id) abort(403);

        return view('trainer.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $trainer = auth()->guard('trainer')->user();
        if ($member->trainer_id !== $trainer->id) abort(403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'member_code' => 'required|string|max:50|unique:members,member_code,' . $member->id,
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'status' => 'required|boolean',
            'join_date' => 'required|date',
        ]);

        $member->update($data);

        return redirect()->route('trainer.members.index')->with('success', 'تم تعديل بيانات العضو بنجاح.');
    }

    public function destroy(Member $member)
    {
        $trainer = auth()->guard('trainer')->user();
        if ($member->trainer_id !== $trainer->id) abort(403);

        $member->delete();
        return redirect()->route('trainer.members.index')->with('success', 'تم حذف العضو.');
    }
}
