<?php

header('Content-Type: application/json');

// pasta onde salvar
$diretorio = 'uploads/';

if (!isset($_FILES['foto'])) {
    echo json_encode(['success' => false, 'error' => 'Nenhuma imagem enviada']);
    exit;
}

$arquivo = $_FILES['foto'];

// verifica erro de upload
if ($arquivo['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Erro no upload da imagem']);
    exit;
}

// valida tipo real da imagem
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $arquivo['tmp_name']);
finfo_close($finfo);

$tiposPermitidos = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

if (!array_key_exists($mime, $tiposPermitidos)) {
    echo json_encode(['success' => false, 'error' => 'Tipo de imagem não suportado']);
    exit;
}

// pega nome completo enviado pelo form
$nomeCompleto = $_POST['nome_completo'] ?? 'usuario';

// limpa nome para arquivo
$nomeLimpo = preg_replace('/[^a-zA-Z0-9]/', '_', $nomeCompleto);

// data e hora
$dataHora = date('Y-m-d_H-i-s');

// monta nome final
$extensao = $tiposPermitidos[$mime];
$nomeArquivo = $nomeLimpo . '_' . $dataHora . '.' . $extensao;

$caminhoCompleto = $diretorio . $nomeArquivo;

// cria pasta se não existir
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
}

// move arquivo
if (!move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar imagem']);
    exit;
}

echo json_encode([
    'success' => true,
    'file' => $nomeArquivo,
    'path' => $caminhoCompleto
]);