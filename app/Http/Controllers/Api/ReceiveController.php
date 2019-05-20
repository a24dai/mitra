<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceiveController extends Controller
{
    public function receive(Request $request)
    {
        $time = $request->input('time');
        $arpStr = $request->input('arp');

        $arpArr = explode('\n?', $arpStr);

        return [
            'time' => $time,
            'arp'  => $arpArr,
        ];
    }

}

