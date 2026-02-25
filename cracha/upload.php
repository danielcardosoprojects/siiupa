<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Belem');

$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Validar tipo
$permitidos = ["image/jpeg", "image/png", "image/jpg"];
if (!in_array($_FILES["foto"]["type"], $permitidos)) {
    die("Formato inválido. Envie JPG ou PNG.");
}

// ===== TRATAMENTO DO NOME =====
$nomeCompleto = $_POST["nome_completo"];
$nomeCompleto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeCompleto);
$nomeCompleto = preg_replace('/[^A-Za-z0-9 ]/', '', $nomeCompleto);
$nomeCompleto = str_replace(' ', '_', trim($nomeCompleto));

$dataHora = date('Y-m-d_H-i-s');
$nomeArquivo = $nomeCompleto . "_" . $dataHora . ".jpg";
$caminhoArquivo = $uploadDir . $nomeArquivo;

// ===== PROCESSAMENTO DA IMAGEM =====
$tmpFile = $_FILES["foto"]["tmp_name"];
$info = getimagesize($tmpFile);

$larguraOriginal = $info[0];
$alturaOriginal = $info[1];
$tipo = $info[2];

// Criar imagem original
switch ($tipo) {
    case IMAGETYPE_JPEG:
        $imagemOriginal = imagecreatefromjpeg($tmpFile);
        break;
    case IMAGETYPE_PNG:
        $imagemOriginal = imagecreatefrompng($tmpFile);
        break;
    default:
        die("Tipo de imagem não suportado.");
}

// ===== REDIMENSIONAMENTO =====
$maxLargura = 1000;

if ($larguraOriginal > $maxLargura) {
    $novaLargura = $maxLargura;
    $novaAltura = ($alturaOriginal / $larguraOriginal) * $novaLargura;
} else {
    $novaLargura = $larguraOriginal;
    $novaAltura = $alturaOriginal;
}

$imagemRedimensionada = imagecreatetruecolor($novaLargura, $novaAltura);

imagecopyresampled(
    $imagemRedimensionada,
    $imagemOriginal,
    0, 0, 0, 0,
    $novaLargura,
    $novaAltura,
    $larguraOriginal,
    $alturaOriginal
);

// ===== SALVAR COMO JPG QUALIDADE 85 =====
imagejpeg($imagemRedimensionada, $caminhoArquivo, 85);

imagedestroy($imagemOriginal);
imagedestroy($imagemRedimensionada);

// ===== ENVIAR PARA API =====
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

if ($response === false) {
    echo "Erro CURL: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

echo "Cadastro enviado com sucesso!";
?>