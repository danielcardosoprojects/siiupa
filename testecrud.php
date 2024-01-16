<?php
$bd = new PDO('mysql:host=localhost;dbname=db_rh','root','apuapu');
$sql = "SELECT * FROM u940659928_siupa.tb_setor";
$recebe = $bd->prepare($sql);
$recebe->execute();
echo "<pre>";
if($recebe->rowCount() >0) {
    $resultado = $recebe->fetchAll();
    $resultado = (object) $resultado;
    print_r($resultado);
    
    foreach($resultado as $setor){
        $setor = (object) $setor;
        echo $setor->setor;
        echo "<br>";

    }
}


