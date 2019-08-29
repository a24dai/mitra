<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $dates = [
        'start_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

