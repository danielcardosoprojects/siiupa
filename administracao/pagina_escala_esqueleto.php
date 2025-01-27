<?php

@session_start();
@include_once('../bd/conectabd.php');
// @include_once('../bd/nivel.php');

?>
<html>
<meta charset="utf-8" />

<head>
    <title>SIIUPA</title>


    <style>
        @media print {
            @page {
                size: landscape
            }
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 14px;


        }




        .table {
            width: 100%;
        }

        .table td {
            font-size: 14px;
            text-align: center;
        }

        .caption {
            font-size: 22px;
            font-family: calibri;
            border: 1px solid #000;
            width: 100%;
        }

        #tabelaCabecalho {
            border: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }


        #tabelaCabecalho th {
            width: 33%;
            padding: 0;
        }

        .editafuncionario {
            text-align: left;
            min-width: 100px;
            padding: 0;


        }

        #assinatura {
            text-align: center;
            width: 100%;
            height
        }
        .assinaturas {
            display:flex;
        }

        #footer {
            margin-top: 5px;
            text-align: center;
            font-size: 10px;
        }

        #legendas {

            text-align: left;
            width: 33%;
            border: 1px solid #000;
            float: left;
            font-size: 10px;
            overflow: hidden;
            padding-left: 5px;
        }

        .linha_escala {
            text-align: center;
        }

        .link-oculto {
            color: #000;
            text-decoration: none;
            margin: 0;
        }

        .excluiservidor {
            cursor: pointer;
        }

        .visita_perfil {
            cursor: pointer;
        }

        #ferias {

            text-align: left;


            float: left;
        }

        #assinatura {
            margin-left: 5px;
            text-align: center;
            width: 33%;

            border: 0;
            float: left;
            right: 0px;
            display: table-cell;
            width: 65%;
        }

        #assinatura div {
            height: 100%;
            width: 100%;
        }

        .atualizado {
            text-align: right;
            width: 100%;

        }

        #contentescala {
            overflow: auto;
            font-family: calibri;

        }

        .cargo_servidor {
            background-color: #DCE1E2;
            padding: .1rem .2rem;
            font-size: .5rem;
            border-radius: .2rem;
            color: #5f5f5f;
            cursor: default;
            border-color: #0d6efd;

        }

        @keyframes changeBackgroundColor {
            0% {
                background-color: #FFF;
            }

            20% {
                background-color: lightgreen;
            }

            100% {
                background-color: #FFF;
            }
        }

        #diasdasemana {
            text-align: center;
        }
    </style>

    <script>
        $(function() {
            $('.excluiservidor').click(function() {
                verificaStatus();
                var exclui = $(this);
                console.log(this);
                $.notify(
                            "Aguarde...", {
                                position: "l"
                            });
                var linkdeleta = "administracao/escalas/editaservidor_bd.php?acao=deleta" + "&idef=" + $(this).data('idef');

                //var confirmadelete = confirm("Ao excluir este(a) servidor(a) as informações dele(a) referente aos dias de escala serão perdidas.");

                $('#executabd').load(linkdeleta, function() {
                    var urlescala = (location.search);
                    var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;
                    $("#dialogconfig").dialog("close");
                    $('#subconteudo').load(recarregaescala, () => {
                        $.notify(
                            "Excluído", {
                                position: "left"
                            });
                    });

                });

            });



            $("#tabela_escala tbody").sortable().disableSelection();


            $("#editar_posicoes").click(function() {
                var valores = new Array();

                $('.linha_escala').each(function() {
                    valores.push($(this).data('idposicao'));
                });

                // Faça o que preferir com os valores
                posicoes = '';

                valores.forEach(function(i) {
                    //    console.log(valores.indexOf(i) + ': ' + i);
                    posicoes += '&posicoes[' + valores.indexOf(i) + ']' + '=' + i;


                });
                // console.log(posicoes);
                $.get("administracao/escalas/posicao_atualiza.php?acao=teste" + posicoes, function(retorno) {
                    //console.log(retorno);
                });
                // console.log(valores);
            });
            $('[data-toggle="tooltip"]').tooltip();


            $(".editadia").dblclick(function() {
                //var altera = prompt("Digite", $(this).text());
                var editadia = $(this);

                edita(editadia, proxima = 'nao');

            });

            function proximacelula(celula) {
                edita(celula);
            }
            var tab;
            var prox;

            function verificaStatus() {
                if ($("#statusEscala").val() == "oficial") {
                    $.alert("A escala precisa estar com o status de RASCUNHO para ser editável.");
                    pause;
                }
            }

            function edita(celula) {
                verificaStatus();

                // var editadia = $(this);

                var editadia = celula;
                input = "<input type='text' value='" + celula.text() + "' id='editando' size='1' style='background-color:white;border:0;margin:0;' >";

                //pinha alinha e a coluna
                idlinha = '.' + celula.data('idlinha');
                linha = $(idlinha);
                classcoluna = '.' + celula.attr('id');
                coluna = $(classcoluna);
                linha.css("background-color", "lightblue");
                coluna.css("background-color", "lightblue");
                /////////////

                celula.html(input);
                editadia.css("animation", "");
                $('#editando').focus();
                $('#editando').select();
                var prox = celula.next();




                // $("#editando").on('focusout', function(e) {});

                var availableTags = [
                    //"","D", "P", "N", "D/N", "M/T", "D¹", "N¹", "M", "T", "I"
                ];
                $("#editando").autocomplete({
                    source: availableTags,
                    minLength: 0,
                    autoFocus: false,
                    autoSelect: false
                });
                $("#editando").autocomplete("search", "");
                kd($('#editando'), editadia, celula.data('idlinha'));

            }

            function kd(celula, editadia, linha) {
                celulaF = editadia[0];

                $(".ui-autocomplete").on("click", function(e) {
                    teste = "a[id='" + linha + "']";
                    $(teste).focus();

                });
                celula.on('keydown focusout', function(e) {

                    function linhacorbranca(linha) {
                        classlinha = '.' + linha;
                        linha = $(classlinha);

                        linha.css("background-color", "white");
                        coluna.css("background-color", "white");
                        $('[data-toggle="tooltip"]').tooltip('hide');
                    }
                    var keyCode = e.keyCode || e.which;
                    var type = e.type;



                    //tab

                    if (!event.shiftKey && keyCode == 9) {
                        e.preventDefault();
                        var prox = editadia.next();
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 0.2s 1");
                        });
                        linhacorbranca(linha);
                        editadia.html('');
                        edita(prox);




                    }

                    //shift+tab
                    if (event.shiftKey && keyCode == 9) {
                        linhacorbranca(linha);
                        e.preventDefault();
                        var prox = editadia.prev();
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 2s 1");
                        });
                        editadia.html('');
                        if (prox.attr('class') != 'editafuncionario') {
                            edita(prox);
                        }
                    }
                    //enter
                    if (keyCode == 13) {
                        linhacorbranca(linha);
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 0.5s 1");
                        });
                        editadia.html('');
                        proxid = '#' + editadia.attr('id');

                        if (editadia.closest('tr').next().attr('class') == 'linhabranca') {
                            var enter = editadia.closest('tr').next().next().find(proxid);
                        } else {
                            var enter = editadia.closest('tr').next('tr').find(proxid);
                        }

                        edita(enter);


                    }
                    //setaprabaixo
                    if (keyCode == 40) {
                        linhacorbranca(linha);
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 2s 1");
                        });
                        editadia.html('');

                        proxid = '#' + editadia.attr('id');
                        if (editadia.closest('tr').next().attr('class') == 'linhabranca') {
                            var enter = editadia.closest('tr').next().next().find(proxid);
                        } else {
                            var enter = editadia.closest('tr').next('tr').find(proxid);
                        }

                        edita(enter);


                    }

                    //setapracima
                    if (keyCode == 38) {
                        linhacorbranca(linha);
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 2s 1");
                        });
                        editadia.html('');
                        proxid = '#' + editadia.attr('id');


                        if (editadia.closest('tr').prev().attr('class') == 'linhabranca') {
                            var enter = editadia.closest('tr').prev().prev().find(proxid);
                        } else {
                            var enter = editadia.closest('tr').prev('tr').find(proxid);
                        }

                        edita(enter);


                    }
                    //seta pra direita
                    if (keyCode == 39) {
                        linhacorbranca(linha);
                        e.preventDefault();
                        var prox = editadia.next();
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 2s 1");
                        });
                        editadia.html('');

                        edita(prox);



                    }
                    //seta pra esquerda
                    if (keyCode == 37) {
                        linhacorbranca(linha);
                        e.preventDefault();
                        var prox = editadia.prev();

                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');

                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 2s 1");
                        });
                        editadia.html('');
                        if (prox.attr('class') != 'editafuncionario') {
                            edita(prox);
                        }

                    }
                    //clicafora
                    if (type == 'focusout') {
                        linhacorbranca(linha);
                        var valor = celula.val();
                        var idlinha = editadia.data('idlinha');
                        var dia = editadia.data('dia');
                        editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {

                            editadia.css("animation", "changeBackgroundColor 2s 1");
                        });
                        editadia.html('');

                    }



                });
            }


            $('#legenda').dblclick(function() {
                verificaStatus();
                var legenda = $(this);
                var idescala = legenda.data('ide');
                var exemplosLegenda = "Exemplos:<br>M - Manhã 6h<br>T - Tarde 6h<br>N² - Noite 6h<br>P - Plantão 24h <br>D - Diurno 12h<br>N - Noturno 12h<br>F² - Ponto Facultativo<br>F³ - Feriado<br>";
                var textarea = "<textarea id='txtlegenda'>" + legenda.html() + "</textarea><button id='attlegenda' class='btn-success'>Atualizar</button><br>" + exemplosLegenda;
                $('#replacelegendas').html(textarea);
                $("#txtlegenda").jqte();
                var button = $('<div>', {
                class: 'jqte_tool jqte_tool_update',
                title: 'Inserir Data e Hora Atual',
                click: function() {
                    var editor = $(this).closest('.jqte').find('.jqte_editor');
                    var currentDateTime = new Date().toLocaleString();
                    var textToInsert = 'Atualizado em: ' + currentDateTime;
                    document.execCommand('insertText', false, textToInsert);
                }
            });

            // Append the custom button to the toolbar
            $('.jqte_toolbar').append(button);


                $('#attlegenda').click(function() {
                    var txtlegenda = $('textarea').val();
                    var linklegenda = "administracao/escalas/atualizalegenda.php?id=" + idescala + "&legenda=" + txtlegenda;
                    dataLegenda = {
                        id: idescala,
                        legenda: txtlegenda
                    }
                    $.post(linklegenda, dataLegenda, (data)=>{
                        $('#replacelegendas').html(data);

                    });
                    var urlescala = (location.search);

                    var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;
                    $('#subconteudo').load(recarregaescala);

                });
            });




        });
    </script>
     
