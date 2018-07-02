<?php

namespace App\Http\Controllers;

use App\Logs;

class LogsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function generateLogs()
    {
        $oLogs = new Logs();
        $info = $oLogs->generateLogs(200)->info();

        return view('logsInfo', ['info' => $info]);
    }

    public function showLogs()
    {
        $oLogs = new Logs();
        $info = $oLogs->info();
        return view('logsInfo', ['info' => $info]);
    }

}
