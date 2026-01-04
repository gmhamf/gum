<?php
// app/Models/Workout.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'member_id',
        'day',
        'exercise_name',
        'sets',
        'reps',
        'rest_time',
        'notes',
        'video_url'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
