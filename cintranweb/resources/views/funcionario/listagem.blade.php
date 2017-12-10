@extends('layout.principal')
@section('conteudo')

	<h1>Lista de incidentes</h1>
	<a href="/register" class="pull-right btn btn-sm btn-primary">Novo</a> 

	@if( !count($usuarios) )
		<div class="alert alert-danger">
			Não há usuários cadastrados!
		</div>
	@else		
		<table class="table">
			<tbody>
				@foreach($usuarios as $u)
					<tr>
						<td>{{$u->name}} </td>
						<td>
							<a href="/funcionarios/{{$u->id}}"> 
								Editar
							</a>
						</td>
						<td>
							<a href="/funcionarios/excluir/{{$u->id}}"> 
								Excluir
							</a>
						</td>
					</tr>	
				@endforeach
			</tbody>	
		</table>
	@endif

	@if( isset($msg) )
		<div class="alert alert-success}}" > 
			<strong>{{$msg}}</strong>
		</div>
	@endif

@stop
