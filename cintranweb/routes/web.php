<?php

Route::get('/', 'PlacaController@listar');
Route::get('/placas', 'PlacaController@listar');
Route::get('/placas/novo', 'PlacaController@novo');
Route::post('/placas/cadastrar', 'PlacaController@cadastrar');
Route::get('/placas/{id?}', 'PlacaController@editar')->where(['id' => '[0-9]+']);
Route::post('/placas/atualizar/{id}', 'PlacaController@atualizar')->where(['id' => '[0-9]+']);
Route::get('/placas/excluir/{id}', 'PlacaController@excluir')->where(['id' => '[0-9]+']);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/transmissao',  'TransmissaoController@index');
Route::post('/transmissao', 'TransmissaoController@index');