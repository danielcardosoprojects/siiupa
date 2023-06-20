<style>
    .caption {
        text-align: center;
        color: #000 !important;
    }

    .ui-dialog {
        position: fixed;
        z-index: 1000;
        left: 70%;
        top: 1rem;
    }

    #dialogAnota {

        position: fixed;
        z-index: 1000;
        left: 70%;
        top: 1rem;

    }

    #form-busca-servidores {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>
<?php
@include_once("../bd/conectabd.php");
$idescala = $_GET['id'];

$mes = $_GET['mes'];
$ano = $_GET['ano'];
//$sql = "SELECT * FROM db_rh.tb_escalas GROUP BY ano desc, mes desc  ";

$setor_titulo = "Escala " . $_GET['setor'] . " " . $_GET['mes'] . " " . $_GET['ano'];
$oficial = $_GET['oficial'];
if ($oficial == "sim") {
    $bt_oficial = "btn btn-success";
    $bt_rascunho = "btn btn-outline-warning";
    $done_oficial = "";
    $done_rascunho = "d-none";
    $statusEscala = "<input id='statusEscala' type='hidden' value='oficial'/>";
} else {
    $bt_oficial = "btn btn-outline-success";
    $bt_rascunho = "btn btn-warning";
    $done_oficial = "d-none";
    $done_rascunho = "";
    $statusEscala = "<input id='statusEscala'type='hidden' value='rascunho'/>";
}
echo $statusEscala;
?>
<a href='?setor=adm&sub=rh&subsub=escalas' class='btn-outline-dark'>
    <span class="ui-icon ui-icon-caret-1-w"></span>Voltar às Escalas</a> |

<a class="btn btn-outline-dark" href='administracao/pagina_escala_esqueleto.php?id=<?php echo $idescala ?>' target='_blank'>
    <span class="ui-icon ui-icon-print"></span>Imprimir</a>

    <a class="btn btn-outline-dark" href='/siiupa/administracao/escalas/escala_calendario.php?id=<?php echo "$idescala&month=$mes&year=$ano" ?>' target='_blank'>
    <span class="ui-icon ui-icon-document"></span>Calendário</a>

<a class="btn btn-outline-dark" href='gerapdf_escala.php?id=<?php echo $idescala ?>' target='_blank'>
    <span class="ui-icon ui-icon-document"></span>Gerar PDF</a>

<a class="btn btn-outline-dark" href='administracao/pagina_escala_esqueleto_excel.php?id=<?php echo $idescala ?>&setor_titulo=<?php echo $setor_titulo; ?>' target='_blank'>
    <span class="ui-icon ui-icon-print"></span>Gerar Excel</a>


<button type="button" class="btn btn btn-outline-dark" id="addservidor">
    <span class="ui-icon ui-icon-person"></span>Adicionar Servidor</button>

<a class="btn btn-outline-dark" href='#' id="blocodenotas">
    <span class="ui-icon ui-icon-print"></span>Bloco de notas</a>
STATUS:
<div id="load_status_escala" class="spinner-border text-primary d-none" role="status">

</div>
<a id="bt_esc_oficial" data-oficial="sim" data-idescala="<?php echo $idescala; ?>" data-mes="<?php echo $mes; ?>" data-ano="<?php echo $ano; ?>" class="<?php echo $bt_oficial; ?> bt_oficial" href='#' target='_blank'>
    <img id='done-oficial' src='imagens/icones/done.svg' class='<?php echo $done_oficial; ?>'>OFICIAL</a>

<a id="bt_esc_rascunho" data-oficial="nao" data-idescala="<?php echo $idescala; ?>" data-mes="<?php echo $mes; ?>" data-ano="<?php echo $ano; ?>" class="<?php echo $bt_rascunho; ?> bt_oficial" href='#' target='_blank'>
    <img id='done-rascunho' src='imagens/icones/done.svg' class='<?php echo $done_rascunho; ?>'>RASCUNHO</a>
<?php
$outrasMes = $_GET['mes'];
$outrasAno = $_GET['ano'];

$sql = "SELECT es.id, es.mes, es.ano, s.setor, es.oficial FROM db_rh.tb_escalas as es inner join db_rh.tb_setor as s on (es.fk_setor = s.id) WHERE es.ano = '$outrasAno' AND es.mes = '$outrasMes' ORDER BY s.setor ASC";
$busca = new BD;
$resultado = $busca->consulta($sql);
echo "<hr>";
echo "<span class='btn btn-info btn-sm'>Outras escalas deste mês ($outrasMes/$outrasAno): </span> ";
foreach ($resultado as $escalas) {
    if ($escalas->oficial == 'sim') {
        $outrasOficial = 'sim';
        $outrasBt = "success";
    } else {
        $outrasOficial = 'nao';
        $outrasBt = "warning";
    }

    echo "<a class='btn btn-$outrasBt btn-sm' href='/siiupa/?setor=adm&sub=rhescala_exibe&id=$escalas->id&mes=$escalas->mes&ano=$escalas->ano&oficial=$outrasOficial'>$escalas->setor</a> ";
}

