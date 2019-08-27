<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Observed;
use Carbon\Carbon;

class ReceiveController extends Controller
{

    private $observed;

    public function __construct(Observed $observed)
    {
        $this->observed = $observed;
    }

    public function receive(Request $request)
    {
        $now = new Carbon('now');
        $addressArr = $this->makeAddressArr($request->all(), $now);

        $this->observed->insert($addressArr);

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

