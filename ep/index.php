<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feed de Mídia</title>
    <style>
        body {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background: #fafafa;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .media {
            margin: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.1);
            width: 290px;
            overflow: hidden;
        }
        img, video {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <?php
    $dir = 'media/';

    // Abrir diretório e ler seus conteúdos
    if (is_dir($dir)){
        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
                if ($file != "." && $file != ".."){
                    echo '<div class="media">';
                    $file_parts = pathinfo($file);
                    if (in_array($file_parts['extension'], ['jpg', 'png', 'jpeg'])) {
                        echo "<img src='$dir$file' alt='Imagem'>";
                    } elseif ($file_parts['extension'] == 'mp4') {
                        echo "<video controls><source src='$dir$file' type='video/mp4'>Seu navegador não suporta vídeo HTML5.</video>";
                    }
                    echo '</div>';
                }
            }
            closedir($dh);
        }
    }
    ?>
</body>
</html>
