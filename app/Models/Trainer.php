<?php
// app/Models/Trainer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'email',
        'password',
        'phone',
        'specialization',
        'experience',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    // الحصول على عدد الأعضاء النشطين
    public function activeMembersCount()
    {
        return $this->members()->where('status', true)->count();
    }

    // الحصول على التمارين لهذا الأسبوع
    public function weeklyWorkouts()
    {
        return $this->workouts()
            ->whereBetween('day', [now()->startOfWeek(), now()->endOfWeek()])
            ->with('member')
            ->get()
            ->groupBy('day');
    }

    // الحصول على الإحصائيات
    public function getStats()
    {
        return [
            'total_members' => $this->members()->count(),
            'active_members' => $this->members()->where('status', true)->count(),
            'total_workouts' => $this->workouts()->count(),
            'weekly_workouts' => $this->workouts()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count()
        ];
    }
}