</head>

<body style="font-family: calibri;margin-top:0;">
    <div id="contentescala">
        <?php

        class data
        {
            function dia()
            {
                return date("d", strtotime($this->data));
            }
            function qtddias()
            {
                return date("t", strtotime($this->data));
            }
            function diasemana()
            {
                $ingles = date("w", strtotime($this->data));

                switch ($ingles) {
                    case 0:
                        return "D";
                    case 1:
                        return "S";
                    case 2:
                        return "T";
                    case 3:
                        return "Q";
                    case 4:
                        return "Q";
                    case 5:
                        return "S";
                    case 6:
                        return "S";
                }
                return date("w", strtotime($this->data));
            }
            function diasemanaext()
            {
                $ingles = date("w", strtotime($this->data));

                switch ($ingles) {
                    case 0:
                        return "Domingo";
                    case 1:
                        return "Segunda";
                    case 2:
                        return "Terça";
                    case 3:
                        return "Quarta";
                    case 4:
                        return "Quinta";
                    case 5:
                        return "Sexta";
                    case 6:
                        return "Sabado";
                }
                return date("w", strtotime($this->data));
            }
            function mesext($entrada)
            {
                switch ($entrada) {
                    case 1:
                        return "Janeiro";
                    case 2:
                        return "Fevereiro";
                    case 3:
                        return "MarÇo";
                    case 4:
                        return "Abril";
                    case 5:
                        return "Maio";
                    case 6:
                        return "Junho";
                    case 7:
                        return "Julho";
                    case 8:
                        return "Agosto";
                    case 9:
                        return "Setembro";
                    case 10:
                        return "Outubro";
                    case 11:
                        return "Novembro";
                    case 12:
                        return "Dezembro";
                }
                return $entrada;
            }
        }




        class Tabela
        {
            public function abreTabela($nomeid, $class, $id = '')
            {
                echo "<table name='$nomeid' id='$nomeid' class='$class' $id>";
            }
            public function fechaTabela()
            {
                echo "</tbody>";
                echo "</table>";
            }

            public function abreThead()
            {
                echo "<thead><tr>";
            }
            public function tcabecalho($entrada)
            {
                echo "<th scope='col'>$entrada</th>";
            }

            public function fechaThead()
            {
                echo "</tr></thead><tbody>";
            }

            public function tabrelinha()
            {

                echo "<tr>";
            }

            public function tpopulalinha($entrada, $mesclalinhas = '')
            {
                if ($mesclalinhas != '') {
                    $mesclalinhas = "rowspan='$mesclalinhas'";
                }
                echo "<td $mesclalinhas>$entrada</td>";
            }

            public function tfechalinha()
            {

                echo "</tr>";
            }
        }
        //IMPRIME
        if (!isset($_GET['setor'])) {
            function pega($entrada)
            {
                if (isset($_GET[$entrada])) {
                    return $_GET[$entrada];
                }
                return null;
            }
            $setorExt = pega('setorExt');
            $mesExt = pega('mesExt');
            $anoExt = pega('anoExt');
            $tituloPagina = "Escala " . $setorExt . " - " . $mesExt . " " . $anoExt;

            
        }
        if (isset($_GET['id'])) {
            $idescala = $_GET['id'];
        } else {
        }
        $sql = "SELECT s.setor, e.* FROM u940659928_siupa.tb_escalas AS e INNER JOIN u940659928_siupa.tb_setor AS s ON (e.fk_setor = s.id) WHERE e.id=$idescala ";
        $busca = new BD;
        $resultado = $busca->consulta($sql);
        $mesext = new data;
        $mesext = $mesext->mesext($resultado[0]->mes);
        $legendaescala = $resultado[0]->legenda;
        global $atualizado;
        $atualizado = date("d\/m\/y H:s", strtotime($resultado[0]->updated_at));;



        $tab = new Tabela;

        $tab->abreTabela('tabelaCabecalho', $class = '');
        $tab->abreThead();
        $tab->fechaThead();
        $tab->tabrelinha();
        $tab->tpopulalinha('<img src="/siiupa/imagens/gov_logo_2021.png" width="200px">');
        $tab->tpopulalinha('PREFEITURA MUNICIPAL DE CASTANHAL<br>SECRETARIA MUNICIPAL DE SAÚDE-SESMA<br>COORDENAÇÃO DE URGÊNCIA E EMERGÊNCIA<br>UPA III - GOVERNADOR ALMIR GABRIEL', $mesclalinhas = '3');
        $tab->tpopulalinha('<img src="/siiupa/imagens/upa_hor_logo.JPG" height="45px">');
        $tab->tfechalinha();
        // $tab->tabrelinha();
        // $tab->tpopulalinha('<img src="/siiupa/imagens/pmc_logo.PNG" height="45px">', $mesclalinhas = '4');
        // $tab->tpopulalinha('');
        // $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('');
        $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('');
        $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('');

        $tab->tfechalinha();
        $tab->fechaTabela();

        ?>
        <table class="table caption-top  table-bordered table-hover" id="tabela_escala">
            <caption class="border-bottom-0 caption" id="titulo_escala">

                <?php
                $tituloPagina = strtoupper($resultado[0]->setor . " - " . $mesext . " - " . $resultado[0]->ano); 
                echo strtoupper($resultado[0]->setor . " - " . $mesext . " - " . $resultado[0]->ano); 
                if(!isset($_GET['oficial'])){
                echo "<script>document.title='$tituloPagina';window.print();//window.close();</script>";
        
                }
                 ?>
            </caption>
            <script type="text/javascript">
                $('html head').find('title').text('SIUPA - ' + $('#titulo_escala').text());
            </script>
            <thead id="tabelathead">
                <tr>
                    <th scope="col" style="background-color:#fff;width:auto;">Escala <button id="editar_posicoes"></button></th>
                    <?php


                    $dia = "01";
                    $mes = $resultado[0]->mes;
                    $ano = $resultado[0]->ano;
                    $data = new data;
                    $data->data = "$ano-$mes-$dia";


                    $qtddias = $data->qtddias();


                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data->data = "$ano-$mes-$i";
                        $cadadia = $data->dia();
                        $fds = date("w", strtotime($data->data));

                        if ($fds == 0 || $fds == 6) {
                            $corfds = " background-color:#ff9933";
                        } else {
                            $corfds = " background-color:#fff";
                        }
                        echo "<th scope='col' style='text-align:center;$corfds'>$cadadia</th>";
                    }

                    ?>
                </tr>
                <tr>
                    <th col="scope" class="table" style="background-color:#fff;width:auto;">NOME</th>
                    <?php




                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data = new data;
                        $data->data = "$ano-$mes-$i";
                        $diadasemana = $data->diasemana();
                        $fds = date("w", strtotime($data->data));
                        if ($fds == 0 || $fds == 6) {
                            $corfds = " background-color:#ff9933";
                        } else {
                            $corfds = " background-color:#fff";
                        }
                        echo "<th scope='col' id='diasdasemana' style='text-align:center;$corfds'> $diadasemana</th>";
                    }

                    ?>
                </tr>
            </thead>
            <div id='executabd'></div>
            <tbody>

                <?php



                $sqlserv = "SELECT f.conselho_tipo, f.conselho_n, c.funcao_upa, c.titulo, f.fk_cargo, f.nome, ef.* FROM u940659928_siupa.tb_escala_funcionario as ef INNER JOIN u940659928_siupa.tb_funcionario AS f ON (ef.fk_funcionario = f.id) INNER JOIN u940659928_siupa.tb_cargo AS c ON (f.fk_cargo = c.id) WHERE ef.fk_escala=$idescala order by ef.posicao ASC, f.nome ASC, ef.id ASC";
                $buscaserv = new BD;
                $resultadoserv = $buscaserv->consulta($sqlserv);
                $feriaslegenda = "";
                foreach ($resultadoserv as $serv) {

                    //prepara a legenda de ferias//

                    $sqlferiasleg = "SELECT DATE_FORMAT(ferias.datainicio, '%d/%m/%Y') as feriasinicio, DATE_FORMAT(ferias.datafim, '%d/%m/%Y') as feriasfim,ferias.* FROM u940659928_siupa.tb_ferias as ferias WHERE ferias.fk_funcionario = '$serv->fk_funcionario' AND (MONTH(ferias.datainicio) = $mes OR MONTH(ferias.datafim) = $mes) AND ferias.ref_ano = $ano";
                    $buscaferiasleg = new BD;
                    $resultadoferiasleg = $buscaferiasleg->consulta($sqlferiasleg);

                    if (count($resultadoferiasleg) == 1) {
                        $feriaslegenda = $feriaslegenda . $serv->nome . ": " . $resultadoferiasleg[0]->feriasinicio . " a " . $resultadoferiasleg[0]->feriasfim . "<br>";
                    } //fim da legenda de ferias

                    $nome = reduzirNome($serv->nome, 50);
                    $primeiroNome = reduzirNome($serv->nome, 5);

                    //var_dump($serv);
                    //FOMARTA CONSELHO E NUMERO SE TIVER
                    if ($serv->conselho_tipo != NULL) {
                        $dados_conselho = "/ $serv->conselho_tipo:$serv->conselho_n";
                    } else {
                        $dados_conselho = "";
                    }

                    $checkboxExclusao = "<input type='checkbox' class='seleciona_exclusao' value='$serv->id' style='display:none'></input>";
                    //na pagina exibe, um jquery torna visivel. Isso se faz necessário para que o checkbox não apareça na pagina de impressao

                    $nomeexemplo = "<tr id='$serv->id' class='linha_escala' data-idposicao='$serv->id'><th scope='row' class='editafuncionario table-sm $serv->id' data-idef='$serv->id' data-idf='$serv->fk_funcionario' data-nomeservidor='$nome' data-posicao='$serv->posicao'><a href='#' id='$serv->id' class='link-oculto'>" . $nome . "</a><br><span class='cargo_servidor'>" . $serv->titulo . " $dados_conselho</span><a title='Visitar perfil' target='_blank' href='?setor=adm&sub=rh&subsub=perfil&id=$serv->fk_funcionario'><span class='ui-icon ui-icon-person'></span></a><span title='Excluir da escala, não pode ser desfeito' class='excluiservidor' data-idef='$serv->id'><span class='ui-icon 	ui-icon-trash'></span></span>$checkboxExclusao</th>";
                    echo $nomeexemplo;
                    $data = "$ano-$mes-$dia";
                    $qtddias = date("t", strtotime($data));



                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data = "$ano-$mes-$i";
                        $dia = date("d", strtotime($data));
                        $diasemana = date("w", strtotime($data));

                        $idlinha = $serv->id;
                        $diasemanaext = new data;
                        $diasemanaext->data = "$ano-$mes-$i";
                        $diadasemanaext = $diasemanaext->diasemanaext();

                        if ($i == $serv->ferias_inicio) {
                            $dias = $serv->ferias_fim - $serv->ferias_inicio + 1;
                            if($serv->vinculo == "EFETIVO") {
                                $textoferias = "FERIAS REGULAMENTARES";
                            } else {
                                $textoferias = "RECESSO";
                            }
                            
                            echo "<td colspan='$dias' style='letter-spacing: .15rem;'>$textoferias</td>";
                            $i = $i + $dias - 1;
                            continue;
                        }
                        if ($i == $serv->licenca_inicio) {
                            $diaslicenca = $serv->licenca_fim - $serv->licenca_inicio + 1;


                            echo "<td colspan='$diaslicenca' style='letter-spacing: .15rem; font-family: calibri'>" . $serv->licenca_texto . "</td>";
                            $i = $i + $diaslicenca - 1;
                            continue;
                        }

                        //pega o plantao do dia especifico
                        $plantaodia = $serv->{"d$i"};

                        //verifica se é mais de uma letra, para poder diminuir se for o caso
                        if (strlen($plantaodia) > 1) {
                            $tamanholetra = "style='font-size:11.2px;padding:0;'";
                        } else {
                            $tamanholetra = "";
                        }
                        echo "<td id='dia$i' class='dia$i editadia align-middle $idlinha' data-toggle='tooltip' data-placement='bottom' data-idlinha='$idlinha' data-dia='d$i' title='$primeiroNome | Dia $i | $diadasemanaext ' $tamanholetra>";

                        echo $plantaodia;
                        echo "</td>";
                    }
                    echo "</tr>";
                    //adicionalinha em branco se estiver marcado no pos branco
                    if ($serv->posbranco == "sim") {
                        $mescla = $qtddias + 1;
                        echo "<tr class='linhabranca'><td colspan='$mescla' style='height:15px'></td></tr>";
                    }
                }

                ?>


            </tbody>
        </table>
        <div id='footer'>

            <div id='legendas'>

                <div><strong>Legendas</strong></div>
                <div id="replacelegendas">
                    <div id='legenda' data-ide='<?php echo $idescala; ?>'>
                        <?php
                        if ($legendaescala == "") {
                            $legendaescala = "<br><br>";
                        }
                        
                        echo $legendaescala; ?>

                    </div>
                </div>


                <div>
                    <div id="ferias">
                        <?php if ($feriaslegenda != "") {
                            echo "<div><strong>Férias/Recesso</strong></div>";
                            echo "<div>";
                            echo $feriaslegenda;
                            echo "</div>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <div id='assinatura'>
            <!-- <div class='atualizado'>Atualizado em: <?php echo $atualizado; ?></div> -->
            <div class='assinaturas'>
            <!-- <div>_____________________________<br>Assinatura Responsável</div> -->
            <div><br><br><br>_____________________________<br>Assinatura Responsável</div>
            </div>
        </div>

    </div>
    </div>







</body>

</html>
<?php

function reduzirNome($texto, $tamanho)
{
    // Se o nome for maior que o permitido
    if (strlen($texto) > ($tamanho - 2)) {
        $texto = strip_tags($texto);

        // Pego o primeiro nome
        $palavas    = explode(' ', $texto);
        $nome       = $palavas[0];

        // Pego o ultimo nome
        $palavas    = explode(' ', $texto);
        $sobrenome  = trim($palavas[count($palavas) - 1]);

        // Vejo qual e a posicao do ultimo nome
        $ult_posicao = count($palavas) - 1;

        // Crio uma variavel para receber os nomes do meio abreviados
        $meio = '';

        // Listo todos os nomes do meios e abrevio eles
        for ($a = 1; $a < $ult_posicao; $a++) :

            // Enquanto o tamanho do nome nao atingir o limite de caracteres
            // completo com o nomes do meio abreviado
            if (strlen($nome . ' ' . $meio . ' ' . $sobrenome) <= $tamanho) :
                $meio .= ' ' . strtoupper(substr($palavas[$a], 0, 1));
            endif;
        endfor;
    } else {
        $nome       = $texto;
        $meio       = '';
        $sobrenome  = '';
    }

    return trim($nome . $meio . ' ' . $sobrenome);
}


?>