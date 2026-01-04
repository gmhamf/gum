<?php
// app/Models/Progress.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'date',
        'weight',
        'height',
        'chest',
        'waist',
        'arms',
        'thighs',
        'note',
        'image_before',
        'image_after'
    ];

    // تحويل التاريخ إلى كائن Carbon تلقائيًا
    protected $casts = [
        'date' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
