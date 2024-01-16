<?php
include_once('../../bd/conectabd.php');
$busca = new BD;

$id = $_POST['id'];
$valor= $_POST['legenda'];
$sql = "UPDATE u940659928_siupa.tb_escalas SET legenda='$valor' WHERE id=$id";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();
echo "<div id='legenda' data-ide='$id'>$valor</div>";

?>