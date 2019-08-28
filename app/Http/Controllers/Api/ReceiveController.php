<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Observed;
use App\Models\User;
use Carbon\Carbon;

class ReceiveController extends Controller
{
    private $now;
    private $observed;
    private $user;

    public function __construct(Observed $observed, User $user)
    {
        $this->now = new Carbon('now');
        $this->observed = $observed;
        $this->user = $user;
    }

    public function receive(Request $request)
    {
        $macs = $request->all();
        $users = $this->user->pluck('mac_address')->toArray();

        $addressArr = $this->makeAddressArr($macs);
        $this->observed->insert($addressArr);

        $attendees = array_intersect($macs, $users);
        $attendanceArr = $this->makeAttendanceArr($attendees);


        dd($attendanceArr);

        return $addressArr;
    }

    private function makeAddressArr($macs)
    {
        $addressArr = [];
        foreach ($macs as $mac) {
            $addressArr[] = [
                'mac_address'   => $mac,
                'observed_time' => $this->now,
            ];
        }
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

