<?php
if (!isset($_SESSION['nivel'])) {
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";

	die;
} elseif ($_SESSION['nivel'] != 1) {
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";
	die;
}
?>