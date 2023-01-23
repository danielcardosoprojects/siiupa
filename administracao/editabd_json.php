<?php

include('../bd/conectabd.php');
function atualizaArray($banco, $tabela, $camposValores, $id)
{
    $update = "UPDATE $banco.$tabela SET ";
    //recebe os campos e valores em um array $array = ["campo"=>"valor", "campo2"=>"valor2"];
    $i = 0;
    foreach ($camposValores as $key => $valor) {
        if ($i > 0) {
            $update .= ",";
        }
        //UPDATE `db_rh`.`tb_setor` SET `setor` = 'Enfermagem - Enf ', `categoria` = 'Nivel Superior ' WHERE (`id` = '17');
        $update .= " $key = '$valor'";;

        $i++;
    }

    $update .= " WHERE id='$id'";

    $editaBd = new BD;
    $editaBd->conecta();


    $servername = "localhost";
    $database = "db_rh";
    $username = "root";
    $password = "apuapu";
    $bd = new PDO("mysql:host=$servername;dbname=$database", "$username", "$password");
    $busca = $bd->prepare($update);
 

    $result = $busca->execute();
    $resultado = $busca->fetchAll(PDO::FETCH_ASSOC);
    if($result){
        foreach($camposValores as $valor){
            echo "$valor";
        } 
    } else{
        echo "erro!";
    }
}

$banco = $_POST['banco'];
$tabela = $_POST['tabela'];
$dados = json_decode($_POST['camposValores']);
$id = $_POST['id'];


atualizaArray($banco, $tabela, $dados, $id);

// Recebe os dados enviados em formato JSON
$json_data = json_decode(file_get_contents('php://input'), true);
  //var_dump($json_data);
