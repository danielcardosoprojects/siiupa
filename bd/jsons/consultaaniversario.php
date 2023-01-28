<?php
include("../conectabd.php");

$consultBirth = new BD;
$dia = date("d");
// $dia = '19';
$mes = date("m");
$sql = "SELECT f.nome, DATE_FORMAT(f.data_nasc,'%d/%m') as data_nasc FROM db_rh.tb_funcionario as f where f.status='ATIVO' and DAY(f.data_nasc) = '$dia' and MONTH(f.data_nasc) = '$mes'";

header('Content-Type: application/json');
echo json_encode($consultBirth->consulta($sql));

?>