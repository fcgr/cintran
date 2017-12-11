<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/css/app.css">
	<link href="/css/custom.css" rel="stylesheet">
	<title>Cintran</title>
</head>
<body>
	<div class="container">

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/placas"> Controle de Placas</a>
				</div>
				
				<ul class="nav navbar-nav navbar-right ">

					@guest
					<!--	<li><a href="{{ route('login') }}">Login</a></li>	
					   	<li><a href="{{ route('register') }}">Registrar</a></li> -->
					@else
						<li><a href="{{action('PlacaController@listar')}}">Placas</a></li>
						<li><a href="{{action('IncidenteController@index')}}">Incidentes</a></li>
						@if(Auth::user()->gerente)
							<li><a href="{{action('FuncionarioController@index')}}">Funcionários</a></li>
						@endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>

							<ul class="dropdown-menu">
								<li>
									<a href="{{ route('logout') }}"
										onclick="event.preventDefault();
													document.getElementById('logout-form').submit();">
										Logout
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
						</li>
					@endguest
				</ul>
			</div>			
		</nav>

		@yield('conteudo')

		<footer class="footer">
			<p>© ESS - CinTrân.</p>
		</footer>

	</div>
	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
