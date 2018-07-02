<?php

namespace App\Http\Controllers;

use App\Logs;

class LogsController extends Controller
{
    public function generateLogs()
    {
        $c = (int)$_GET['c'];
        if (!$c || $c < 0 || $c > 1000) {
            $c = 100;
        }
        $info = (new Logs)->generateLogs($c)->info();
        return view('logsInfo', compact('info'));
    }

    public function showLogs()
    {
        $info = (new Logs)->info();
        return view('logsInfo', compact('info'));
    }

}
