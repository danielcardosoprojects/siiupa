<?php
header('Content-type: text/html; charset=utf-8');

include('../../bd/conectabd.php');
$busca = new BD;

$id = $_GET['id'];
$campo = $_GET['campo'];
$valor = utf8_decode($_GET['valor']);
$sql = "UPDATE u940659928_siupa.tb_funcionario SET $campo='$valor' WHERE id=$id";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();
//echo "<div id='$campo' data-ide='$id'>$valor</div>";

$novo = new BD;
$sqlNovo = "SELECT $campo FROM u940659928_siupa.tb_funcionario WHERE id='$id'";
$rNovo = $novo->consulta($sqlNovo);

echo utf8_encode($rNovo[0]->$campo);

?>