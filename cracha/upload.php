<?php

header('Content-Type: application/json');

// ======================================
// CONFIGURAÇÃO
// ======================================

$diretorio = __DIR__ . '/uploads/';
$urlRelativa = 'uploads/';

$apiUrl = "https://siupa.com.br/siiupa/api/api.php/records/tb_cracha";

// ======================================
// VALIDAÇÃO DO ARQUIVO
// ======================================

if (!isset($_FILES['foto'])) {
    echo json_encode(['success' => false, 'error' => 'Nenhuma imagem enviada']);
    exit;
}

$arquivo = $_FILES['foto'];

if ($arquivo['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Erro no upload da imagem']);
    exit;
}

// ======================================
// VALIDAR TIPO REAL
// ======================================

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $arquivo['tmp_name']);
finfo_close($finfo);

$tiposPermitidos = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

if (!array_key_exists($mime, $tiposPermitidos)) {
    echo json_encode(['success' => false, 'error' => 'Tipo de imagem não suportado']);
    exit;
}

// ======================================
// GERAR NOME DO ARQUIVO
// ======================================

$nomeCompleto = $_POST['nome_completo'] ?? 'usuario';

$nomeLimpo = preg_replace('/[^a-zA-Z0-9]/', '_', $nomeCompleto);
$nomeLimpo = strtolower($nomeLimpo);

$dataHora = date('Y-m-d_H-i-s');
$extensao = $tiposPermitidos[$mime];

$nomeArquivo = $nomeLimpo . '_' . $dataHora . '.' . $extensao;

if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
}

$caminhoFisico = $diretorio . $nomeArquivo;
$caminhoArquivo = $urlRelativa . $nomeArquivo;

// ======================================
// MOVER ARQUIVO
// ======================================

if (!move_uploaded_file($arquivo['tmp_name'], $caminhoFisico)) {
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar imagem']);
    exit;
}

// ======================================
// ENVIAR PARA API
// ======================================

$dados = [
    "nome_completo" => $_POST["nome_completo"] ?? "",
    "nome_cracha"   => $_POST["nome_cracha"] ?? "",
    "cpf"           => $_POST["cpf"] ?? "",
    "telefone"      => $_POST["telefone"] ?? "",
    "cargo"         => $_POST["cargo"] ?? "",
    "foto"          => $caminhoArquivo
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

$response = curl_exec($ch);

if ($response === false) {
    echo json_encode([
        'success' => false,
        'error' => 'Erro CURL: ' . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// ======================================
// VERIFICAR RESPOSTA DA API
// ======================================

if ($httpCode !== 200 && $httpCode !== 201) {
    echo json_encode([
        'success' => false,
        'error' => 'Erro ao cadastrar na API',
        'api_response' => $response
    ]);
    exit;
}

// ======================================
// SUCESSO TOTAL
// ======================================

echo json_encode([
    'success' => true,
    'message' => 'Cadastro realizado com sucesso',
    'file' => $nomeArquivo,
    'path' => $caminhoArquivo,
    'api_response' => json_decode($response, true)
]);