<h3>Acionamentos</h3>
<a href="?setor=adm&sub=rh&subsub=atestados" id="cadastraNovo" class="btn btn-outline-success">
    <img src="imagens/icones/person_add.svg">
    Cadastrar novo ACIONAMENTO</a>
<hr>

<?php

$sqlTiposAcionamentos = "SELECT * FROM db_rh.tb_acionamentos;";
$tiposAcionamentos = new BD;
$rTAcions = $tiposAcionamentos->consulta($sqlTiposAcionamentos);
echo "<div class='tiposAcionamentos'>";
echo "<a href='/siiupa/?setor=adm&sub=rh&subsub=acionamentos' class='btn btn-outline-dark'>Tudo</a>";
foreach($rTAcions as $rTAcion){
    $acionamento = utf8_encode($rTAcion->acionamento);
    echo "<a href='/siiupa/?setor=adm&sub=rh&subsub=acionamentos&tipoAcionamento=$rTAcion->id' class='btn btn-outline-dark'>$acionamento</a>";
    $titulosAcionamentos[$rTAcion->id] = $acionamento;

}
echo "</div>";

if(isset($_GET['tipoAcionamento'])){
    $idTipoAcionamento = $_GET['tipoAcionamento'];
    $andTipoAcionamento = "WHERE ac.fk_acionamentos = '$idTipoAcionamento'";
    $tipoTitulosAcionamentos = $titulosAcionamentos[$idTipoAcionamento];
    $tituloTipoAcionamento = "Exibindo: $tipoTitulosAcionamentos"."s ⬇️";
} else {
    $andTipoAcionamento = '';
    $tituloTipoAcionamento = "Exibindo: tudo ⬇️";
}
echo "<h2 class='tituloTiposAcionamentos'>$tituloTipoAcionamento</h2>";

?>
<strong>Busca Acionamento:</strong>
<form id="pesquisaAcionamentos">
    <input id="entrada" class="form-control" type="txt" placeholder="O que você quer buscar?">
    <div id="saidaTxt" class="form-control form-control-sm"></div>

