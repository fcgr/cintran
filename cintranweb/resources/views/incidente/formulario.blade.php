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

<form action="/incidentes/{{ isset($incidente) ? 'atualizar/' .  $incidente->id  : 'cadastrar' }}" method="post">
	<input type="hidden" name="_token" value="{{csrf_token()}}">

	<div class="form-group col-lg-12">
		<label>Placa relacionada:</label>		
		<select name="placa_id" class="form-control">
			@foreach($placas as $p)
				<option value="{{$p['codigo']}}" @if( isset($incidente) && ($p['codigo'] == $incidente->placa_id) ) selected="selected" @endif>
					{{$p['texto']}} 
				</option>
			@endforeach

		</select>
	</div>

	<div class="form-group col-lg-12">
		<label>Tipo de Obstrução</label>		
		<select name="tipo" class="form-control">
			<option value="selecione">Selecione</option>
			<option value="1" @if(isset($incidente) && $incidente->tipo == 1) selected="selected" @endif >Parcial</option>
			<option value="2" @if(isset($incidente) && $incidente->tipo == 2) selected="selected" @endif>Total</option>
		</select>
	</div>

	<div class="form-check col-lg-12">
		<label class="form-check-label">Resolvido		
			<input type="checkbox" class="form-check-input" name="resolvido" @if(isset($incidente) && $incidente->resolvido == 1) checked="checked" @endif  }} ></input>
		</label>
	</div>

	<button class="btn btn-primary btn-block" type="submit"> {{isset($placa) ? 'Atualizar' : 'Adicionar'}}</button>	

</form>

@stop
