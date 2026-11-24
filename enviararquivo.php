<?php
require __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Uploader\File;
use CoffeeCode\Uploader\Image;

$file  = new File("arquivos", "", false);
$image = new Image("arquivos", "", false);

if ($_FILES) {
    try {
        $f = $_FILES['file'];

        // Decide pela extensão qual classe usar
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $imgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $imgExt)) {
            $upload = $image->upload($f, $_POST['name']);
        } else {
            $upload = $file->upload($f, $_POST['name']);
        }

        echo "<p><a href='{$upload}' target='_blank'>$upload</a></p>";
    } catch (Exception $e) {
        echo "<p>(!) {$e->getMessage()}</p>";
    }
}
?>