</form>
<hr>
<div id="box_grande">

    <?php
    
  
    $consulta_acionamento = new BD;
    $sqlConsulta_Acionamento = "SELECT ac.*, f.nome, acs.acionamento, acs.id as acionamentosId, f.fk_cargo as cargoId, cargo.funcao_upa FROM db_rh.tb_acionamento as ac inner join db_rh.tb_funcionario as f on (ac.fk_funcionario = f.id) inner join db_rh.tb_cargo as cargo on (f.fk_cargo = cargo.id) inner join db_rh.tb_acionamentos as acs on(ac.fk_acionamentos = acs.id) $andTipoAcionamento ORDER BY ac.id DESC";
    $resultadoConsulta_Acionamento = $consulta_acionamento->consulta($sqlConsulta_Acionamento);

    foreach ($resultadoConsulta_Acionamento as $resultado_acionamento) {

        $fk_afastamento = $resultado_acionamento->fk_afastamento;


        $data_acionamento = new DateTime($resultado_acionamento->data_acionamento);
    ?>

        <div class="box_acionamentos" id="box_<?php echo $resultado_acionamento->id; ?>" data-id="<?php echo $resultado_acionamento->id; ?>" name='<?php echo $resultado_acionamento->nome ?>'>
            <span class="acionamentoEtiqueta">📣 Acionamento:</span>
            <div class="nome">
                <h5>👤 <a href="/siiupa/?setor=adm&sub=rh&subsub=acionamento_exibe&id=<?=$resultado_acionamento->id;?>"><?php echo utf8_encode($resultado_acionamento->nome); ?></a><span class="ui-icon ui-icon-copy copiarAcionamento" data-id="<?php echo $resultado_acionamento->id; ?>" data-text=""></span></h5>
            </div>
            <div class="linha_dados">
                <span class="data">📅 <?php echo $data_acionamento->format('d/m/Y'); ?></span>
                <span class="choraria">⏰<?php echo $resultado_acionamento->qtd_horas; ?></span>
                <?php
                if ($resultado_acionamento->turno == "diurno") {
                    $classeTurno = "diurno";
                    $iconeTurno = "☀️ ";
                } elseif ($resultado_acionamento->turno == "noturno") {
                    $classeTurno = "noturno";
                    $iconeTurno = "🌙 ";
                } elseif ($resultado_acionamento->turno == "undefined") {
                    $classeTurno = "plantao_24h";
                    $iconeTurno = "🚑 🚀";
                    $resultado_acionamento->turno = "";
                } else {
                    $classeTurno = "plantao_24h";
                    $iconeTurno = "🌇 ";
                }

                ?>
                <span class="<?php echo $classeTurno; ?>"><?php echo $iconeTurno; ?><?php echo ucfirst($resultado_acionamento->turno); ?></span>
                <span class="valor">💰 <?php echo $resultado_acionamento->valor; ?>,00</span>
            </div>
            <div class="motivo">
                ➡️ Motivo:<span class="tipo_afastamento"><?php echo utf8_encode($resultado_acionamento->acionamento); ?></span>
                <?php
                if ($resultado_acionamento->fk_afastamento != 0) {
                    $consulta_afastamento = new BD;
                    $sqlConsulta_Afastamento = "SELECT f.nome as nomeAfastado, c.titulo as tituloCargo, afs.afastamento, af.id as idAfastado, af.data_inicio, af.data_fim FROM db_rh.tb_afastamento as af inner join db_rh.tb_funcionario as f on (af.fk_funcionario = f.id) inner join db_rh.tb_afastamentos as afs on (af.fk_afastamentos = afs.id) inner join db_rh.tb_cargo as c on (f.fk_cargo = c.id) WHERE af.id='$resultado_acionamento->fk_afastamento'";

                    $resultadoConsultaAfastamento = $consulta_afastamento->consulta($sqlConsulta_Afastamento);
                    ////////////////////////////////// var_dump($resultadoAfastamento);
                    $resultadoAfastamento = $resultadoConsultaAfastamento[0];
                    $dataInicio = new DateTime($resultadoAfastamento->data_inicio);
                    $dataFim = new DateTime($resultadoAfastamento->data_fim);
                    $dataInicio = $dataInicio->format('d/m/Y');
                    $dataFim = $dataFim->format('d/m/Y');
                    echo "🏃<span class='tipo_afastamento'>".utf8_encode($resultadoAfastamento->afastamento)."</span>";
                    echo "<br>";
                    echo "<span><a href='#'>$resultadoAfastamento->nomeAfastado - " . utf8_encode($resultadoAfastamento->tituloCargo) . " - $dataInicio a $dataFim</a></span>";
                } ?>


            </div>
            <div class="obs_acionamento">📝 <?php echo utf8_encode($resultado_acionamento->acionamento_obs); ?></div>
            <button class="editaAcionamento ui-button ui-widget ui-corner-all" data-idescolhido="<?php echo $resultado_acionamento->id; ?>" data-idfuncionario="<?php echo $resultado_acionamento->fk_funcionario; ?>" data-nome="<?php echo $resultado_acionamento->nome; ?>" data-cargoescolhidoId="<?php echo $resultado_acionamento->cargoId; ?>" data-cargoescolhido="<?php echo $resultado_acionamento->funcao_upa; ?>" data-acionamentosId="<?php echo $resultado_acionamento->acionamentosId; ?>" data-acionamentosTxt="<?php echo utf8_encode($resultado_acionamento->acionamento); ?>" data-afastamentoId="<?php echo $resultado_acionamento->fk_afastamento; ?>" data-dataAcionamento="<?php echo $data_acionamento->format('Y-m-d'); ?>" data-ch="<?php echo $resultado_acionamento->qtd_horas; ?>" data-turno="<?php echo $resultado_acionamento->turno; ?>" data-acionamentoobs="<?php echo utf8_encode($resultado_acionamento->acionamento_obs); ?>">Editar</button>
        </div>

<?php } ?>
</div>


