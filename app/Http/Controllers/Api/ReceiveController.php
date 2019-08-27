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

        $addressArr = $this->makeAddressArr($macs, $now);
        $this->observed->insert($addressArr);

        dd(array_intersect($macs, $users));

        return $addressArr;
    }

    private function makeAddressArr($macs, $time)
    {
        $addressArr = [];
        foreach ($macs as $mac) {
            $addressArr[] = [
                'mac_address' => $mac,
                'observed_time' => $time,
            ];
        }
        return $addressArr;
    }

}

