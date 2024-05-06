<style>
    #addservidor {
        display: inline-block;
        padding: 5px 20px;
        background-color: #28a745;
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #addservidor:hover {
        background-color: #218838;
    }

    #addservidor:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
    }

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

    /* Estilo para o link "Excluir Vários" */
    #excluir_varios {
        display: inline-block;
        padding: 5px 20px;
        background-color: #f00;
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #excluir_varios:hover {
        background-color: #0056b3;
    }

    #excluir_varios:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3);
    }

    /* Estilo para o botão "Confirmar" e "Cancelar" */
    #confirmar_exclusao,
    #cancelar_exclusao {
        display: none;
        padding: 10px 20px;

        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        margin-right: 10px;
        cursor: pointer;
    }

    #confirmar_exclusao {
        background-color: #4caf50;
        margin-left: 5px;
    }

    #cancelar_exclusao {
        background-color: #f00;
    }


    #bloco-de-notas {
        position: absolute;
        top: 50px;
        left: 50px;
        width: 300px;
        height: 300px;
        border: 1px solid #ccc;
        background-color: #fff;
        display: none;
    }

    #barra-superior {
        background-color: #f2f2f2;
        padding: 5px;
        cursor: move;
    }

    #tituloBloco {
        font-weight: bold;
    }

    #botao-fechar {
        float: right;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    #conteudoBloco {
        padding: 10px;
        width: 100%;
        height: 100%;
    }
</style>
<?php

@include_once("../bd/conectabd.php");

$idescala = $_GET['id'];

$mes = $_GET['mes'];
$ano = $_GET['ano'];
//$sql = "SELECT * FROM u940659928_siupa.tb_escalas GROUP BY ano desc, mes desc  ";

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
<?php
$outrasMes = $_GET['mes'];
$outrasAno = $_GET['ano'];

$sql = "SELECT es.id, es.mes, es.ano, s.setor, es.oficial FROM u940659928_siupa.tb_escalas as es inner join u940659928_siupa.tb_setor as s on (es.fk_setor = s.id) WHERE es.ano = '$outrasAno' AND es.mes = '$outrasMes' ORDER BY s.setor ASC";
$busca = new BD;
$resultado = $busca->consulta($sql);

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
echo "<hr>";
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



<a class="btn btn-outline-dark" href='#' id="blocodenotas">
    <span class="ui-icon ui-icon-print"></span>Bloco de notas</a>
STATUS:
<div id="load_status_escala" class="spinner-border text-primary d-none" role="status">

</div>
<a id="bt_esc_oficial" data-oficial="sim" data-idescala="<?php echo $idescala; ?>" data-mes="<?php echo $mes; ?>" data-ano="<?php echo $ano; ?>" class="<?php echo $bt_oficial; ?> bt_oficial" href='#' target='_blank'>
    <img id='done-oficial' src='imagens/icones/done.svg' class='<?php echo $done_oficial; ?>'>OFICIAL</a>

<a id="bt_esc_rascunho" data-oficial="nao" data-idescala="<?php echo $idescala; ?>" data-mes="<?php echo $mes; ?>" data-ano="<?php echo $ano; ?>" class="<?php echo $bt_rascunho; ?> bt_oficial" href='#' target='_blank'>
    <img id='done-rascunho' src='imagens/icones/done.svg' class='<?php echo $done_rascunho; ?>'>RASCUNHO</a>
<hr />
<p>Ferramentas:
    <span type="button" class="btn btn btn-outline-dark" id="addservidor">
        ➕ Adicionar Servidor</span>
    <span id="excluir_varios">Excluir vários</span><span id="confirmar_exclusao" title="Confirmar exclusão" style='display:none'>✅</span><span id="cancelar_exclusao" style='display:none' title="Cancelar exclusão">❌</span>
</p>

<style>
    /* Estilo para a div que contém o conteúdo carregado pelo include */
    #carregaesqueleto {
        overflow-x: auto;
        white-space: nowrap; /* Evita que o conteúdo quebre em várias linhas */
    }

    /* Estilo para o conteúdo dentro da div */
    #carregaesqueleto > * {
        display: inline-block; /* Garante que o conteúdo não quebre em várias linhas */
        white-space: normal; /* Restaura o comportamento padrão de quebra de linha */
    }
