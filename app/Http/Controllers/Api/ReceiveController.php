<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class ReceiveController extends Controller
{
    private $now;
    private $user;
    private $attendance;

    public function __construct(User $user, Attendance $attendance)
    {
        $this->now = new Carbon('now');
        $this->user = $user;
        $this->attendance = $attendance;
    }

    public function receive(Request $request)
    {
        $macs = $request->all();
        $users = $this->user->pluck('mac_address')->toArray();

        $attendees = array_intersect($macs, $users);
        $attendanceArr = $this->makeAttendanceArr($attendees);

        $this->attendance->insert($attendanceArr);

        dd('done');

        return $addressArr;
    }

    private function makeAttendanceArr($addresses)
    {
        $attendanceArr = [];
        foreach ($addresses as $address) {
            $attendanceArr[] = [
                'user_id' => $this->user->fetchUserIdByAddress($address),
                'start_time' => $this->now,
            ];
        }
        return $attendanceArr;
    }

}

