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
        $time = $request->input('time');
        $arpStr = $request->input('arp');

        preg_match_all('/([a-z0-9]+:){5}[a-z0-9]+/', $arpStr, $matchs);

        $addressArr = $this->makeAddressArr($matchs[0], $time);

        $this->observed->insert($addressArr);

        return 'completed';
    }

    private function makeAddressArr($arpArr, $time)
    {
        $addressArr = [];
        foreach ($arpArr as $arp) {
            $addressArr[] = [
                'mac_address' => $arp,
                'observed_time' => $time,
            ];
        }
        return $addressArr;
    }

}

