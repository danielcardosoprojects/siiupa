

<script type="text/javascript" src="/siiupa/vendor/select2/select2/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="/siiupa/vendor/select2/select2/dist/css/select2.min.css">


<style>
	.lapis {
		display: none;
	}

	.bt_menu_farm {
		border-radius: 20rem;
	}
</style>
<?php

if (!isset($_SESSION['nivel'])) {
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";

	die;
} elseif ($_SESSION['nivel'] != 2 && $_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 3) {
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";
	die;
}

function adm()
{
	if ($_SESSION['nivel'] == 1) {
		return true;
	} else {
		return false;
	}
}

function urlAtual()
{
	return filter_input(INPUT_SERVER, 'QUERY_STRING');
}

function sanitize_title($title)
{
	// substitui espaços por "-"
	$title = preg_replace('#\s+#', '-', $title);

	// faz a transliteração pra ASCII
	$title = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);

	// remove qualquer outra coisa inválida da url
	$title = preg_replace('#[^a-zA-Z0-9_-]+#', '', $title);

	return $title;
}

?>

<div id="dialogScan" title="Basic dialog">
</div>
<div id="dialogMovimento" title="Basic dialog">
</div>
<div id="dialogItem" title="Basic dialog">
</div>
<div id="dialogSetor" title="Basic dialog">
</div>
<div id="dialogProfissional" title="Basic dialog">
</div>
<?php

?>
<script>
	$("#dialogScan").dialog({
		autoOpen: false,
		modal: true,
		title: 'SCAN',
		width: 'auto'
	});
	$("#dialogScan").load("/siiupa/farmacia/scan.php");
	$("#escanear").click(function(e) {
		e.preventDefault();

		$("#dialogScan").dialog("open");



	});


	$("#dialogMovimento").dialog({
		autoOpen: false,
		modal: true,
		title: 'Movimento',
		width: 'auto',
		maxHeight: 600,

	});
	$("#dialogItem").dialog({
		autoOpen: false,
		modal: true,
		title: 'Item',
		width: 'auto',
	})
	$("#dialogProfissional").dialog({
		autoOpen: false,
		modal: true,
		title: 'Profissional',
		width: 'auto',
	})
	$("#dialogSetor").dialog({
		autoOpen: false,
		modal: false,
		title: 'Setor',
		width: 'auto',
	})
</script>

<div id="subconteudo">
	<h3><img src="/siiupa/imagens/icones/farmacia.svg" height="30px"> Farmácia</h3>
	<a href="/siiupa/farmacia/" class="btn btn-primary btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/home2.png" height="20px"> Inicio</a>
	<a href="/siiupa/farmacia/estoque/" class="btn btn-info btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/estoque.svg" height="20px"> Estoque</a>

	<?php
	if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 1) {
	?>
		<script>
			var lapis = true;
		</script>
		<a href="/siiupa/farmacia/movimento/entrada" id="cadastrarMovimentoE" class="btn btn-success btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/movimento.svg" height="20px">Entrada de Item</a>
		<a href="/siiupa/farmacia/movimento/saida" id="cadastrarMovimentoS" class="btn btn-danger btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/movimento.svg" height="20px">Saída de Item</a>
		<a href="/siiupa/farmacia/movimentos/" id="filtrarMovimentoS" class="btn btn-warning btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/calendario2.svg" height="20px">Filtrar movimentos</a>
		<a href="/siiupa/farmacia/ranking/" id="filtrarMovimentoS" class="btn btn-secondary btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/rank.fw.png" height="20px"> Ranking</a>

		<?php

		$val = new BD;

		$data = new DateTime();
		$hoje = $data->format('Y-m-d');

		//echo 
		$sqlVal = "SELECT date_format(e.data_validade, '%d/%m/%Y') as validade, e.lote, e.estoque, i.nome, i.id FROM u940659928_siupa.tb_farmestoque as e inner join u940659928_siupa.tb_farmitem as i on (e.item_fk = i.id) where e.estoque > 0 and data_validade <= '$hoje' order by validade ASC;";
		//echo $sqlVal;

		$val = $val->conecta();
		$rVal = $val->prepare($sqlVal);
		$rVal->execute();
		$qtdVal = $rVal->rowCount();
		?>
		<a href="/siiupa/farmacia/validade/" id="filtrarMovimentoS" class="btn btn-dark btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/sino.fw.png" height="20px"> Validade: <?= $qtdVal; ?> </a>





		<br><br>
		<a href="/siiupa/farmacia/lote" id="" class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px"> Lotes repetidos</a>     |    
		<a href="/siiupa/farmacia/item" id="janelaItem" class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px"> Itens</a>
		<a href="/siiupa/farmacia/setor" id="janelaSetor" class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/add_setor.svg" height="20px"> Setores</a>
		<a href="/siiupa/farmacia/profissional" id="janelaProfissional" class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/add_setor.svg" height="20px"> Profissionais Solicitantes</a>
		<a href="/siiupa/farmacia/profissionais" id="janelaProfissionais" class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/add_setor.svg" height="20px"> Profissionais Solicitantes 2</a>


	<?php

		//FIM MODO ESCONDE ADM
	} else {
	?>
		<script>
			var lapis = false;
		</script>

	<?php

	}
	?>
	<br><br>
	<div id="resultado"></div>
	<?php if (isset($_GET['sub'])) {
		$sub = $_GET['sub'];
		if ($sub == "entradamovimento") {
			@include("paginafarm_inserebd.php");
		} elseif ($sub == "estoque") {
			@include("paginafarm_estoque.php");
		} elseif ($sub == "movimentoentrada") {
			@include("paginafarm_cadastramovimento_entrada.php");
		} elseif ($sub == "movimentosaida") {
			@include("paginafarm_cadastramovimento_saida.php");
		} elseif ($sub == "saidamovimento") {
			@include("paginafarm_inserebd.php");
		} elseif ($sub == "item_detalhe") {
			@include("paginafarm_item_detalhe.php");
		} elseif ($sub == "movimentos") {
			@include("paginafarm_movimentos.php");
		} elseif ($sub == "ranking") {
			include("paginafarm_item_ranking.php");
		} elseif ($sub == "validade") {
			include("paginafarm_validade.php");
		} elseif ($sub == "item-entrada") {
			include("paginafarm_item_entrada.php");
		} elseif ($sub == "lote") {
			include("paginafarm_lote.php");
		} elseif ($sub == "profissionais") {
			include("paginafarm_profissionais.html");
		}
	} else {
		@include("paginafarm_home.php");
	}
	?>

