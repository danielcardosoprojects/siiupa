<?php
header('Content-type: text/html; charset=utf-8');

include_once('../../bd/conectabd.php');
$busca = new BD;

$id = $_GET['id'];
$campo = $_GET['campo'];
$valor = utf8_decode($_GET['valor']);
$sql = "UPDATE u940659928_siupa.tb_ferias SET $campo='$valor' WHERE id=$id";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();
//echo "<div id='$campo' data-ide='$id'>$valor</div>";
echo $valor;

?>