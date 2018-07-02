<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $oLogs = new App\Logs();
    $info = $oLogs->info();
    $oPDB = new App\PDB();
    $dbInfo = $oPDB->dbInfo();

    return view('home', compact('info', 'dbInfo'));
});

// логи
$router->get('/logs', ['uses' => 'LogsController@showLogs']);
$router->get('/logs_create', ['uses' => 'LogsController@generateLogs']);

// БД
$router->get('/db', ['uses' => 'PDBController@showDB']);
$router->get('/db_import', ['uses' => 'PDBController@importLogs']);

// таблица ExtJS
$router->get('/table', ['uses' => 'PDBController@showTable']);
$router->get('/tablejs', ['uses' => 'PDBController@showTableJS']);
$router->get('/tablejs/json', ['uses' => 'PDBController@showTableJSON']);

