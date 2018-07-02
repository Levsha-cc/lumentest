<?php

// homepage
$router->get('/', function () use ($router) {
    $info = (new App\Logs)->info();
    $dbInfo = (new App\PDB)->dbInfo();

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

