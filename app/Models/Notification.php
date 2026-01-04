<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'title',
        'message',
        'seen'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
