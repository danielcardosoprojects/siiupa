<?php
include("/siiupa/bd/conectabd.php");

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

echo $qtdVal;
