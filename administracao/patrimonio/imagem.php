<?php
require '../../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

// Obter o nome da imagem do parâmetro GET
$imagem = $_GET['imagem'];

// Construir o caminho completo para a imagem
$caminho = 'uploads/' . htmlspecialchars($imagem);

try {
    // Carregar a imagem
    $img = Image::make($caminho);

    // Redimensionar a imagem
    $img->resize(null, 200, function ($constraint) {
        $constraint->aspectRatio();
    });

    // Definir o tipo de conteúdo e enviar a imagem
    header('Content-Type: image/jpeg');
    echo $img->encode('jpeg');
} catch (Exception $e) {
    // Tratar erros (imagem não encontrada, formato inválido, etc.)
    echo 'Erro ao processar a imagem: ' . $e->getMessage();
}
