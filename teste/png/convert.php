<?php
echo "<pre>";
print_r($_FILES);
echo "</pre>";
// Verifica se arquivos foram enviados
if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
    $uploadDir = __DIR__ . '/uploads/';
    $convertedDir = __DIR__ . '/converted/';

    // Cria as pastas se não existirem
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    if (!is_dir($convertedDir)) mkdir($convertedDir, 0777, true);

    $files = $_FILES['files'];
    $totalFiles = count($files['name']);

    // Limita o número de arquivos a 40
    if ($totalFiles > 40) {
        die("Você pode enviar no máximo 40 arquivos.");
    }

    // Processa cada arquivo
    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = basename($files['name'][$i]);
        $uploadFilePath = $uploadDir . $fileName;
        $convertedFilePath = $convertedDir . pathinfo($fileName, PATHINFO_FILENAME) . '.png';

        // Move o arquivo para a pasta de uploads
        if (move_uploaded_file($files['tmp_name'][$i], $uploadFilePath)) {
            // Converte JPEG para PNG
            $image = imagecreatefromjpeg($uploadFilePath);
            if ($image) {
                imagepng($image, $convertedFilePath);
                imagedestroy($image);
                echo "Arquivo convertido com sucesso: <a href='$convertedFilePath' target='_blank'>$convertedFilePath</a><br>";
            } else {
                echo "Erro ao converter o arquivo: $fileName<br>";
            }
        } else {
            echo "Erro ao fazer upload do arquivo: $fileName<br>";
        }
    }
} else {
    echo "Nenhum arquivo enviado.";
}
?>