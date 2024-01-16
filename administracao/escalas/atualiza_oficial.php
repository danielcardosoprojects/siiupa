<?php
include_once('../../bd/conectabd.php');
$busca = new BD;
$busca2 = new BD;

$idescala = $_GET['idescala'];
$valor= $_GET['valor'];

$sql = "UPDATE u940659928_siupa.tb_escala_funcionario SET oficial='$valor' WHERE fk_escala='$idescala'";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();


$sql2 = "UPDATE u940659928_siupa.tb_escalas SET oficial='$valor' WHERE id='$idescala'";


$busca2 = $busca2->conecta();
$insere2 = $busca2->prepare($sql2);
$insere2->execute();
//echo $idescala;

?>