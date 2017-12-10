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

<form action="/placas/{{ isset($placa) ? 'atualizar/' .  $placa->id  : 'cadastrar' }}" method="post">
	<input type="hidden" name="_token" value="{{csrf_token()}}">

	<div class="form-group col-lg-12">
		<label>Código</label>		
		<input class="form-control" name="id" value="{{ $placa->id or old( 'id') }}"></input>
	</div>

	<div class="form-group col-lg-12">
		<label>Latitude</label>		
		<input class="form-control" name="latitude" value="{{ $placa->latitude or old( 'latitude') }}"></input>
	</div>

	<div class="form-group col-lg-12">
		<label>Longitude</label>		
		<input class="form-control" name="longitude" value="{{ $placa->longitude or old( 'longitude') }}"></input>
	</div>

	<div class="form-group  col-lg-12">
		<label>Altura (cm)</label>		
		<input class="form-control" name="altura" value="{{ $placa->altura or old( 'altura') }}"></input>
	</div>

	<div class="form-group col-lg-12">
		<label>Tempo de Transmissão (minutos)</label>		
		<input class="form-control" name="tempo_transmissao" value="{{ $placa->tempo_transmissao or old( 'tempo_transmissao') }}"></input>
	</div>

	<div class="form-group col-lg-12">
		<label>Velocidade da Via (Km/h)</label>		
		<input class="form-control" name="velocidade_via" value="{{ $placa->velocidade_via or old( 'velocidade_via') }}"></input>
	</div>

	<div class="form-group col-lg-4">
		<label>Dependencia à esquerda:</label>		
		<select name="esqueda" class="form-control">
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}">{{$p['texto']}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-lg-4">
		<label>Dependencia em frente:</label>		
		<select name="frente" class="form-control" >
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}">{{$p['texto']}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-lg-4">
		<label>Dependencia à direita:</label>		
		<select class="form-control" name="direita">
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}">{{$p['texto']}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-lg-4">
		<label>Dependente à esquerda:</label>		
		<select name="desqueda" class="form-control">
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}">{{$p['texto']}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-lg-4">
		<label>Dependente atrás:</label>		
		<select name="dtras" class="form-control" >
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}">{{$p['texto']}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-lg-4">
		<label>Dependente à direita:</label>		
		<select class="form-control" name="ddireita">
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}">{{$p['texto']}}</option>
			@endforeach
		</select>
	</div>
	
	<button class="btn btn-primary btn-block" type="submit"> {{isset($placa) ? 'Atualizar' : 'Adicionar'}}</button>	

</form>

@stop
