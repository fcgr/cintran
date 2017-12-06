@extends('layout.principal')
@section('conteudo')

@if( count($errors) > 0 )
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $err)
				<li>{{$err}}</li>
			@endforeach
		</ul>
	</div>
@endif

<form action="/cintranweb/public/placas/{{isset($placa) ? 'atualizar' : 'adicionar'}}" method="post">
	<input type="hidden" name="_token" value="{{csrf_token()}}">

	<div>
		<label>Código</label>		
		<input class="form-control" name="id" value="{{ $placa->id or old( 'id') }}"></input>
	</div>

	<div>
		<label>Latitude</label>		
		<input class="form-control" name="latitude" value="{{ $placa->latitude or old( 'latitude') }}"></input>
	</div>

	<div>
		<label>Longitude</label>		
		<input class="form-control" name="longitude" value="{{ $placa->longitude or old( 'longitude') }}"></input>
	</div>


	<div>
		<label>Informe as placas que mandam informação para esta placa separadas por <strong>;</strong>:</label>		
		<input class="form-control" name="entrada" value="{{ $placa->entrada or old( 'entrada')  }}"></input>
	</div>

	<div>
		<label>Informe as placas que recebem informação desta placa separadas por <strong>;</strong>:</label>		
		<input class="form-control" name="saida" value="{{ $placa->saida or old( 'saida')  }}""></input>
	</div>	

	<button class="btn btn-primary btn-block" type="submit"> {{isset($produto) ? 'Atualizar' : 'Adicionar'}}</button>	

</form>

@stop
