<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@include_once("../../bd/conectabd.php");
$acao = $_GET['acao'];
if ($acao == 'busca') {

    $nome = $_GET['nome'];
    $busca_setor = $_GET['setor'];
    if ($busca_setor == "") {
        $sqlsetor = "";
    } else {
        $sqlsetor = "AND fk_setor = $busca_setor";
    }
    $chave = uniqid();

    $buscanome = $nome; //preg_replace('/[^[:alnum:]_]/', '',$nome);
    $bdaddservidor = new BD;
    $sqladdservidor = "SELECT c.titulo, f.* FROM u940659928_siupa.tb_funcionario as f INNER JOIN u940659928_siupa.tb_cargo AS c ON (f.fk_cargo = c.id) WHERE f.nome like '%$buscanome%' AND (f.status = 'ATIVO' OR f.status = 'TERCEIRIZADO') $sqlsetor ORDER BY f.nome ASC";
    $resultadoaddservidor = $bdaddservidor->consulta($sqladdservidor);
    echo "<input type='hidden' value='$chave' id='chaveAddServ'>";
    echo "<table class='table table-bordered table-striped table-hover' style='font-size:29px !important'><theady><th>Nome</th><th>Cargo</th></theady><tbody>";
    foreach ($resultadoaddservidor as $addservidor) {
        echo "<tr>";
        echo "<td><a class='escolhido' data-idescolhido='$addservidor->id' data-nome='$addservidor->nome' data-cargo='$addservidor->titulo' href='#'>" . utf8_encode($addservidor->nome) . "</a><td>" . utf8_encode($addservidor->titulo) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
if ($acao == 'insere') {
    $id = $_GET['id'];
    $idservidor = $_GET['idservidor'];
    $mes = $_GET['mes'];
    $ano = $_GET['ano'];

    $busca = new BD;
    $sql = "INSERT INTO u940659928_siupa.tb_escala_funcionario (fk_escala, fk_funcionario, mes, ano) VALUES ('$id','$idservidor','$mes','$ano')";

    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();
    echo "Adicionado com sucesso!";
} elseif ($acao == 'inseretodos') {
    $id = $_GET['id'];
    $mes = $_GET['mes'];
    $ano = $_GET['ano'];
    $todos = $_POST['todos'];
    $chave = $_POST['chave'];
    
    $todos = json_encode($todos, true);
    // Configurar o endpoint da API
$url = "https://www.siupa.com.br/siiupa/api/api.php/records/tb_escala_funcionario";

// Inicializar o cURL
$ch = curl_init($url);

// Configurar opções do cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retornar resposta como string
curl_setopt($ch, CURLOPT_POST, true);          // Usar método POST
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",          // Definir cabeçalho Content-Type
    "Accept: application/json"                 // Indicar que queremos uma resposta em JSON
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $todosJson); // Enviar o JSON no corpo da requisição

// Executar a requisição e obter a resposta
$response = curl_exec($ch);

// Verificar se ocorreu algum erro
if (curl_errno($ch)) {
    echo "Erro na requisição: " . curl_error($ch);
} else {
    // Exibir a resposta da API
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "Código HTTP: $httpCode\n";
    echo "Resposta: $response";
}

// Fechar o cURL
curl_close($ch);
} else {
    echo "Atualize a página!";
}
