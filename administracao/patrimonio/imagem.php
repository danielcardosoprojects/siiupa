<?php
require '../../vendor/autoload.php';

use Imagine\Image\Box;
use Imagine\Gd\Imagine;
use Imagine\Image\ImageInterface;

try {
    $imagine = new Imagine();
    $imagePath = 'uploads/' . htmlspecialchars($_GET['imagem']);
    $image = $imagine->open($imagePath);

    // Verificar a orientação EXIF e corrigir se necessário
    $exifData = @exif_read_data($imagePath);
    if (!empty($exifData['Orientation'])) {
        switch ($exifData['Orientation']) {
            case 3:
                $image->rotate(180); // Girar 180 graus
                break;
            case 6:
                $image->rotate(90);  // Girar 90 graus no sentido horário
                break;
            case 8:
                $image->rotate(-90); // Girar 90 graus no sentido anti-horário
                break;
        }
    }

    // Redimensionar a imagem
    $image->resize(new Box(200, 200))
          ->save('uploads/resized_' . $_GET['imagem']);

    // Definir cabeçalho e exibir a imagem
    header('Content-Type: image/jpeg');
    echo $image->show('jpeg');
} catch (Exception $e) {
    echo 'Erro ao processar a imagem: ' . $e->getMessage();
}


?>