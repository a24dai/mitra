<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceiveController extends Controller
{
    public function receive(Request $request)
    {
        return [
            'time' => $request->input('time'),
            'arp'  => $request->input('arp')
        ];
    }

}

