<?php

Route::get('/', 'PlacaController@listar');

Route::get('/placas', 'PlacaController@listar');
Route::get('/placas/novo', 'PlacaController@novo');
Route::post('/placas/cadastrar', 'PlacaController@cadastrar');
Route::get('/placas/{id?}', 'PlacaController@editar')->where(['id' => '[0-9]+']);
Route::post('/placas/atualizar/{id}', 'PlacaController@atualizar')->where(['id' => '[0-9]+']);
Route::get('/placas/excluir/{id}', 'PlacaController@excluir')->where(['id' => '[0-9]+']);

Route::get('/incidentes', 'IncidenteController@index');
Route::get('/incidentes/novo', 'IncidenteController@novo');
Route::post('/incidentes/cadastrar', 'IncidenteController@cadastrar');
Route::get('/incidentes/{id?}', 'IncidenteController@editar')->where(['id' => '[0-9]+']);
Route::post('/incidentes/atualizar/{id}', 'IncidenteController@atualizar')->where(['id' => '[0-9]+']);

Auth::routes();
Route::get('funcionarios', 'FuncionarioController@index');
Route::get('/funcionarios/{id?}', 'FuncionarioController@editar')->where(['id' => '[0-9]+']);
Route::post('/funcionarios/atualizar/{id}', 'FuncionarioController@atualizar')->where(['id' => '[0-9]+']);
Route::get('/funcionarios/excluir/{id}', 'FuncionarioController@excluir')->where(['id' => '[0-9]+']);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/transmissao',  'TransmissaoController@index');
Route::post('/transmissao', 'TransmissaoController@index');