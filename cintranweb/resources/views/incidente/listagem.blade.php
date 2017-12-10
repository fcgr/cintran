@extends('layout.principal')
@section('conteudo')

	<h1>Lista de incidentes</h1>
	<a href="{{action('IncidenteController@novo')}}" class="pull-right btn btn-sm btn-primary">Novo</a> 

	@if( !count($incidentes) )
		<div class="alert alert-danger">
			Não há incidentes cadastrados!
		</div>
	@else		
		<table class="table">
			<tbody>
				@foreach($incidentes as $i)
					<tr class="{{$i->resolvido == '0' ? 'danger' :  'success' }}">
						<td>{{$i->placa_id}} </td>
						<td>
							<a href="/incidentes/{{$i->id}}"> 
								Editar
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
