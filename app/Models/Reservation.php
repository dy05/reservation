<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'day',
        'startHour',
        'endHour',
        'description',
        'user_id'
    ];

    protected $casts = [
        'day' => 'date',
        'startHour' => 'time',
        'endHour' => 'time',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
