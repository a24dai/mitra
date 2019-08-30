<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mac_address', 'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function dailyAttendance()
    {
        return $this->hasOne(Attendance::class, 'user_id')->whereDate('start_time', Carbon::today()->format('Y-m-d'));
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /**
     * @param string $address
     * @return int
     */
    public function fetchUserIdByAddress($address)
    {
        return $this->where('mac_address', $address)
                    ->first()->id;
    }

    public function fetchAttendedUsersAddress($today)
    {
        return $this->join('attendance', 'users.id', '=', 'attendance.user_id')
                    ->select('users.mac_address')
                    ->whereDate('start_time', $today)
                    ->pluck('mac_address')
                    ->toArray();
    }

    public function fetchDailyAttendees($today)
    {
        return $this->join('attendance', 'users.id', '=', 'attendance.user_id')
                    ->select('users.name', 'attendance.start_time')
                    ->whereDate('start_time', $today)
                    ->oldest('start_time')
                    ->get();
    }

}

