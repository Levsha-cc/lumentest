<?php

namespace App\Http\Controllers;

use App\PDB;
use DB;

class PDBController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function showDB()
    {
        $oPDB = new PDB();
        $info = $oPDB->dbInfo();

        return view('dbInfo', ['info' => $info]);
    }

    public function importLogs()
    {
        $oPDB = new PDB();
        $info = $oPDB->importLogs()->dbInfo();

        return view('dbInfo', ['info' => $info]);
    }

    public function showTable()
    {
        $oPDB = new PDB();
        $data = $oPDB->tableData();

        return view('table', compact('data'));
    }

    public function showTableJS()
    {
        $oPDB = new PDB();
        $data = $oPDB->tableData();

        return view('tablejs', compact('data'));
    }

    public function showTableJSON()
    {
        $oPDB = new PDB();

        $limit = 25;//(int)$_GET['limit'];
        $offset = (int)$_GET['start'];

        $data = $oPDB->tableData($limit, $offset);

        $result = [
            'success' => true,
            'total' => DB::table('users')->count(),
            'data' => $data
        ];
        return $result;
    }


}