<div id="dialog" title="Basic dialog">
</div>

<script>
    $(function() {

        $(document).ready(function() {


            var busca = null;
            var boxes = $(".box_acionamentos"); //boxes onde contem os dados a serem pesquisados
            boxes = boxes.toArray();
            var array = [];
            var arrayValores = [];
            for (box in boxes) {
                array.push(boxes[box].attributes.name.value) //lista de valores a serem buscados

            }

            $('#pesquisaAcionamentos').bind('input', function() {


                pesquisaAcionamentos();


            });

            function pesquisaAcionamentos() {
                busca = $('#entrada').val().toLowerCase();

                if (busca !== '') {
                    var corresponde = false;
                    var saida = Array();
                    var quantidade = 0;
                    for (var key in array) {

                        corresponde = array[key].toLowerCase().indexOf(busca) >= 0;
                        if (corresponde) {
                            saida.push(array[key]);
                            nome = array[key];
                            arrayValores[nome] = boxes[key];
                            $(boxes[key]).show();
                            quantidade += 1;
                        } else {
                            $(boxes[key]).hide();

                        }
                    }
                    if (quantidade) {
                        $('#saidaTxt').text('');
                        //$('#quantidade').html(quantidade + ' resultados!<br><br>');
                        for (var ind in saida) {

                            nomeSaida = saida[ind]
                            arrayValores[nomeSaida]
                            //$('#saidaTxt').append(arrayValores[nomeSaida]);

                        }

                    } else {
                        $('#quantidade').html('');
                        $('#saidaTxt').text('Nenhum resultado...');
                        $('.box_acionamentos').show();
                    }

                } else {
                    $('#quantidade').html('');
                    $('#saidaTxt').text('Nenhum resultado...');

                    $('.box_acionamentos').show()
                }
            }



        });

        $('.copiarAcionamento').click(function(e) {
            e.preventDefault();
            boxAcionamento = "div[data-id='" + $(this).attr('data-id') + "'";
            textoCopiar = $(boxAcionamento).text();
            copyText = textoCopiar;

            //navigator.clipboard.writeText(copyText);
            function copyToClipboard(textToCopy) {
                // navigator clipboard api needs a secure context (https)
                if (navigator.clipboard && window.isSecureContext) {
                    // navigator clipboard api method'
                    return navigator.clipboard.writeText(textToCopy);
                } else {
                    // text area method
                    let textArea = document.createElement("textarea");
                    textArea.value = textToCopy;
                    // make the textarea out of viewport
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    return new Promise((res, rej) => {
                        // here the magic happens
                        document.execCommand('copy') ? res() : rej();
                        textArea.remove();
                    });
                }
            }
            copyToClipboard(copyText);
            $.alert({
                title: 'Copiado!',
                content: 'Copiado com sucesso.',
                escapeKey: true,
                backgroundDismiss: true
            });

        });

        $("#dialog").dialog({
            autoOpen: false,
            modal: true,
            title: 'Cadastrar Acionamento',
            width: 600
        });
        $("#cadastraNovo").click(function(e) {
            e.preventDefault();
            $("#dialog").dialog("open");
            $.get('administracao/acionamentos/acionamentos_buscafuncionario.php', function(data) {
                $('#dialog').html(data);
            });
        });

        $(".editaAcionamento").click(function(e) {
            e.preventDefault();

            idescolhido = $(this).data("idescolhido");
            idfuncionario = $(this).data("idfuncionario");
            nomeescolhido = $(this).data("nome");
            cargoescolhido = $(this).data("cargo");
            acionamentosid = $(this).data("acionamentosid");
            acionamentostxt = $(this).data("acionamentostxt");
            afastamentoId = $(this).data("afastamentoid");
            dataacionamento = $(this).data('dataacionamento');
            acionamentoobs = $(this).data("acionamentoobs");
            ch = $(this).data("ch");
            turno = $(this).data("turno");
            linkformulario = "administracao/acionamentos/acionamentos_formularios.php?acao=edita&idacionamento="+idescolhido+"&idfuncionario=" + idfuncionario + "&nome=" + nomeescolhido + "&cargo=" + cargoescolhido + "&acionamentosId=" + acionamentosid + "&acionamentostxt=" + acionamentostxt + "&afastamentoId=" + afastamentoId + "&dataacionamento=" + dataacionamento + "&ch=" + ch + "&turno=" + turno + "&acionamentoobs=" + acionamentoobs;
            //alert(linkformulario);
            $("#dialog").dialog("open");
            $.get(linkformulario, function(data) {
                $("#dialog").html(data);
                $("#dialog").dialog({
                    position: {
                        my: "center",
                        at: "center",
                        of: window
                    }
                });
            });

        });


    });
