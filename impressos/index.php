<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar PDFs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            color: #5a5a5a;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        li a {
            text-decoration: none;
            color: #0066cc;
        }
        li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Arquivos PDF no diretório</h1>
    <?php
    $diretorio = './'; // Substitua pelo caminho do diretório que contém os PDFs
    $arquivos = scandir($diretorio);

    echo "<ul>";
    foreach ($arquivos as $arquivo) {
        
        if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
            echo "<li><a href='$diretorio/$arquivo'>$arquivo</a></li>";
        }
    }
    echo "</ul>";
    ?>
</body>
</html>