@include_once("../bd/conectabd.php");
?>
<p>Ferramentas: <a href="#" id="excluir_varios">Excluir vários</a></p>
<div id="carregaesqueleto">

    <?php
    include("pagina_escala_esqueleto.php");
    ?>

    <hr>

    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    EXEMPLOS DE LEGENDAS \/
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">

                    M - Manhã 6h<br>
                    T - Tarde 6h<br>
                    N² - Noite 6h<br>
                    P - Plantão 24h <br>
                    D - Diurno 12h<br>
                    N - Noturno 12h<br>
                    F² - Ponto Facultativo<br>
                    F³ - Feriado<br>
                    <small>
                        Carga horária nível superior: 120h<br>
                        Carga horária nível fund./médio/técnico: 144h<br>
                        Carga horária nível técnico(rx): 96h<br>
                    </small>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Feriados e Pontos Facultativos 2022
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">

                    <code>Agosto</code>
                    <br>
                    15/ago/22 - Feriado Estadual - segunda - Adesão do Pará à Independência - LEI N° 5.999,DE 10/09/1996
                    <br><br>
                    <code>Setembro</code>

                    <br>07/set/22 - Ponto Facultativo - quarta - Independência do Brasil - leis 662, 06/04/1949, e 10.607, 19/12/2002
                    <br><br>
                    <code>Outubro</code>

                    <br>12/out/22 - Feriado Nacional - quarta - N S Aparecida – Padroeira do Brasil - Lei no 6.802,de 30/06/1980
                    <br>15/out/22 - Feriado Escolar - Sábado - Dia do Professor – Dec. Fed. 52.682, de14/10/1963.
                    <br>17/out/22 - Ponto Facultativo - segunda - Pós Romaria de N S de Nazaré
                    <br>28/out/22 - Ponto Facultativo - sexta - Dia do Servidor Púbico – Lei Mun. 003/99, Art. 218
                    <br><br>
                    <code>Novembro</code>

                    <br>02/nov/22 - Feriado Nacional - quarta - Dia de Finados - Lei no 10.607, de 19 de dezembro de 2002
                    <br>15/nov/22 - Feriado Nacional - terça - Proclamação da República - Lei no 10.607, de 19 de dezembro de 2002
                    <br><br>
                    <code>Dezembro</code>

                    <br>08/dez/22 - Feriado Municipal - Quinta - Imaculada Conceição - Lei 026/83, 27/12/83
                    <br>24/dez/22 - Ponto Facultativo - sábado - Vésperas do Natal
                    <br>25/dez/22 - Feriado Nacional - domingo - Natal - Lei no 10.607, de 19 de dezembro de 2002
                    <br>31/dez/22 - Ponto Facultativo - sábado - Vésperas de Ano Novo
                </div>
            </div>
        </div>
    </div>
</div>










<div id="dialogadd" title="Adicionar Servidor" class="modal">
    <form class="form-control" id="form-busca-servidores">
        <label for="buscar">Nome:</label><input type="text" name="buscar" id="buscar" class="form-control form-control-sm">

        <label for="busca_servidor_setor">Setor:</label>
        <select name='busca_servidor_setor' id='busca_servidor_setor' class='form-control form-control-sm'>
            <option value="" selected> TODOS </option>

            <?php


            $sqlsetor = "SELECT  * FROM tb_setor order by setor ASC";
            $resultsetor = mysqli_query($conn, $sqlsetor);
            if (mysqli_num_rows($resultsetor) > 0) {


                while ($setor = mysqli_fetch_assoc($resultsetor)) {

                    if (isset($valor)) {
                        if ($valor == $setor['setor']) {


                            $selected = "selected";
                        } else {

                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    }

            ?>
                    <option value="<?php echo $setor['id']; ?>" <?php echo $selected; ?>> <?php echo $setor['setor'] . ' - ' . $setor['categoria']; ?></option>



            <?php
                }
            }




            echo "</select>";
            ?>


            <input type="submit" class="" id="btaddservidor" value="BUSCAR">
            <a id="btAddTodos2" class="form-control btn btn-info d-none">Adicionar Todos </a>
    </form>

    <div id="dialogaddresultadobusca">
        <caption>Busque pelo nome</caption>
    </div>

</div>

<div id="dialogconfig" title="Configura servidor">

    <div id="dialogcfgresult">
        <caption></caption>
    </div>

</div>

<div id="dialogAnota" title="Bloco de Notas" class="modal">
    <textarea name="txtNotepad" id="txtNotepad" cols="30" rows="10" onkeydown="saveNotepad()"></textarea>
</div>
<script>
    $(document).ready(function() {
        $("#txtNotepad").val($.session.get('txtNotepad'));
    });

    $("#excluir_varios").click((e)=>{
        e.preventDefault();
        $(".seleciona_exclusao").show();
    });
    


    function saveNotepad() {
        let txtNotepad = $("#txtNotepad").val();
        $.session.set('txtNotepad', txtNotepad);
        console.log(txtNotepad);
    }
</script>
<script src="/siiupa/js/jquery.session.js" defer></script>
<script src="/siiupa/administracao/pagina_escala_exibe.js?v=1"></script>