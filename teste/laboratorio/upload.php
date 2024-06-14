<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'exames/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        // Verifica se o arquivo é uma imagem
        $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo 'Tipo de arquivo não permitido. Por favor, envie uma imagem (JPEG, PNG, GIF).';
            exit;
        }

        // Verifica o tamanho do arquivo (limite de 2MB)
        if ($_FILES['file']['size'] > 2 * 1024 * 1024) {
            echo 'O tamanho do arquivo não deve exceder 2MB.';
            exit;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo 'Upload realizado com sucesso!';
        } else {
            echo 'Erro ao realizar upload.';
        }
    } else {
        echo 'Nenhum arquivo enviado ou erro no upload.';
    }
} else {
    echo 'Método de requisição inválido.';
}
?>
