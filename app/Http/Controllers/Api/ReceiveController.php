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

        $workingUsers = $this->user->fetchWorkingUsersAddress($this->now->format('Y-m-d'));
        $workingAttendees = $this->makeWorkingUserArr($workingUsers);

        $attendees = array_intersect($macs, $users);
        $newAttendees = array_diff($attendees, $workingAttendees);

        $attendanceArr = $this->makeAttendanceArr($newAttendees);
        $this->attendance->insert($attendanceArr);

        dd('done');

        return $addressArr;
    }

    private function makeAttendanceArr($addresses)
    {
        $attendanceArr = [];
        foreach ($addresses as $address) {
            $attendanceArr[] = [
                'user_id'    => $this->user->fetchUserIdByAddress($address),
                'start_time' => $this->now,
            ];
        }
        return $attendanceArr;
    }

    private function makeWorkingUserArr($addressArr)
    {
        $workingUserArr = [];
        if (!empty($addressArr)) {
            foreach ($addressArr as $address) {
                $workingUserArr[] = $address['mac_address'];
            }
        }
        return $workingUserArr;
    }

}

