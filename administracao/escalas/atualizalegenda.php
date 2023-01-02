<?php
include_once('../../bd/conectabd.php');
$busca = new BD;

$id = $_GET['id'];
$valor= $_GET['legenda'];
$sql = "UPDATE db_rh.tb_escalas SET legenda='$valor' WHERE id=$id";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();
echo "<div id='legenda' data-ide='$id'>$valor</div>";

?>