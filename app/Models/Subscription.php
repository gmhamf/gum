<?php
// app/Models/Subscription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'type',
        'start_date',
        'end_date',
        'amount',
        'status'
    ];
protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
