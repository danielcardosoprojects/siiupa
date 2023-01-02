
<?php
include("exebd.php");
include("../administracao/funcoesphpadm.php");
$dataExibe = new dataExibe();
//var_dump($_POST);


if ($_GET["acao"] == "att") {
    $dados = (object) $_POST;
    if ($dados->admissao == '') {
        $dados->admissao = NULL;
    }



    var_dump($dados);


    //$dados->fk_cargo = intval($dados->fk_cargo);
    //$dados->fk_setor = intval($dados->fk_setor);

    $dataExibe = new dataExibe();

    if ($dados->admissao == '') {
        $dados->admissao = NULL;
    } else {
        $dados->admissao = $dataExibe->dataUS($dados->admissao);
    }

    if ($dados->desligamento == '') {
        $dados->desligamento = NULL;
    } else {
        $dados->desligamento = $dataExibe->dataUS($dados->desligamento);
    }



    if ($dados->data_nasc == '') {
        $dados->data_nasc = NULL;
    } else {
        $dados->data_nasc = $dataExibe->dataUS($dados->data_nasc);
    }
    echo "data nasc ";
    var_dump($dados->data_nasc);

    echo "oi" . $dados->admissao;

    AttFUNC($dados);
}


if ($_GET["acao"] == "cadastro") {
    $dados = (object) $_POST;
    if ($dados->admissao == '') {
        $dados->admissao = "01/01/2021";
    }
    $dados->admissao = $dataExibe->dataUS($dados->admissao);
    $dados->data_nasc = $dataExibe->dataUS($dados->data_nasc);
    echo "ENTROU CADASTRO";
    var_dump($dados);
    cadFUNC($dados);
}

if ($_GET["acao"] == "anexadocumento") {
    $dados = (object) $_POST;

    Cadhistorico($_POST['fk_funcionario'], $_POST['titulo'], $_POST['descricao'], $_POST['data_inicio'], $_POST['data_fim']);

    $location = '../administracao/rh/'.$_POST['fk_funcionario'];
    //var_dump($_FILES['arquivo']);

    if (isset($_FILES['arquivo'])) {
        $name = $_FILES['arquivo']['name'];
        $tmp_name = $_FILES['arquivo']['tmp_name'];

        $error = $_FILES['arquivo']['error'];
        if ($error !== UPLOAD_ERR_OK) {
            echo 'Erro ao fazer o upload:', $error;
        } elseif (move_uploaded_file($tmp_name, $location . $name)) {
            echo 'Uploaded';
        }
    } else {
        echo 'Selecione um arquivo para fazer upload';
    }
}

?>
