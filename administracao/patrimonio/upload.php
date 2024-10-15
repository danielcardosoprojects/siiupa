<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diretório onde as imagens serão salvas
    $uploadDir = 'uploads/';
    $fotoName = '';

    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Gerar um nome único para a foto
        $fotoName = uniqid() . '_' . basename($_FILES['foto']['name']);
        $fotoPath = $uploadDir . $fotoName;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath)) {
            // Retorna uma resposta JSON
            echo json_encode(['success' => true, 'message' => 'Upload realizado com sucesso!', 'filename' => $fotoName]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Falha ao mover o arquivo.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado ou erro no upload.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
