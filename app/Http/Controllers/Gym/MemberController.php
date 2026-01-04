<?php
// app/Http/Controllers/Gym/GymMemberController.php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;


class MemberController extends Controller
{
    public function edit(Member $member)
    {
        $gym = auth()->guard('gym')->user();

        // التحقق من أن العضو يتبع القاعة الحالية
        if ($member->gym_id !== $gym->id) {
            abort(403);
        }

        $trainers = Trainer::where('gym_id', $gym->id)->where('status', true)->get();

        // الحصول على الاشتراك النشط
        $member->load(['subscriptions' => function($query) {
            $query->where('status', 'active')->latest();
        }]);

        $member->activeSubscription = $member->subscriptions->first();

        return view('gym.members.edit', compact('member', 'trainers'));
    }

    public function update(Request $request, Member $member)
    {
        $gym = auth()->guard('gym')->user();

        // التحقق من أن العضو يتبع القاعة الحالية
        if ($member->gym_id !== $gym->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'phone' => 'required|string|max:20',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',
            'trainer_id' => 'nullable|exists:trainers,id',
            'status' => 'required|boolean'
        ]);

        $member->update($request->all());

        return redirect()->route('gym.members.index')->with('success', 'تم تحديث بيانات المشترك بنجاح');
    }
    public function index()
{
    $members = \App\Models\Member::all(); // أو حسب الـ Gym الحالي
    return view('gym.members.index', compact('members'));
}
public function create()
{
    $trainers = \App\Models\Trainer::where('status', true)
        ->where('gym_id', auth()->user()->id) // أو حسب علاقة الجيم
        ->get();

    return view('gym.members.create', compact('trainers'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:members,email',
        'phone' => 'required|string|max:20',
        'trainer_id' => 'nullable|exists:trainers,id',
        'weight' => 'nullable|numeric',
        'height' => 'nullable|numeric',
        'age' => 'nullable|integer',
        'gender' => 'nullable|in:male,female',
        'password' => 'required|string|min:6',
    ]);
Member::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'trainer_id' => $request->trainer_id,
    'weight' => $request->weight,
    'height' => $request->height,
    'age' => $request->age,
    'gender' => $request->gender,
    'password' => Hash::make($request->password),
    'gym_id' => auth()->user()->id,
    'subscription_type' => 'monthly',
    'status' => 1,
    'member_code' => 'M' . time(),
    'join_date' => now(), // هذي تحل المشكلة
]);


    return redirect()->route('gym.members.index')->with('success', 'تم إنشاء العضو بنجاح');
}
}
