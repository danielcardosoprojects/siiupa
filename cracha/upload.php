<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Validação tamanho (2MB)
if ($_FILES["foto"]["size"] > 2 * 1024 * 1024) {
    die("A imagem deve ter no máximo 2MB.");
}

// Validação tipo
$permitidos = ["image/jpeg", "image/png", "image/jpg"];
if (!in_array($_FILES["foto"]["type"], $permitidos)) {
    die("Formato inválido. Envie JPG ou PNG.");
}

// ===== TRATAMENTO DO NOME =====
$nomeCompleto = $_POST["nome_completo"];

// Remove acentos
//$nomeCompleto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeCompleto);

// Remove caracteres especiais
$nomeCompleto = preg_replace('/[^A-Za-z0-9 ]/', '', $nomeCompleto);

// Substitui espaços por underline
$nomeCompleto = str_replace(' ', '_', trim($nomeCompleto));

// Data e hora atual
date_default_timezone_set('America/Belem');
$dataHora = date('Y-m-d_H-i-s');

// Extensão original
$ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

// Nome final do arquivo
$nomeArquivo = $nomeCompleto . "_" . $dataHora . "." . $ext;

$caminhoArquivo = $uploadDir . $nomeArquivo;

if (move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoArquivo)) {

    $dados = [
        "nome_completo" => $_POST["nome_completo"],
        "nome_cracha" => $_POST["nome_cracha"],
        "cpf" => $_POST["cpf"],
        "telefone" => $_POST["telefone"],
        "cargo" => $_POST["cargo"],
        "foto" => $caminhoArquivo
    ];

    $apiUrl = "https://siupa.com.br/siiupa/api/api.php/records/tb_cracha";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

    $response = curl_exec($ch);

if($response === false){
    echo "Erro CURL: " . curl_error($ch);
    exit;
}

echo "Resposta API: " . $response;
curl_close($ch);
    

    echo "Cadastro enviado com sucesso!";
} else {
    echo "Erro ao fazer upload da imagem.";
}
?>