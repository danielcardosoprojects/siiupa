<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>

    
    <?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];    
    }else {
        $id = 1;
    }
    

    if ($id == 1) {
        echo "{\"nome\": \"Daniel\",\"idade\": \"29\"}";
        $texto =  "<h1>{\"nome\": \"Daniel\",\"idade\": \"29\"}</h1>";
    } elseif ($id == 1234566789123) {
        echo "{\"nome\": \"Flávia\", \"idade\": \"Daniel Cardoso de Oliveira\"}";
    }


    $arquivo = fopen('meuarquivo.html', 'a');
    if ($arquivo == false) die('Não foi possível criar o arquivo.');

    $textox = "Olá Mundo !!!";
    fwrite($arquivo, $texto);
    //Fechamos o arquivo após escrever nele
    fclose($arquivo);
include("../index.php");
    ?>
<div style="background-color:red">oi</div>

</body>

</html>