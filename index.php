<?php
header('Content-Type: text/html; charset=utf-8');
include("bd/conectabd.php");
include('../conexao/verifica_login.php');

?>

<!DOCTYPE html>
<html>


<head>
	<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
	<title>SIUPA</title>
	<link rel="stylesheet" href="/siiupa/css/style.css" />
	<link rel="shortcut icon" href="/siiupa/favicon.ico" type="image/x-icon" />

	<link rel="apple-touch-icon" href="iconified/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="/siiupa/iconified/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="/siiupa/iconified/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="/siiupa/iconified/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="/siiupa/iconified/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="/siiupa/iconified/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="/siiupa/iconified/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/siiupa/iconified/apple-touch-icon-152x152.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="/siiupa/iconified/apple-touch-icon-180x180.png" />

	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">


	<!-- TAILWIND CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	<!-- JQUERY -->



	<script src="/siiupa/js/jquery-3.6.0.js"></script>

	<script src="/siiupa/js/popper.min.js"></script>
	<link rel="stylesheet" href="/siiupa/js/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" href="/siiupa/js/jquery-ui-1.12.1/jquery-ui.theme.min.css">
	<script src="/siiupa/js/jquerymask/src/jquery.mask.js"></script>
	<script src="/siiupa/js/jquery-ui-1.12.1/jquery-ui.js"></script>
	<script src="/siiupa/js/jquery.table2excel.js"></script>

	<link rel="stylesheet" href="/siiupa/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
	<script src="/siiupa/bootstrap-5.0.0-beta3-dist/js/bootstrap.min.js"></script>

	<!-- AXIOS -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<!-- jquery confim -->
	<!-- <link rel="stylesheet" href="/siiupa/js/jquery-confirm.min.css">
	<script src="/siiupa/js/jquery-confirm.min.js"></script> -->

	<link rel="stylesheet" href="/siiupa/widgets/jqueryconfirm/jquery-confirm.min.css">
	<script src="/siiupa/widgets/jqueryconfirm/jquery-confirm.min.js"></script>

	<!-- jquery upload -->



	<!-- editor de texto -->
	<script src="/siiupa/js/jquery-te-1.4.0.min.js"></script>
	<link rel="stylesheet" href="/siiupa/css/jquery-te-1.4.0.css">

	<!-- thead float -->
	<script src="/siiupa/js/jquery.floatThead.min.js"></script>

	<script type="text/javascript" src="/siiupa/js/script.js"></script>
	<script type="text/javascript" src="/siiupa/js/digitalBush-jquery.maskedinput-9672630/dist/jquery.maskedinput.js"></script>

	<link href="/siiupa/css/google_icon.css" rel="stylesheet">

	<!-- GRAFICOS -->

	<link rel="stylesheet" href="/siiupa/css/chartist.min.css">
	<script src="/siiupa/js/chartist.min.js"></script>
	<script src="/siiupa/js/graficos/chartist-plugin-pointlabels.min.js"></script> <!-- ROTULOS DE DADOS -->

	<!-- DATA TABLES -->
	<script type="text/javascript" src="/siiupa/js/dataTables/datatables.min.js"></script>


	<!-- Gera tabela em excel xlsx -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


	<link href="/siiupa/js/dataTables/datatables.min.css" rel="stylesheet">

	<!-- Notificações  -->
	<script src="/siiupa/js/notify/notify.min.js"></script>

	<!-- Icones BOotstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
	<style>
		body {
			margin: 0;
			padding: 2px;
			height: 100%;
			background-color: #2c2c2c;

		}

		#topo {



			background-color: transparent;

			text-align: center;
			padding: 0px;
		}

		#conteudo {
			padding: 0px;
			background-color: #555555;
			background-image: url('/siiupa/imagens/bg-home.jpg');
			background-size: cover;


		}



		#subconteudo {
			padding: 15px;
			background-color: #fff;
			margin-top: 2px;



		}

		#icons div.ui-icon {
			float: left !important;
			margin: 0 4px;
		}

		#barratitulo {
			padding: 4px;
			overflow: hidden;
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			font-family: ARIAL;
			color: #333;

		}

		@media print {
			.notprint {
				visibility: hidden;
			}
		}

		#carregador {
			animation: is-rotating 1s infinite;
			border: 6px solid #e5e5e5;
			border-radius: 50%;
			border-top-color: #51d4db;
			height: 50px;
			width: 50px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -50px;
			margin-top: -50px;
			text-align: center;
			z-index: 1000;
			/* Faz com que fique sobre todos os elementos da página */
		}

		@keyframes is-rotating {
			to {
				transform: rotate(1turn);
			}
		}

		.navbar {
			background-color: #444;
			/* Subtle background color */
		}

		.navbar-brand img {
			height: 32px;
			/* Consistent logo size */
		}

		.nav-link {
			color: #b0b0b0;
			/* Neutral text color */
			padding: 8px 12px;
			/* Consistent padding */
		}

		.nav-link:hover {
			color: #007bff;
			/* Hover effect */
		}

		.btn-outline-info,
		.btn-outline-danger {
			border-width: 1px;
			/* Thinner border */
			padding: 4px 8px;
			/* Smaller buttons */
		}

		.btn-outline-info {
			color: #007bff;
			border-color: #007bff;
		}

		.btn-outline-info:hover {
			background-color: #007bff;
			color: #fff;
		}

		.btn-outline-danger {
			color: #dc3545;
			border-color: #dc3545;
		}

		.btn-outline-danger:hover {
			background-color: #dc3545;
			color: #fff;
		}
	</style>
	<script>
		$(document).on({
			ajaxStart: function() {
				//console.log('carregando');
				$('html,body').css('cursor', 'progress');
				$('#carregador').show();
			},
			ajaxStop: function() {
				//console.log('carregado');
				$('html,body').css('cursor', 'auto');
				$('#carregador').hide();
				//		
			}
		});
		$(function() {
			var bootstrapButton = $.fn.button.noConflict()
			$.fn.bootstrapBtn = bootstrapButton;

			$('#carregador').hide();




			//$("#conteudo").load("administracao/paginaadministracao.php");  






		});
	</script>


