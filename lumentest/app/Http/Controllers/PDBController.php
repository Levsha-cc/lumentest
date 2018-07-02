<?php

namespace App\Http\Controllers;

use App\PDB;
use DB;

class PDBController extends Controller
{
    public function showDB()
    {
        $info = (new PDB)->dbInfo();
        return view('dbInfo', compact('info'));
    }

    public function importLogs()
    {
        $info = (new PDB)->importLogs()->dbInfo();
        return view('dbInfo', compact('info'));
    }

    public function showTable()
    {
        $data = (new PDB)->tableData();
        return view('table', compact('data'));
    }

    public function showTableJS()
    {
        $data = (new PDB)->tableData();
        return view('tablejs', compact('data'));
    }

    public function showTableJSON()
    {
        $limit = 25;//(int)$_GET['limit'];
        $offset = (int)$_GET['start'];

        $data = (new PDB)->tableData($limit, $offset);

        $result = [
            'success' => true,
            'total' => DB::table('users')->count(),
            'data' => $data
        ];
        return $result;
    }
}