</style>
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
                <ul>
        <li>
            <strong>15 de agosto de 2023</strong>
            <ul>
                <li>Terça</li>
                <li>Adesão do Pará à Independência - LEI N° 5.999, DE 10/09/1996 Feriado Estadual</li>
            </ul>
        </li>
        <li>
            <strong>7 de setembro de 2023</strong>
            <ul>
                <li>Quinta</li>
                <li>Independência do Brasil - leis 662, 06/04/1949, e 10.607, 19/12/2002 Feriado Nacional</li>
            </ul>
        </li>
        <li>
            <strong>12 de outubro de 2023</strong>
            <ul>
                <li>Quinta</li>
                <li>N S Aparecida – Padroeira do Brasil - Lei no 6.802, de 30/06/1980 Feriado Nacional</li>
            </ul>
        </li>
        <li>
            <strong>15 de outubro de 2023</strong>
            <ul>
                <li>Domingo</li>
                <li>Dia do Professor – Dec. Fed. 52.682, de 14/10/1963. Feriado Escolar</li>
                <li>Romaria XXXXXXXXXX</li>
            </ul>
        </li>
        <li>
            <strong>16 de outubro de 2023</strong>
            <ul>
                <li>Segunda</li>
                <li>Pós Romaria de N S de Nazaré Ponto Facultativo</li>
            </ul>
        </li>
        <li>
            <strong>28 de outubro de 2023</strong>
            <ul>
                <li>Sábado</li>
                <li>Dia do Servidor Público – Lei Mun. 003/99, Art. 218 Ponto Facultativo</li>
            </ul>
        </li>
        <li>
            <strong>2 de novembro de 2023</strong>
            <ul>
                <li>Quinta</li>
                <li>Dia de Finados - Lei no 10.607, de 19 de dezembro de 2002 Feriado Nacional</li>
            </ul>
        </li>
        <li>
            <strong>15 de novembro de 2023</strong>
            <ul>
                <li>Quarta</li>
                <li>Proclamação da República - Lei no 10.607, de 19 de dezembro de 2002 Feriado Nacional</li>
            </ul>
        </li>
        <li>
            <strong>8 de dezembro de 2023</strong>
            <ul>
                <li>Sexta</li>
                <li>Imaculada Conceição - Lei 026/83, 27/12/83 Feriado Municipal</li>
            </ul>
        </li>
        <li>
            <strong>24 de dezembro de 2023</strong>
            <ul>
                <li>Domingo</li>
                <li>Véspera de Natal Ponto Facultativo</li>
            </ul>
        </li>
        <li>
            <strong>25 de dezembro de 2023</strong>
            <ul>
                <li>Segunda</li>
                <li>Natal Lei n°10.607, de 19 de dezembro de 2022 Feriado Nacional</li>
            </ul>
        </li>
        <li>
            <strong>31 de dezembro de 2023</strong>
            <ul>
                <li>Domingo</li>
                <li>Véspera de Ano Novo Ponto Facultativo</li>
            </ul>
        </li>
    </ul>
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


            $sqlsetor = "SELECT  * FROM u940659928_siupa.tb_setor order by setor ASC";
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

<div id="bloco-de-notas">
    <div id="barra-superior">
        <span id="tituloBloco">Bloco de Notas</span>
        <button id="botao-fechar">X</button>
    </div>
    <textarea id="conteudoBloco" contenteditable="true"></textarea>