</div>
<script>
	function centralizaDialog(dialog) {
		dialog.dialog({
			position: {
				my: "center",
				at: "center",
				of: window,
			}
		});
	}


	function itemCarrega(link, e) {
		e.preventDefault();
		celula = $("#" + link.id);
		pagina = celula.attr('href');
		$("#dialogItem").load(pagina);
		$("#dialogItem").dialog('open');
		centralizaDialog($("#dialogItem"));
	}

	function profissionalCarrega(link, e) {
		e.preventDefault();
		celula = $("#" + link.id);
		pagina = celula.attr('href');
		$("#dialogProfissional").load(pagina);
	}

	function setorCarrega(link, e) {
		e.preventDefault();
		celula = $("#" + link.id);
		pagina = celula.attr('href');
		$("#dialogSetor").load(pagina);
	}


	$("#cadastrarMovimento").click(function(e) {
		e.preventDefault();
		dialogMovimento = $("#dialogMovimento");
		dialogMovimento.dialog("open");

		dialogMovimento.dialog({
			position: {
				my: "center",
				at: "center",
				of: window
			}
		});
		dialogMovimento.dialog({
			close: function(event, ui) {

			}
		});
	});

	$("#janelaItem").click(function(e) {
		e.preventDefault();
		btItem = $(this);
		linkCI = btItem.attr("href");
		console.log(linkCI);
		dialogItem = $("#dialogItem");
		$.get(linkCI, function(data) {
			dialogItem.html(data);

		});
		dialogItem = $("#dialogItem");
		dialogItem.dialog("open");
		dialogItem.dialog({
			position: {
				my: "center",
				at: "center",
				of: window
			}
		});

	});
	$("#janelaProfissional").click(function(e) {
		e.preventDefault();
		btProfissional = $("#janelaProfissional");
		linkCP = btProfissional.attr("href");
		console.log(linkCP);
		dialogProfissional = $("#dialogProfissional");
		$.get(linkCP, function(data) {
			dialogProfissional.html(data);

		});
		dialogProfissional = $("#dialogProfissional");
		dialogProfissional.dialog("open");
		dialogProfissional.dialog({
			position: {
				my: "center",
				at: "center",
				of: window
			}
		});

	});
	$("#janelaSetor").click(function(e) {
		e.preventDefault();
		btSetor = $("#janelaSetor");
		linkCS = btSetor.attr("href");
		console.log(linkCS);
		dialogSetor = $("#dialogSetor");
		$.get(linkCS, function(data) {
			dialogSetor.html(data);

		});
		dialogSetor = $("#dialogSetor");
		dialogSetor.dialog("open");
		dialogSetor.dialog({
			position: {
				my: "center",
				at: "center",
				of: body
			}
		});

	});
</script>
<script type="text/javascript" src="/siiupa/js/tablesorter/jquery.tablesorter.js"></script>
<script>
	$("#ultimosMovimentos").tablesorter();
	$("#tabelaRanking").tablesorter();
</script>