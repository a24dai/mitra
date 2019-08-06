<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Observed;

class ReceiveController extends Controller
{

    private $observed;

    public function __construct(Observed $observed)
    {
        $this->observed = $observed;
    }

    public function receive(Request $request)
    {
        $addressArr = $this->makeAddressArr($request->all(), '2019-08-06 14:10:00');

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

