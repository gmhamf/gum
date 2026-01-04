<?php
// app/Http/Controllers/Gym/GymTrainerController.php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trainer;
use Illuminate\Support\Facades\Hash;

class TrainerController  extends Controller
{
    public function index()
    {
        $gym = auth()->guard('gym')->user();
        $trainers = Trainer::where('gym_id', $gym->id)->get();
        return view('gym.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('gym.trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255'
        ]);

        $gym = auth()->guard('gym')->user();

        Trainer::create([
            'gym_id' => $gym->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'experience' => $request->experience,
            'status' => true
        ]);

        return redirect()->route('gym.trainers.index')->with('success', 'تم إضافة المدرب بنجاح');
    }

    public function edit(Trainer $trainer)
    {
        return view('gym.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email,' . $trainer->id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255'
        ]);

        $trainer->update($request->all());

        return redirect()->route('gym.trainers.index')->with('success', 'تم تحديث بيانات المدرب بنجاح');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('gym.trainers.index')->with('success', 'تم حذف المدرب بنجاح');
    }
}
