<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

$fcpfn = $_GET['cpf'];
$ncpf = manterApenasNumeros($fcpfn);


function gerarToken($username, $password) {
    $url = "https://apionline.layoutsistemas.com.br/api/token/";

    $data = array(
        'username' => $username,
        'password' => $password
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Erro ao obter o token');
    }

    return json_decode($result)->access;
}
function manterApenasNumeros($str) {
    $resultado = '';

    for ($i = 0; $i < strlen($str); $i++) {
        $caractereAtual = $str[$i];

        if (is_numeric($caractereAtual)) {
            $resultado .= $caractereAtual;
        }
    }

    return $resultado;
}

// Substitua 'danielcardoso' e 'c*123c12' pelos seus valores reais
$username = 'danielcardoso';
$password = 'c*123c12';

// Gerar token
$token = gerarToken($username, $password);

// Substitua $fcpfn pelos seus valores reais


// URL da API e cabeçalho de autorização
$apiURL = "https://apionline.layoutsistemas.com.br/api/matriculas/?cpf=$ncpf&entidade=796";
$authorizationHeader = "Bearer $token";

// Fazer uma solicitação GET usando a função file_get_contents
$response = file_get_contents($apiURL, false, stream_context_create([
    'http' => [
        'header' => "Authorization: $authorizationHeader\r\n"
    ]
]));

if ($response === FALSE) {
    die('Erro na solicitação');
}

// Manipular os dados da resposta
$data = json_decode($response);


if ($data->results && count($data->results) > 0) {
    $ultimaMatricula = 0;

    if (count($data->results) == 1) {
        $ultimaMatricula = str_replace('-', '', $data->results[0]->matricula);
    } else {
        foreach ($data->results as $item) {
            $matriculaAtual = str_replace('-', '', $item->matricula);

            if ($matriculaAtual < 3000000 && $matriculaAtual > $ultimaMatricula) {
                $ultimaMatricula = $matriculaAtual;
            }
        }
    }

    // Separando os dígitos
    $partePrincipal = substr($ultimaMatricula, 0, -1);
    $digitoVerificador = substr($ultimaMatricula, -1);

    // Criando o formato desejado
    $ultimaMatriculaFormatada = "$partePrincipal-$digitoVerificador";

    // Imprimir os dados no formato JSON
    $userData = array('ultimaMatricula' => $ultimaMatriculaFormatada);
    $jsonData = json_encode($userData);
    header('Content-Type: application/json');
    echo json_encode($userData);
} else {
    echo json_encode(array('error' => 'CPF não encontrado na resposta da API.'));
}
