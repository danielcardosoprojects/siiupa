<?php
header('Content-type: text/html; charset=utf-8');
include("../bd/conectabd.php");
include("funcoesphpadm.php");



?>
<script>
    $(function() {
        $("#abresubconteudo").click(function() {
            event.preventDefault();
            $('#subconteudo').load($(this).attr('href'));


        });
        jQuery(".dataInput").mask("99/99/9999");
        jQuery(".CPF").mask("999.999.999-99");

        $('#formeditaperfil').submit(function() {
            // Get all the forms elements and their values in one step

            $.post('bd/tratadadosbd.php?acao=atualizar', $('#formeditaperfil').serialize(), function(retorno) {
                //alert(retorno);


                var ideditando = $('#id').val();
                $('#subconteudo').load("administracao/paginarh_perfil.php?id=" + ideditando);
                //$('#teste').html(retorno);


            }, 'html');


            return false;

        });


    });
</script>
<div class="alert alert-success" role="alert">
    <?php
    // $sql = "SELECT * FROM u940659928_siupa.tb_funcionario";
    if (isset($_GET["where"])) {
        $gw = $_GET['where'];
        $where = "WHERE f.nome LIKE '%" . $gw . "%'";
    } elseif (isset($_GET["id"])) {
        $gw = $_GET['id'];
        $where = "WHERE f.id = '" . $gw . "'";
    } else {
        $where = "";
    }

    if (isset($_GET["orderby"])) {
        $orderby = $_GET["orderby"];
        if ($orderby == 1) {
            $tipoorder = "ASC";
        }
    }


    $orderby = "ORDER BY id desc";
    $sql = "SELECT  f.*, c.titulo AS cargo, s.setor FROM u940659928_siupa.tb_funcionario AS f INNER JOIN u940659928_siupa.tb_cargo AS c ON f.fk_cargo = c.id INNER JOIN u940659928_siupa.tb_setor AS s ON f.fk_setor = s.id $where $orderby";
    $result = mysqli_query($conn, $sql);

    echo mysqli_num_rows($result) . " resultado(s).";

    print_r($result);

    ?>
</div>

<?php

$perfil = mysqli_fetch_object($result);




$negrito = "<span class='fw-bold lh-1'>";
$fspan = "</span>";





?>

<div class='d-flex'>
    <a href='administracao/paginarh_editaperfil.php?id=<?php echo $perfil->id; ?>' id='abresubconteudo' class='btn btn-warning'>
        <i><span class='material-icons'>create</span></i>
        Editar Funcionário</a>
</div>
<div id="teste"></div>
<?php


echo "<p class='lh-1'>";
$grade = new Grade();
$formulario = new Formulario();
$dataExibe = new dataExibe();


$formulario->novoForm("bd/tratadadosbd.php?acao=atualizar", "get");
$grade->iniciagrade();
$grade->inicialinha();


$grade->iniciacoluna();

negrita("VINCULO:");
pulalinha(1);

echo "<input id='id' name='id' value='" . $perfil->id . "' type='hidden'>";


$formulario->radio("vinculo", "E", "EFETIVO", $perfil->vinculo);
$formulario->radio("vinculo", "T", "TEMPORARIO", $perfil->vinculo);

pulalinha(2);

negrita("NOME:");
pulalinha(1);
$formulario->input("nome", $perfil->nome);

pulalinha(1);
$grade->fimcoluna();

$grade->fimlinha();

$grade->inicialinha();
$grade->iniciacoluna();
negrita("SEXO:");
pulalinha(1);

$formulario->radio("sexo", "F", "FEMININO", $perfil->sexo);
$formulario->radio("sexo", "M", "MASCULINO", $perfil->sexo);






$grade->fimcoluna();

$grade->iniciacoluna();
negrita("DATA DE NASCIMENTO:");
pulalinha(1);
$formulario->inputData("data_nasc", $dataExibe->dataBR($perfil->data_nasc));
$grade->fimcoluna();


$grade->iniciacoluna();
negrita("CPF:");
pulalinha(1);
$formulario->input("cpf", $perfil->cpf);
$grade->fimcoluna();

$grade->iniciacoluna();
negrita("CNS:");
pulalinha(1);
$formulario->input("cns", $perfil->cns);
pulalinha(2);
$grade->fimcoluna();


$grade->fimlinha();

pulalinha(1);

$grade->inicialinha();
$grade->iniciacoluna();
negrita("CARGO:");
pulalinha(1);


$formulario->selectinicia("fk_cargo");

$sqlcargo = "SELECT  * FROM u940659928_siupa.tb_cargo";
$resultcargo = mysqli_query($conn, $sqlcargo);

if (mysqli_num_rows($resultcargo) > 0) {
    while ($cargos = mysqli_fetch_object($resultcargo)) {
        $formulario->selectoption($cargos->id, $cargos->titulo, $perfil->fk_cargo);
    }
} else {
    echo "0 results";
}

$formulario->selectfim();



$grade->fimcoluna();

