<!DOCTYPE HTML>

<html lang=pt-br>

<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" type="text/css" href="/hubhorta/libs/css/style.css">

	<!-- Latest compiled and minified Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
	<link rel="icon" href="/hubhorta/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="/hubhorta/scripts.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const senhaInput = document.getElementById('senha');
			const gatoLogo = document.getElementById('gato');
		
			senhaInput.addEventListener('focus', () => {
				gatoLogo.src = '/hubhorta/images/1.gif';
			});

			senhaInput.addEventListener('blur', () => {
				gatoLogo.src = '/hubhorta/images/2.gif';
			});
		});
	</script>

</head>

<body>
	<header>
		<div class="pull-left" id="logo">
			<!--<img id="gato" src="/hubhorta/images/gato.png" />-->
		</div>

		<div class="pull-left" id="nomeLogo">
			<h1>HubHorta</h1>
			<!--<img id="nomeLogo" src="/hubhorta/images/nome.png" height=80/>-->
		</div>
		<h1></h1>
		<div class="user-info pull-right">
			<div class="col-md-10" id="login_info">
				<?php
				include_once "comum.php";
				if (is_session_started() === FALSE) {
					session_start();
				}

				if (isset($_SESSION["nome_usuario"])) {
					// Informações de login
					echo "<span class='btn-logout'>Você está logado como " . $_SESSION["nome_usuario"];
					echo "<a href='/hubhorta/executa_logout.php'> Logout </a></span>";
				} else {
					echo "<span class='btn-logout'><a href='/hubhorta/login.php'> Efetuar <br>Login </a></span>";
				}
				?>
			</div>

			<div id="sidebar-carrinho" class="sidebar"></div>
		</div>
	</header>


</body>
