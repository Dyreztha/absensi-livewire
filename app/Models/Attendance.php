<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'clock_in_at',
        'clock_out_at',
        'clock_in_lat',
        'clock_in_lng',
        'clock_out_lat',
        'clock_out_lng',
        'clock_in_photo_path',
        'clock_out_photo_path',
        'status',
    ];

    protected $casts = [
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
