<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/cintranweb/public/css/app.css">
	<link href="/cintranweb/public/css/custom.css" rel="stylesheet">
	<title>Cintran</title>
</head>
<body>
	<div class="container">

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/produtos"> Controle de Placas</a>
				</div>
				
				<ul class="nav navbar-nav navbar-right ">	
					<li><a href="{{action('PlacaController@listar')}}">Listagem</a></li>
					<li><a href="{{action('PlacaController@cadastrar')}}">Novo</a></li>
				</ul>
			</div>			
		</nav>

		@yield('conteudo')

		<footer class="footer">
			<p>© ESS - CinTrân.</p>
		</footer>

	</div>
</body>
</html>
