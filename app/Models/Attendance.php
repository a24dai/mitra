<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

