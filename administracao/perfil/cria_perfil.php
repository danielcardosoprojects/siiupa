<?php
header('Content-type: text/html; charset=utf-8');

include_once('../../bd/conectabd.php');
function pega($entrada)
{
    if (isset($_GET[$entrada])) {
        return $_GET[$entrada];
    }
    return null;
}
$busca = new BD;



$nome = utf8_decode(pega('nome'));
$fk_cargo =pega('fk_cargo');
$fk_setor  = pega('fk_setor');
$vinculo = pega('vinculo');
$status = pega('status');

$sql = "INSERT INTO `db_rh`.`tb_funcionario` (`nome`, `fk_cargo`, `fk_setor`, `vinculo`, `status`) VALUES ('$nome', '$fk_cargo', '$fk_setor','$vinculo','$status')";


$busca = $busca->conecta();
$insere = $busca->prepare($sql);
$insere->execute();
//echo "<div id='$campo' data-ide='$id'>$valor</div>";
echo $busca->lastInsertId();

?>