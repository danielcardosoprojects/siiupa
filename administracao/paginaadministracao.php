<?php
if(!isset($_SESSION['nivel'])){
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";

	die;
}elseif($_SESSION['nivel'] != 1) {
    echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";
    die;
} 
?>
<script type="text/javascript" src="/siiupa/js/script.js"></script>
<script>
	$(function() {


		$("#beditarFUNCIONARIO").click(function() {
			alert();
			$('#subconteudo').load($(this).attr('href'));
			sessionStorage.setItem('linkanterior', $(this).attr('href'));

		});


	});
</script>
<div id="topo" class="notprint">
	<a class="navbar-brand" href="#">Administrativo</a>
	<a id="abrerh" href="?setor=adm&sub=rh" class="btn btn-outline-info abrerh">Recursos Humanos</a>
	<a id="abrerh" href="?setor=adm&sub=producao" class="btn btn-outline-info">Produção e Estatística</a>
	<a id="abreadministracao" href="administracao/paginaadministracao.php" class="btn btn-outline-info">Administração</a>
	<a href="/siiupa/enviararquivo.php" class="btn btn-outline-info">Arquivos</a>
</div>
<div id="subconteudo">

	<?php
	if (isset($_GET['sub'])) {
		$sub = $_GET['sub'];
		if ($sub == "rh") {
			include("paginarh.php");
		} elseif ($sub == "rhperfil") {
			include("paginarh_perfil.php");
		} elseif ($sub == "rh_perfil") {
			include("paginarh_perfil2.php");
		}  elseif ($sub == "rhferias") {
			include("paginarh_ferias.php");
		} elseif ($sub == "rhfolhas") {
			include("pagina_rh_folhas.php");
		} elseif ($sub == "rhfolhasmodifica") {
			include("paginarh_folhas_criareditar.php");
		} elseif ($sub == "rhfolhaexibe") {
			include("pagina_rh_folha.php");
		} elseif ($sub == "rhfolhaadicionaservidor") {
			include("pagina_rh_folha_adicionaservidor.php");
		} elseif ($sub == "producao") {
			include("pagina_producao.php");
		} elseif ($sub == "rhescalas") {
			include("pagina_escalas.php");
		} elseif ($sub == "rhescala_exibe") {
			include("pagina_escala_exibe.php");
		} elseif ($sub == "rhalimentacao") {
			include("pagina_rh_alimentacao.php");
		}
	} else {
	?>
		<div class="row">
			<div class="col-sm-6">
				<div class="card" style="width: 18rem;">
					<img src="imagens/rhicones.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Recursos Humanos</h5>
						<a href="?setor=adm&sub=rh" class="btn btn-primary abrerh">Abrir</a>
					</div>
				</div>


			</div>
			<div class="col-sm-6">
				<div class="card float-right" style="width: 18rem;">
					<img src="imagens/graphs.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Produção e Estatística</h5>
						<a href="?setor=adm&sub=producao" class="btn btn-primary abrerh">Abrir</a>
					</div>
				</div>
			</div>
		</div>
	<?php

	}

	?>

</div>