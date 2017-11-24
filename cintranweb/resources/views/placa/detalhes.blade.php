@extends('layout.principal')
@section('conteudo')

<h1>Detalhes da Placa {{$placa->id}}</h1>

<ul>
	<li><b>Latitude:</b> {{$placa->latitude}} </li>
	<li><b>Longitude:</b> {{$placa->logitude}} </li>
	<li><b>Status:</b> {{$placa->status}} </li>
</ul>

@stop