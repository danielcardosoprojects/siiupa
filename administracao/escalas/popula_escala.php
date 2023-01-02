<?php


$json = '{
    "d4": "DN¹",
    "d8": "DN¹",
    "d12": "DN¹",
    "d16": "DN¹",
    "d20": "DN¹",
    "d24": "DN¹",
    "d28": "DN¹"
}';

$array = json_decode($json, true);


include_once('../../bd/conectabd.php');
$busca = new BD;
$busca = $busca->conecta();
$id = $_GET['id'];
$json = "{".$_GET['json']."}";

$array = json_decode($json, true);

foreach($array as $valor) {
    $dia = key($array);
//    $valor = $dia;
    $sql = "UPDATE db_rh.tb_escala_funcionario SET $dia='$valor' WHERE id=$id";
    
    
    
    $insere = $busca->prepare($sql);
    $insere->execute();
    echo $valor;
    next($array);
    
    
}


?>