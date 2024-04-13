<?php
//header('Content-type: text/html; charset=utf-8');
@include("../bd/conectabd.php");
?>
<script>
    function dataUS_BR(entrada) {
        var data = new Date();
        data = entrada;
        var dia = data.getDate().toString().padStart(2, '0'),
            mes = (data.getMonth() + 1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
            ano = data.getFullYear();
        return dia + "/" + mes + "/" + ano;
    }

    function dataBR_US(entrada) {
        var data = entrada;
        var dataFormatada = data.replace(/(\d*)\/(\d*)\/(\d*).*/, '$3-$2-$1');
        return dataFormatada;



    }
    function preencheDatas(){
        var ref_mes = $('#ref_mes').val();
            var ref_ano = $('#ref_ano').val();

            // retirando o zero à esquerda nos menores de 10
            var mes = +ref_mes;
            //criando a data no formato US com o dia 01
            var juntadataus = ref_ano + "-" + ref_mes + "-" + "01 00:00:00";
            var datainicioUS = new Date(ref_ano, ref_mes - 1, 01);
            var datafimUS = new Date(datainicioUS);
            // datafimUS.setMonth(datainicioUS.getMonth() + 1)

            datafimUS.setDate(datainicioUS.getDate() + 29); // Adiciona 3 dias
            console.log(datainicioUS);
            datainicioUS.toString();
            console.log(datainicioUS);
            console.log(datafimUS);
            datafimUS.toString();
            console.log(datafimUS);

            $('#datainicio').val(dataUS_BR(datainicioUS));
            $('#datafim').val(dataUS_BR(datafimUS));
            $('#ref_mes').val(mes);

            $('#datainicio').focus();
    }
    $(function() {
        $("#ref_mes").focus();
        //$('#datainicio').mask("00/00/0000", {placeholder: "__/__/____"});


        $("#btpreenchedata").click(function() {
            var ref_mes = $('#ref_mes').val();
            var ref_ano = $('#ref_ano').val();

            // retirando o zero à esquerda nos menores de 10
            var mes = +ref_mes;
            //criando a data no formato US com o dia 01
            var juntadataus = ref_ano + "-" + ref_mes + "-" + "01 00:00:00";
            var datainicioUS = new Date(ref_ano, ref_mes - 1, 01);
            var datafimUS = new Date(datainicioUS);
            // datafimUS.setMonth(datainicioUS.getMonth() + 1)

            datafimUS.setDate(datainicioUS.getDate() + 29); // Adiciona 3 dias
            console.log(datainicioUS);
            datainicioUS.toString();
            console.log(datainicioUS);
            console.log(datafimUS);
            datafimUS.toString();
            console.log(datafimUS);

            $('#datainicio').val(dataUS_BR(datainicioUS));
            $('#datafim').val(dataUS_BR(datafimUS));
            $('#ref_mes').val(mes);

            $('#datainicio').focus();



        });
        $("#btenviar").click(function() {
            // $('#subconteudo').load($(this).attr('href'));

            var id = $('#id').val();
            var datainicio = dataBR_US($('#datainicio').val());
            var datafim = dataBR_US($('#datafim').val());
            var ref_mes = $('#ref_mes').val();
            var ref_ano = $('#ref_ano').val();
            var observacao = $('#observacao').val();
            var nome = encodeURI($('#nome').val());
            





            console.log(id);
            console.log(datainicio);
            console.log(datafim);
            console.log(ref_mes);
            console.log(ref_ano);
            console.log(observacao);


            var link = '?setor=adm&sub=rh&subsub=rhcadastraferias&acao=executa&id=' + id + '&datainicio=' + datainicio + '&datafim=' + datafim + '&ref_mes=' + ref_mes + '&ref_ano=' + ref_ano + '&observacao=' + observacao + '&nome='+nome;
            //var link2 = '?setor=adm&sub=rhperfil&id='+id;
            // window.history.pushState('page2', 'Title', linkh);
            console.log(link);
            //sessionStorage.setItem('linkanterior', link);
            window.location.href = link;
            //$('#conteudo').load(link);
            // window.location.replace(link2);


            // $("#buscanome").val() = buscanome;

        });
    });
</script>
<?php

$texto_obs = "";

class dados
{
}
$dados = new dados();


if ($_GET['acao'] == 'cadastrar') {
    $dados->id = $_GET['id'];
    $dados->nome = $_GET['nome'];
    $dados->cargo = $_GET['cargo'];
    $dados->vinculo = $_GET['vinculo'];
 
    if ($dados->vinculo == "TEMPORARIO") {
        $texto_obs = "2_Recesso";
    } elseif ($dados->vinculo == "EFETIVO") {
        $texto_obs = "2_Ferias";
    }
    
}


if ($_GET['acao'] == 'executa') {

    $dados->id = $_GET['id'];
    $dados->datainicio =  date($_GET['datainicio']);
    $dados->datafim =  $_GET['datafim'];
    $dados->ref_mes =  $_GET['ref_mes'];
    $dados->ref_ano =  $_GET['ref_ano'];
    $dados->observacao =  $_GET['observacao'];
    $dados->nome = $_GET['nome'];


    //0	8	13:29:18	INSERT INTO `u940659928_siupa`.`tb_ferias` (`fk_funcionario`, `ref_mes`, `ref_ano`) VALUES ('174', '3', '2022')	1364: Field 'datainicio' doesn't have a default value	

    $query = "INSERT INTO u940659928_siupa.tb_ferias (fk_funcionario, datainicio, datafim, ref_mes, ref_ano, observacao) VALUES ('$dados->id', '$dados->datainicio', '$dados->datafim', '$dados->ref_mes', '$dados->ref_ano', '$dados->observacao')";

    if (mysqli_query($conn, $query)) {
        $last_id = mysqli_insert_id($conn);
        //echo "New record created successfully. Last inserted ID is: " . $last_id;
        echo "Sucesso! Férias adicionada! <a href='?setor=adm&sub=rh&subsub=perfil&id=$dados->id#boxFerias'>Voltar ao perfil</a>";
        echo "<h1>$dados->nome</h1>";
        include('perfil/ferias.php');
    } else {
        echo "Opa! Algo deu errado! \n Error: " . $query . "<br>" . mysqli_error($conn);
    }

    return;
}

if ($_GET['acao'] == 'deleta') {
    $dados->idFerias =  $_GET['idferias'];
    $dados->idServidor = $_GET['id'];
    $query = "DELETE FROM `u940659928_siupa`.`tb_ferias` WHERE (`id` = '$dados->idFerias')";
    if (mysqli_query($conn, $query)) {
        echo "Sucesso, registro de férias excluída!";
        include("perfil/ferias.php");
        die;
    }
}
?>

<form action="?setor=adm&sub=rh&subsub=rhcadastraferias&acao=executa" method="get">
    <h2>Cadastrar Férias</h2>
    <p>
    <h4>ID: <?php echo $dados->id; ?> -
        Nome: <?php echo $dados->nome; ?></h4>
    </p>
    <p>Cargo: <?php echo $dados->cargo; ?><br></p>
    <input type="hidden" name="id" id="id" value="<?php echo $dados->id; ?>">
    <input type="hidden" name="nome" id="nome" value="<?php echo $dados->nome; ?>">

    <button class="pick_mes" data-mes="1">Janeiro</button>
    <button class="pick_mes" data-mes="2">Fevereiro</button>
    <button class="pick_mes" data-mes="3">Março</button>
    <button class="pick_mes" data-mes="4">Abril</button>
    <button class="pick_mes" data-mes="5">Maio</button>
    <button class="pick_mes" data-mes="6">Junho</button>
    <br>
    <button class="pick_mes" data-mes="7">Julho</button>
    
    <button class="pick_mes" data-mes="8">Agosto</button>
    <button class="pick_mes" data-mes="9">Setembro</button>
    <button class="pick_mes" data-mes="10">Outubro</button>
    <button class="pick_mes" data-mes="11">Novembro</button>
    <button class="pick_mes" data-mes="12">Dezembro</button>


    <p>Mês de referência: <input type="text" name="ref_mes" id="ref_mes"><br /></p>
    <p>Ano de referência: <input type="text" name="ref_ano" id="ref_ano" value="2024"><br /></p>
    <p><input type="submit" value="Preencher Auto" id="btpreenchedata"><br /></p>
</form>
<form>
    <p>Data Início: <input type="text" name="datainicio" id="datainicio"><br /></p>
    <p>Data Fim: <input type="text" name="datafim" id="datafim"><br /></p>

    <p>Observação: <input type="text" name="observacao" id="observacao" value="<?=$texto_obs;?>"><br /></p>

    <button id="Recesso" data-obs="Recesso">Temporario - Recesso</button><button id="Ferias" data-obs="Ferias">Efetivo - Ferias</button>
    <hr>
    <input type="submit" value="Enviar" id="btenviar">
    <script>
        $("#Recesso").click(function(e) {
            e.preventDefault();
            tipo = $("#Recesso").data("obs");
            $("#observacao").val(tipo);
        });

        $("#Ferias").click(function(e) {
            e.preventDefault();
            tipo = $("#Ferias").data("obs");
            $("#observacao").val(tipo);
        });
        $(".pick_mes").click(function(e) {
            e.preventDefault();

            mes = this;
            console.log();
            $("#ref_mes").val($(mes).data("mes"));
            preencheDatas();
        });
    </script>
</form>