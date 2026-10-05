<?php
header('Content-Type: application/json');

$afastamentosUrl = 'https://upasistema.online/siiupa/api/rh/api.php/records/tb_afastamento?order=id,desc&join=tb_funcionario';
$cargosUrl = 'https://upasistema.online/siiupa/api/rh/api.php/records/tb_cargo';
$tiposAfastamentosUrl = 'https://upasistema.online/siiupa/api/rh/api.php/records/tb_afastamentos';
$setoresUrl = 'https://upasistema.online/siiupa/api/rh/api.php/records/tb_setor';

function fetchData($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result, true);
}

$afastamentos = fetchData($afastamentosUrl);
$cargos = fetchData($cargosUrl);
$tiposAfastamentos = fetchData($tiposAfastamentosUrl);
$setores = fetchData($setoresUrl);

$response = [
    'afastamentos' => $afastamentos,
    'cargos' => $cargos,
    'tiposAfastamentos' => $tiposAfastamentos,
    'setores' => $setores
];

echo json_encode($response);
