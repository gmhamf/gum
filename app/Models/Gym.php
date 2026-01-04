<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ← هذا السطر هو المفتاح
use Illuminate\Notifications\Notifiable;

class Gym extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'subscription_type',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // العلاقات
    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function subscriptions()
    {
        return $this->hasManyThrough(Subscription::class, Member::class);
    }
}
