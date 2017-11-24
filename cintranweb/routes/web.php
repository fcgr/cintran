<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/placas', 'PlacaController@listar');
Route::get('/placas/{id?}', 'PlacaController@detalhes')->where(['id' => '[0-9]+']);
Route::get('/placas/cadastrar', 'PlacaController@cadastrar');
Route::post('/placas/adicionar', 'PlacaController@adicionar');


