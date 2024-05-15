<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feed de Mídia Estilo Instagram</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fafafa;
            margin: 0;
            padding-top: 20px;
            font-family: Arial, sans-serif;
        }
        .media {
            margin: 20px 0;
            border: 1px solid #ddd;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.1);
            width: 90%;
            max-width: 600px; /* Similar à largura máxima das postagens no Instagram */
            overflow: hidden;
            background: white;
        }
        img, video {
            width: 100%;
            height: auto;
        }
        .download-btn {
            display: block;
            text-align: center;
            background: #0095f6;
            color: white;
            text-decoration: none;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
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
                    echo "<a href='$dir$file' download class='download-btn'>Download</a>";
                    echo '</div>';
                }
            }
            closedir($dh);
        }
    }
    ?>
</body>
</html>
