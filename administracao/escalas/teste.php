<?php
include_once('../../bd/conectabd.php');
$busca = new BD;
$busca = $busca->conecta();

//print_r($_REQUEST["posicoes"]);

foreach ($_REQUEST["posicoes"] as $chave => $valor) {
    // $arr[3] será atualizado com cada valor de $arr...
    echo "oi";
    echo "{$chave} => {$valor} ";

    $sql = "UPDATE db_rh.tb_escala_funcionario SET posicao=$chave WHERE id=$valor";
    
    
 
    $insere = $busca->prepare($sql);
    $insere->execute();
}
?>