$grade->iniciacoluna();
negrita("SETOR:");
pulalinha(1);


$formulario->selectinicia("fk_setor");

$sqlsetor = "SELECT  * FROM u940659928_siupa.tb_setor";
$resultsetor = mysqli_query($conn, $sqlsetor);

if (mysqli_num_rows($resultsetor) > 0) {
    while ($setores = mysqli_fetch_object($resultsetor)) {
        $formulario->selectoption($setores->id, $setores->setor, $perfil->fk_setor);
    }
} else {
    echo "0 results";
}

$formulario->selectfim();



$grade->fimcoluna();

$grade->iniciacoluna();
negrita("ADMISSÃO:");
pulalinha(1);
$formulario->inputData("admissao", $dataExibe->dataBR($perfil->admissao));

$grade->fimcoluna();

$grade->iniciacoluna();
negrita("MATRÍCULA:");
pulalinha(1);
$formulario->input("matricula", $perfil->matricula);
$grade->fimcoluna();



pulalinha(1);



$grade->inicialinha();

$grade->iniciacoluna();
negrita("ENDEREÇO");
$grade->fimcoluna();

$grade->fimlinha();


$grade->inicialinha();



$grade->iniciacoluna($tam = "-6");
negrita("RUA:");
$formulario->input("end_rua", $perfil->end_rua);
$grade->fimcoluna();

$grade->iniciacoluna($tam = "col-lg-2");
negrita("Numero:");
$formulario->input("end_numero", $perfil->end_numero);
$grade->fimcoluna();

$grade->iniciacoluna();
negrita("Compl.:");
$formulario->input("end_compl", $perfil->end_compl);
$grade->fimcoluna();

$grade->iniciacoluna();
negrita("Bairro:");
$formulario->input("end_bairro", $perfil->end_bairro);
$grade->fimcoluna();

$grade->fimcoluna();
$grade->fimlinha();

pulalinha(1);

$grade->inicialinha();

$grade->iniciacoluna();
negrita("TELEFONE(S)");
$grade->fimcoluna();
$grade->fimlinha();



$grade->inicialinha();
$grade->iniciacoluna();
negrita("Tel 1:");
$formulario->input("telefone", $perfil->telefone);
$grade->fimcoluna();

$grade->iniciacoluna();
negrita("Tel 2:");
$formulario->input("telefone2", $perfil->telefone2);
$grade->fimcoluna();

$grade->iniciacoluna();
negrita("Tel 3:");
$formulario->input("telefone3", $perfil->telefone3);

$grade->fimlinha();



$grade->inicialinha();
$grade->iniciacoluna();
negrita("E-MAIL:");
pulalinha(1);
$formulario->input("email", $perfil->email);


$grade->fimcoluna();
$grade->fimlinha();


$grade->inicialinha();

$grade->iniciacoluna();
negrita("REAÇÃO ALERGICA A MEDICAMENTOS:");
pulalinha(1);
$formulario->input("ram", $perfil->ram);


$grade->fimcoluna();
$grade->fimlinha();

$grade->inicialinha();

$grade->iniciacoluna();
negrita("STATUS:");
pulalinha(1);

$formulario->radio("status", "1", "ATIVO", $perfil->status);
$formulario->radio("status", "2", "INATIVO", $perfil->status);

$grade->fimcoluna();
if ($perfil->status == "2") {
}
$grade->iniciacoluna();
negrita("DESLIGAMENTO:");
pulalinha(1);
$formulario->inputData("desligamento", $dataExibe->dataBR($perfil->desligamento));
$grade->fimcoluna();

$grade->fimlinha();
$grade->fimgrade();
echo "</p>";

echo '<input type="submit" value="ENVIAR">';
$formulario->fimForm();

/* HISTORICO */
$sqlhist = "SELECT  * FROM u940659928_siupa.tb_historico WHERE fk_funcionario = $perfil->id ORDER BY data_registro DESC";
$resulthist = mysqli_query($conn, $sqlhist);

echo "<div class='alert alert-success' role='alert'>";
negrita("Histórico: ");
echo mysqli_num_rows($resulthist) . " registro(s).";
echo "</div>";


if (mysqli_num_rows($resulthist) > 0) {
    while ($hist = mysqli_fetch_object($resulthist)) {
        $DataRegpuro = new DateTime($hist->data_registro);

        $DataReg = $DataRegpuro->format('d/m/Y H:i:s');

?>

        <div class="accordion accordion-flush" id="accordionFlushHist" style="border-color:midnightblue;">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading<?php echo $hist->id; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $hist->id; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $hist->id; ?>">
                        <?php
                        negrita($DataReg);
                        echo " - ";
                        echo $hist->titulo;

                        ?>
                    </button>
                </h2>
                <div id="flush-collapse<?php echo $hist->id; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $hist->id; ?>" data-bs-parent="#accordionFlushHist">
                    <div class="accordion-body"> <?php echo $hist->descricao; ?></div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo "0 results";
}


mysqli_close($conn);

?>