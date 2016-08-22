<?php

namespace Judgement\Http\Controllers;

use Carbon\Carbon;

class Time extends Controller
{
    public function getCurrentTime()
    {
        $now = Carbon::now();
        $date = $now->toDateString();
        $time = $now->toTimeString();
        return response()->json([
            'date' => $date,
            'time' => $time
        ]);
    }
}
