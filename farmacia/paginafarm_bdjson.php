<?php

header('Content-Type: application/json');

include("../bd/conectabd.php");

$acao = $_GET['acao'];
if ($acao == "carregaCategoria") {

    $query = "SELECT id, categoria FROM db_farmacia.tb_farmcategoria order by categoria ASC";

    $json = new BD;

    $json = $json->consultaArray($query);

    $arr = [];

    foreach ($json as $categoria) {
        $id = $categoria['id'];
        $cat = utf8_encode($categoria['categoria']);
        $arr[] = array("id" => "$id", "categoria" => "$cat");
    }


    echo json_encode($arr);
} elseif ($acao == "carregaGenero") {
    $query = "SELECT id, genero FROM db_farmacia.tb_farmgenero";
    $json = new BD;

    $json = $json->consultaArray($query);

    $arr = [];
    foreach ($json as $genero) {
        $id = $genero['id'];
        $gen = utf8_encode($genero['genero']);
        $arr[] = array("id" => "$id", "genero" => "$gen");
    }
    echo json_encode($arr);
} elseif ($acao == "cosmos") {
    $bc = $_GET['bc'];


    $url = 'https://api.cosmos.bluesoft.com.br/gtins/' . $bc . '.json';
    $agent = 'Cosmos-API-Request';
    $headers = array(
        "Content-Type: application/json",
        "X-Cosmos-Token: kNY4zApZG9FIe3tSnInAzA"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);

    $data = curl_exec($curl);
    if ($data === false || $data == NULL) {
        var_dump(curl_error($curl));
    } else {
        $object = json_decode($data);

        echo ($data);
    }

    curl_close($curl);



?>

<?php
} elseif ($acao == "buscamed") {

    $bc = $_GET['bc'];
    $bc = "$bc";
    $url = 'https://www.googleapis.com/customsearch/v1/siterestrict?q=' . $bc . '&cx=a718aa3469db44866&key=AIzaSyCYE1OVt_wb32wpBx0745ir2Ocl6TPteoo';

    $agent = 'Cosmos-API-Request';
    $headers = array(
        "Authorization: Guest",

    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
    $data = curl_exec($curl);
    if ($data === false || $data == NULL) {
        var_dump(curl_error($curl));
    } else {
        $object = json_decode($data);

        echo ($data);
    }
    // <li class="list-info-prod-right">Maleato de Enalapril</li>
    // $pattern = '#<h1 class="title-black">(.*?)"><br>#';
    // var_dump($pattern);
    // preg_match($pattern, $data, $resultado);


    curl_close($curl);
} elseif ($acao == "buscamedApp") {

    $bc = $_GET['bc'];

    $url = 'https://www.googleapis.com/customsearch/v1/?q=' . $bc . '&cx=a718aa3469db44866&key=AIzaSyCYE1OVt_wb32wpBx0745ir2Ocl6TPteoo';
    $agent = 'Cosmos-API-Request';
    $headers = array(
        "Authorization: Guest",

    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
    $data = curl_exec($curl);
    if ($data === false || $data == NULL) {
        var_dump(curl_error($curl));
    } else {
        $object = json_decode($data);

        //echo ($data);
    }
    // <li class="list-info-prod-right">Maleato de Enalapril</li>
    //$pattern = '#"title": (.*?)"#';
    //preg_match($pattern, $data, $resultado);
    //var_dump($resultado);
    $filtra = json_decode($data);
    $reconverte = json_encode($filtra->items[0]);
    echo ($reconverte);

    curl_close($curl);
} elseif ($acao = "carregaItem") {
    $iditem = $_GET['iditem'];
    $sql = "SELECT * FROM db_farmacia.tb_farmitem WHERE id='$iditem'";
    
    $json = new BD;
    $json = $json->consultaArray($sql);
    
    $json[0]['nome'] = utf8_encode(($json[0]['nome']));
    $json[0]['historico_nome'] = utf8_encode(($json[0]['historico_nome']));
    
    
    echo (json_encode($json[0]));
    
    
}
