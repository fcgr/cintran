@extends('layout.principal')
@section('conteudo')

	@if( !count($placas) )
		<div class="alert alert-danger">
			Não há placas cadastradas!
		</div>
	@else		

		<h1>Lista de placas</h1>
		
		<table class="table">
			<tbody>
				@foreach($placas as $p)
					<tr class="{{$p->status == 'BAD' ? 'danger' :  'success' }}">
						<td>{{$p->id}} </td>
						
						<td>
							<a href="/cintranweb/public/placas/{{$p->id}}"> 
								Visualizar
							</a>
						</td>
						<td>
							<a href="/placas/excluir/{{$p->id}}"> 
								Excluir
							</a>
						</td>
						<td>
							<a href="/placas/editar/{{$p->id}}"> 
								Editar
							</a>
						</td>
					</tr>	
				@endforeach
			</tbody>	
		</table>
	@endif

	@if( old('nome') )
		<div class="alert alert-success" > 
			<strong>Sucesso!</strong> Produto {{ old('nome') }} adicionado com sucesso! 
		</div>
	@endif

@stop
