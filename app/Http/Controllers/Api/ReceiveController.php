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

        $attendedMacs = $this->user->fetchAttendedUsersAddress($this->now->format('Y-m-d'));

        $workingMacs = array_intersect($macs, $users);
        $newMacs = array_diff($workingMacs, $attendedMacs);

        $attendanceArr = $this->makeAttendanceArr($newMacs);
        $this->attendance->insert($attendanceArr);

        dd('done');

        return $addressArr;
    }

    public function sendAttendanceData()
    {
        $attendees = $this->user->fetchDailyAttendees($this->now->format('Y-m-d'));
        dd($attendees);
    }

    private function makeAttendanceArr($macs)
    {
        $attendanceArr = [];
        foreach ($macs as $mac) {
            $attendanceArr[] = [
                'user_id'    => $this->user->fetchUserIdByAddress($mac),
                'start_time' => $this->now
            ];
        }
        return $attendanceArr;
    }

}

