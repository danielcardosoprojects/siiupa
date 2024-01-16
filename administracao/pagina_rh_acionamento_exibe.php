<h3>Acionamento</h3>

<hr>
<div id="box_grande">

    <?php
    $id_acionamento = $_GET['id'];

    $consulta_acionamento = new BD;
    $sqlConsulta_Acionamento = "SELECT ac.*, f.nome, acs.acionamento, acs.id as acionamentosId, f.fk_cargo as cargoId, cargo.funcao_upa FROM u940659928_siupa.tb_acionamento as ac inner join u940659928_siupa.tb_funcionario as f on (ac.fk_funcionario = f.id) inner join u940659928_siupa.tb_cargo as cargo on (f.fk_cargo = cargo.id) inner join u940659928_siupa.tb_acionamentos as acs on(ac.fk_acionamentos = acs.id) where ac.id = '$id_acionamento' ORDER BY ac.id DESC";

    $resultadoConsulta_Acionamento = $consulta_acionamento->consulta($sqlConsulta_Acionamento);

    foreach ($resultadoConsulta_Acionamento as $resultado_acionamento) {

        $fk_afastamento = $resultado_acionamento->fk_afastamento;


        $data_acionamento = new DateTime($resultado_acionamento->data_acionamento);
    ?>

        <div class="box_acionamentos" id="box_<?php echo $resultado_acionamento->id; ?>" data-id="<?php echo $resultado_acionamento->id; ?>" name='<?php echo $resultado_acionamento->nome ?>'>
            <span class="acionamentoEtiqueta">📣 Acionamento:</span>
            <div class="nome">
                <h5>👤 <a href="#"><?php echo utf8_encode($resultado_acionamento->nome); ?></a><span class="ui-icon ui-icon-copy copiarAcionamento" data-id="<?php echo $resultado_acionamento->id; ?>" data-text=""></span></h5>
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
                    $sqlConsulta_Afastamento = "SELECT f.nome as nomeAfastado, c.titulo as tituloCargo, afs.afastamento, af.id as idAfastado, af.data_inicio, af.data_fim FROM u940659928_siupa.tb_afastamento as af inner join u940659928_siupa.tb_funcionario as f on (af.fk_funcionario = f.id) inner join u940659928_siupa.tb_afastamentos as afs on (af.fk_afastamentos = afs.id) inner join u940659928_siupa.tb_cargo as c on (f.fk_cargo = c.id) WHERE af.id='$resultado_acionamento->fk_afastamento'";

                    $resultadoConsultaAfastamento = $consulta_afastamento->consulta($sqlConsulta_Afastamento);
                    ////////////////////////////////// var_dump($resultadoAfastamento);
                    $resultadoAfastamento = $resultadoConsultaAfastamento[0];
                    $dataInicio = new DateTime($resultadoAfastamento->data_inicio);
                    $dataFim = new DateTime($resultadoAfastamento->data_fim);
                    $dataInicio = $dataInicio->format('d/m/Y');
                    $dataFim = $dataFim->format('d/m/Y');
                    echo "🏃<span class='tipo_afastamento'>" . utf8_encode($resultadoAfastamento->afastamento) . "</span>";
                    echo "<br>";
                    echo "<span><a href='#'>$resultadoAfastamento->nomeAfastado - " . utf8_encode($resultadoAfastamento->tituloCargo) . " - $dataInicio a $dataFim</a></span>";
                } ?>


            </div>
            <div class="obs_acionamento">📝 <?php echo utf8_encode($resultado_acionamento->acionamento_obs); ?></div>
            <button class="editaAcionamento ui-button ui-widget ui-corner-all" data-idescolhido="<?php echo $resultado_acionamento->id; ?>" data-idfuncionario="<?php echo $resultado_acionamento->fk_funcionario; ?>" data-nome="<?php echo $resultado_acionamento->nome; ?>" data-cargoescolhidoId="<?php echo $resultado_acionamento->cargoId; ?>" data-cargoescolhido="<?php echo $resultado_acionamento->funcao_upa; ?>" data-acionamentosId="<?php echo $resultado_acionamento->acionamentosId; ?>" data-acionamentosTxt="<?php echo utf8_encode($resultado_acionamento->acionamento); ?>" data-afastamentoId="<?php echo $resultado_acionamento->fk_afastamento; ?>" data-dataAcionamento="<?php echo $data_acionamento->format('Y-m-d'); ?>" data-ch="<?php echo $resultado_acionamento->qtd_horas; ?>" data-turno="<?php echo $resultado_acionamento->turno; ?>" data-acionamentoobs="<?php echo utf8_encode($resultado_acionamento->acionamento_obs); ?>">Editar</button>
            <span id="deletaAcionamento" class="btn btn-danger" data-idescolhido="<?php echo $resultado_acionamento->id; ?>">Deletar</span>

        </div>

    <?php } ?>
</div>


<div id="dialog" title="Basic dialog">
</div>

<script>
    $(function() {

        $(document).ready(function() {


            $('html head').find('title').text("SIUPA - Acionamento");


        });
        $("#deletaAcionamento").click(function(e) {
            e.preventDefault();
            idacionamento = $(this).data("idescolhido");
            $.confirm({
                title: 'Confirmação',
                content: 'Tem certeza que deseja excluir? Esta ação não poderá ser desfeita.',
                buttons: {
                    "Confirmar": function() {
                        linkDeleta = ``;
                        $.get('administracao/acionamentos/acionamentos_executa.php?acao=deleta&idacionamento=' + idacionamento, function(data) {
                            $('#box_grande').html(data);
                            console.log(data);
                            console.log('administracao/acionamentos/acionamentos_executa.php?acao=deleta&id=' + idacionamento)
                            $.alert('Confirmado!');
                        });
                        
                    },
                    "Cancelar": function() {
                        $.alert('Cancelado!');
                    }
                }
            });


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

            idacionamento = $(this).data("idescolhido");
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
            linkformulario = "administracao/acionamentos/acionamentos_formularios.php?acao=edita&idacionamento=" + idacionamento + "&idfuncionario=" + idfuncionario + "&nome=" + nomeescolhido + "&cargo=" + cargoescolhido + "&acionamentosId=" + acionamentosid + "&acionamentostxt=" + acionamentostxt + "&afastamentoId=" + afastamentoId + "&dataacionamento=" + dataacionamento + "&ch=" + ch + "&turno=" + turno + "&acionamentoobs=" + acionamentoobs;
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
        flex-wrap: wrap;

        justify-content: space-around;
        padding: 4px;
    }

    .box_acionamentos {
        align-items: center;
        width: 90%;
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
        flex-direction: column;
        flex-wrap: wrap;
        gap: 5px;
        text-align: center;
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
        text-align: center;
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