<?php
// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'trainer_id',
        'name',
        'member_code',
        'password',
        'email',
        'phone',
        'weight',
        'height',
        'age',
        'gender',
        'join_date',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    // دالة للبحث باستخدام gym_id و member_code
    public function findForPassport($username)
    {
        return $this->where('member_code', $username)->first();
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    public function diets()
    {
        return $this->hasMany(Diet::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // الحصول على الاشتراك النشط
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->latest()
            ->first();
    }

    // الحصول على الجداول التدريبية لهذا الأسبوع
    public function weeklyWorkouts()
    {
        return $this->workouts()
            ->whereBetween('day', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('day')
            ->get()
            ->groupBy('day');
    }

    // الحصول على النظام الغذائي لهذا الأسبوع
    public function weeklyDiets()
    {
        return $this->diets()
            ->whereBetween('day', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('day')
            ->get()
            ->groupBy('day');
    }

    // الحصول على آخر تقدم
    public function latestProgress()
    {
        return $this->progress()->latest()->first();
    }
}