</div>
<script>
    $(document).ready(function() {

        $("#txtNotepad").val($.session.get('txtNotepad'));
    });

    $("#excluir_varios").click((e) => {
        e.preventDefault();
        $(".seleciona_exclusao").show();
        $("#confirmar_exclusao").show();
        $("#cancelar_exclusao").show();
    });

    $("#cancelar_exclusao").click(() => {
        // Ocultar elementos e redefinir seleção
        $(".seleciona_exclusao").prop("checked", false);
        $(".seleciona_exclusao").hide();
        $("#confirmar_exclusao").hide();
        $("#cancelar_exclusao").hide();
        $.notify(
            "Nada excluído", {
                position: 'left',
                className: 'info'
            });
    });

    $("#confirmar_exclusao").click(() => {
        $.notify(
            "Excluindo", {
                position: "left"
            });
        var elementos = $(".seleciona_exclusao:checked");
        var idsExclusao = [];

        elementos.each(function() {
            var valor = $(this).val();
            idsExclusao.push(valor);
        });

        var urlExclusao = "/siiupa/api/rh/api.php/records/tb_escala_funcionario/" + idsExclusao.join(",");

        console.log(urlExclusao);
        // Enviar a requisição de exclusão usando o Axios
        axios.delete(urlExclusao)
            .then(response => {
                console.log("Registros excluídos com sucesso!");
                var urlescala = (location.search);
                var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;

                $('#subconteudo').load(recarregaescala, () => {
                    $.notify(
                        "Sucesso, exclusões realizadas.", {
                            position: "left",
                            className: 'success'
                        });
                });
            })
            .catch(error => {

                $.notify(
                    "Erro: Nada excluído", {
                        position: 'left',
                        className: 'info'
                    });
            });

        // Ocultar elementos e redefinir seleção
        $(".seleciona_exclusao").hide();
        $("#confirmar_exclusao").hide();
        $("#cancelar_exclusao").hide();
    });


    function saveNotepad() {
        let txtNotepad = $("#txtNotepad").val();
        $.session.set('txtNotepad', txtNotepad);
        console.log(txtNotepad);
    }

    // Função para permitir a movimentação do bloco de notas
    // Função para tornar o bloco de notas arrastável, evitando arrastar ao selecionar o texto no textarea
    function tornarArrastavel(elemento) {
        var posicaoInicial = {
            x: 0,
            y: 0
        };
        var posicaoAtual = {
            x: 0,
            y: 0
        };
        var arrastando = false;
        var selecionandoTexto = false;

        // Verificar se o usuário está selecionando texto no textarea
        elemento.addEventListener('mousedown', function(event) {
            selecionandoTexto = event.target === elemento;
        });

        elemento.addEventListener('mousedown', iniciarArrastar);
        elemento.addEventListener('mouseup', pararArrastar);
        elemento.addEventListener('mousemove', arrastar);

        function iniciarArrastar(event) {
            if (!selecionandoTexto) {
                arrastando = true;
                posicaoInicial.x = event.clientX - posicaoAtual.x;
                posicaoInicial.y = event.clientY - posicaoAtual.y;
            }
        }

        function pararArrastar() {
            arrastando = false;
            selecionandoTexto = false;
        }

        function arrastar(event) {
            if (arrastando && !selecionandoTexto) {
                event.preventDefault();
                posicaoAtual.x = event.clientX - posicaoInicial.x;
                posicaoAtual.y = event.clientY - posicaoInicial.y;
                elemento.style.left = posicaoAtual.x + 'px';
                elemento.style.top = posicaoAtual.y + 'px';
            }
        }
    }

    // Obter referência ao bloco de notas e torná-lo arrastável
    var blocoDeNotas = document.getElementById('bloco-de-notas');
    var conteudoBloco = document.getElementById('conteudoBloco');
    tornarArrastavel(blocoDeNotas);

    // Impedir arrastar quando o usuário estiver selecionando o texto no textarea
    conteudoBloco.addEventListener('mousedown', function(event) {
        event.stopPropagation();
    });


    // Obter referência ao bloco de notas e torná-lo arrastável
    var blocoDeNotas = document.getElementById('bloco-de-notas');
    tornarArrastavel(blocoDeNotas);

    // Evento para fechar o bloco de notas
    var botaoFechar = document.getElementById('botao-fechar');
    botaoFechar.addEventListener('click', function() {
        document.getElementById('bloco-de-notas').style.display = 'none';
        var idServidorUsuario = <?php echo $_SESSION['idServidorUsuario']; ?>;
        var url = "/siiupa/api/rh/api.php/records/tb_funcionario/" + idServidorUsuario;

        var dados = {
            notepad_ativo: 0
        };

        // Converter o valor de notepad_ativo para número inteiro
        var dadosString = JSON.stringify(dados);
        console.log(dadosString);

        // Enviar a requisição PUT usando o Axios para alterar o valor de notepad_ativo para 0
        axios.put(url, dadosString)
            .then(response => {
                console.log("Valor de notepad_ativo alterado para 0");
                document.getElementById('bloco-de-notas').style.display = 'none'; // Oculta o bloco de notas após alteração
            })
            .catch(error => {
                console.error("Erro ao alterar o valor de notepad_ativo:", error);
            });
    });

    // Obter referências aos elementos relevantes
    var conteudoBloco = document.getElementById('conteudoBloco');

    // Evento para salvar o conteúdo ao digitar
    conteudoBloco.addEventListener('input', function() {
        $("#bloco-de-notas").notify("Salvando", "info");
        var idServidorUsuario = <?php echo $_SESSION['idServidorUsuario']; ?>;
        var url = "/siiupa/api/rh/api.php/records/tb_funcionario/" + idServidorUsuario;

        var dados = {
            notepad: conteudoBloco.value,
            notepad_ativo: 1
        };

        // Enviar a requisição PUT usando o Axios
        axios.put(url, JSON.stringify(dados))
            .then(response => {

                $("#bloco-de-notas").notify("Salvo!", "success");
            })
            .catch(error => {
                $("#bloco-de-notas").notify("Não foi possível salvar! Cuidado, copie os dados para não perdê-los", "error");
            });
    });
    // Obter referência ao elemento do conteúdo do bloco de notas
    var conteudoBloco = document.getElementById('conteudoBloco');

    // Função para carregar o conteúdo do bloco de notas
    function carregarConteudoBloco() {
        var idServidorUsuario = <?php echo $_SESSION['idServidorUsuario']; ?>;
        var url = "/siiupa/api/rh/api.php/records/tb_funcionario/" + idServidorUsuario;

        // Enviar a requisição GET usando o Axios
        axios.get(url)
            .then(response => {
                var dados = response.data;

                if (dados) {
                    // Definir o valor do textarea com base nos dados retornados
                    conteudoBloco.value = dados.notepad;

                    // Verificar o valor de notepad_ativo para exibir ou ocultar o bloco de notas
                    if (dados.notepad_ativo === 1) {
                        document.getElementById('bloco-de-notas').style.display = 'block';
                    } else {
                        document.getElementById('bloco-de-notas').style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.error("Erro ao carregar o conteúdo:", error);
            });
    }

    // Chamar a função para carregar o conteúdo do bloco de notas ao carregar a página
    window.addEventListener('load', carregarConteudoBloco);
</script>
<script src="/siiupa/js/jquery.session.js" defer></script>
<script src="/siiupa/administracao/pagina_escala_exibe.js?v=1"></script>
<script src="/siiupa/js/axios/axios.min.js" defer></script>