</head>

<body>

	<div id="carregador"></div>

	<!-- COLOQUE A DIV "loading" ACIMA DE TODO O CONTEUDO DO SITE (ABAIXO DA <body>) -->


	<!-- <nav class="navbar navbar-expand-lg navbar-light" style="background-color:whitesmoke;">
		<div class="container">
			<a class="navbar-brand" href="/siiupa/"><img src="/siiupa/imagens/siiupa.png" height="32px" style="float:left" /></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-link active">
						<a href="/siiupa/?setor=adm" class="btn btn-primary">Administração</a>
					</li>
					<li class="nav-link active">
						<a href="/siiupa/servidor/dist" class="btn btn-primary">Servidor</a>
					</li>
					<li class="nav-link active"> 
						<a id="btnFarmacia" href="/siiupa/farmacia/	" class="btn btn-primary">Farmácia</a>
					</li>
					<li class="nav-link active">
						<a id="abreRecepcao" href="#" class="btn btn-primary">Recepção</a>
					</li>


				</ul>

				<span>
					<img src="/siiupa/administracao/rh/<?php echo $_SESSION['idServidorUsuario']; ?>/foto_perfil" height="75px" class="rounded-circle">
					<span class="btn btn-outline-info">Usuário: <?php echo utf8_encode($_SESSION['nomeusuario']); ?>
						<img src="/siiupa/imagens/icones/nivel.svg" width="20px"><?php echo $_SESSION['nivel']; ?>
					</span>
					<a class="btn btn-outline-info" href='/conexao/redefinirsenha.php'>Troca senha</a>
					<a class="btn btn-outline-info" href="/conexao/logout.php" id="sair">Sair</a>
				</span>
			</div>
		</div>

	</nav> -->
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="/siiupa/">
				<img src="/siiupa/imagens/siiupa.png" height="32" alt="Logo">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a href="/siiupa/?setor=adm" class="nav-link">Administração</a>
					</li>
					<li class="nav-item">
						<a href="/siiupa/servidor/dist" class="nav-link">Servidor</a>
					</li>
					<li class="nav-item">
						<a id="btnFarmacia" href="/siiupa/farmacia/" class="nav-link">Farmácia</a>
					</li>
					<li class="nav-item">
						<a id="abreRecepcao" href="#" class="nav-link">Recepção</a>
					</li>
				</ul>
				<div class="d-flex align-items-center" style="color:#b0b0b0">
					<img src="/siiupa/administracao/rh/<?php echo $_SESSION['idServidorUsuario']; ?>/foto_perfil" height="32" class="rounded-circle" alt="Perfil">
					<span class="ms-2 me-3">
						<?php echo $_SESSION['nomeusuario']; ?>
						<img src="/siiupa/imagens/icones/nivel.svg" width="16" alt="Nível">
						<?php echo $_SESSION['nivel']; ?>
					</span>
					<a class="btn btn-outline-info btn-sm me-2" href='/conexao/redefinirsenha.php'>Troca senha</a>
					<a class="btn btn-outline-danger btn-sm" href="/conexao/logout.php" id="sair">Sair</a>
				</div>
			</div>
		</div>
	</nav>
	<?php

	?>



	<div id="conteudo" class="container-xxl">
		<?php
		if (isset($_GET['setor'])) {
			$setor = $_GET['setor'];
			if ($setor == "adm") {

				include("administracao/paginaadministracao.php");
			} elseif ($setor == "farm") {

				include("farmacia/paginafarmacia.php");
			}
		} else {
			$conteudo = "home.php";
			include("home.php");
		}



		?>


	</div>


	<!-- Footer -->
	<footer class="bg-secondary text-center text-white">
		<!-- Grid container -->
		<div class="container p-4">
			<!-- Section: Social media -->
			<section class="mb-4">
				<!-- Facebook -->
				<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

				<!-- Twitter -->
				<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

				<!-- Google -->
				<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

				<!-- Instagram -->
				<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

				<!-- Linkedin -->
				<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

				<!-- Github -->
				<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
			</section>
			<!-- Section: Social media -->



			<!-- Section: Text -->
			<section class="mb-4">
				<p>

					UPA PORTE III CASTANHAL GOVERNADOR ALMIR GABRIEL
					CNES: 7474423

					Endereço: Rodovia BR 316, KM 65, S/N.
					Bairro: Cristo Redentor
					Referência: Esquina com a Travessa Raimundo Nonato Vasconcelos.
					CEP: 68.742-795

					CNPJ: 07.918.201/0001-11
					FUNDO MUNICIPAL DE SAÚDE DE CASTANHAL

					Coordenadas Geográficas
					LATITUDE
					1º17’48.3’’S (Sul)

					LONGITUDE
					47º57’01.8’’W (Oeste)

					ELEVAÇÃO AO NÍVEL DO MAR: 50 MTS

				</p>
			</section>
			<!-- Section: Text -->

		</div>
		<!-- Grid container -->

		<!-- Copyright -->
		<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
			<div style="text-align:center;">Copyright - 2021/2024 - Daniel Cardoso de Oliveira</div>
		</div>
		<!-- Copyright -->
	</footer>
	<!-- Footer -->





</body>

</html>