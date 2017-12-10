@extends('layout.principal')
@section('conteudo')


	<h1>Lista de placas</h1>
	<a href="{{action('PlacaController@novo')}}" class="pull-right btn btn-sm btn-primary">Novo</a> 

	@if( !count($placas) )
		<div class="alert alert-danger">
			Não há placas cadastradas!
		</div>
	@else
		
		<table class="table">
			<tbody>
				@foreach($placas as $p)
					<tr class="{{$p->status == 'BAD' ? 'danger' :  'success' }}">
						<td>{{$p->id}} </td>
				<!--		
						<td>
							<a href="/placas/{{$p->id}}"> 
								Visualizar
							</a>
						</td>
				-->
						<td>
							<a href="/placas/{{$p->id}}"> 
								Editar
							</a>
						</td>
						<td>
							<a href="/placas/excluir/{{$p->id}}"> 
								Excluir
							</a>
						</td>
					</tr>	
				@endforeach
			</tbody>	
		</table>
	@endif

	@if( isset($msg) )
		<div class="alert alert-{{isset($tipo) ? $tipo : 'success'}}" > 
			<strong>{{$msg}}</strong>
		</div>
	@endif

@stop
