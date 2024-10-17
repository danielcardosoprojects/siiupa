<?php
require '../../vendor/autoload.php';


use Imagine\Image\Box;
use Imagine\Gd\Imagine; // Para GD; para Imagick, use Imagine\Imagick\Imagine

try {
    $imagine = new Imagine();
    $image = $imagine->open('uploads/' . htmlspecialchars($_GET['imagem']));

    // Redimensionar imagem
    $image->resize(new Box(200, 200))
          ->save('uploads/resized_' . $_GET['imagem']);

    // Definir cabeçalho e exibir a imagem
    header('Content-Type: image/jpeg');
    echo $image->show('jpeg');
} catch (Exception $e) {
    echo 'Erro ao processar a imagem: ' . $e->getMessage();
}

?>