</script>
<style>
    .tiposAcionamentos{
        display:flex;
        gap: 5px;
        color: #000;
    }
    .tituloTiposAcionamentos{
        margin-top: 5px;
        width:100%;         
        color: #fff;
        background-color: #003399;
        text-align:center;
        align-items: center;
    }
    .acionamentoEtiqueta {
        color: transparent;
        font-size: 0px;
    }

    .nome {
        padding: 0.2rem;
        position: relative;
        display: table-cell;
        vertical-align: middle;

    }

    .nome a {

        font-weight: bold;
        font-size: 1.4rem;
    }

    #box_grande {       
        display: flex;
        flex-direction: row;
        width: 100%;
        background-color: #0d6efd;
        gap: 6px;
        flex-wrap:wrap;
        
        justify-content: space-around;
        padding:4px;
    }

    .box_acionamentos {
        align-items: center;
        width:30%;
        border: 1px solid #ccc;
        padding: 2px;
        background-color: #e6eeff;
        display: flex;
        flex-direction: column;
    }


    .box_acionamentos img {
        width: 25px;
        border-radius: 10px;
    }

    .linha_dados {
        display: flex;
        flex-direction: row;
        flex-wrap:wrap;
        gap: 5px;
    }

    .box_acionamentos:hover {
        background-color: #e2e7e8;
    }

    .copiarAcionamento {
        cursor: pointer;
    }

    .motivo {
        margin-left: 20px;
    }

    .obs_acionamento {
        margin-left: 20px;
    }

    .data {
        background-color: green;
        padding: .4rem .5rem;
        font-size: 1rem;
        font-weight: bold;
        border-radius: .8rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .choraria {
        background-color: #4400cc;
        padding: .2rem .3rem;
        font-size: 1rem;
        border-radius: .8rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .diurno {
        background-color: #ffcc66;
        padding: .2rem .3rem;
        font-size: 1rem;
        border-radius: .8rem;
        color: #000;
        cursor: default;
        border-color: #0d6efd;
        margin-left: 5px;

    }

    .noturno {
        background-color: #003399;
        padding: .2rem .3rem;
        font-size: 1rem;
        border-radius: .8rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        margin-left: 5px;
    }

    .plantao_24h {
        background-color: #ff660d;
        padding: .2rem .3rem;
        font-size: 1rem;
        border-radius: .8rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        margin-left: 5px;
    }

    .D_N {
        background-color: #ffcc66;
        padding: .2rem .3rem;
        font-size: 1rem;
        border-radius: .8rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        margin-left: 5px;
        background-image: linear-gradient(15deg, #ffcc66 50%, #003399 25%);
    }


    .valor {
        background-color: #009933;
        padding: .2rem .3rem;
        font-size: 1rem;
        border-radius: .8rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .tipo_afastamento {
        background-color: #a934ff;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;
        font-weight: bold;
    }
</style>