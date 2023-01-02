<?php
include_once('../../bd/conectabd.php');
$busca = new BD;

$id = $_GET['id'];
$dia = $_GET['dia'];
$valor= $_GET['valor'];
$sql = "UPDATE db_rh.tb_escala_funcionario SET $dia='$valor' WHERE id=$id";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();
echo $valor;

?>