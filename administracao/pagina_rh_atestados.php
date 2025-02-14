<?php
include_once('../bd/conectabd.php');
session_start();
include_once('../bd/nivel.php');
?>
<h3>Afastamentos</h3>


<a href="?setor=adm&sub=rh&subsub=atestados" id="cadastraNovo" class="btn btn-outline-success">
    <img src="imagens/icones/person_add.svg">
    Cadastrar novo afastamento</a>

<hr>
<br>
<strong>Busca afastamento:</strong>
<form id="pesquisaAtestados">
    <input id="entrada" type="txt" placeholder="O que você quer buscar?">
    <input type="submit" value="Pesquisar"></input>
</form>
<hr>
<strong id="quantidade"></strong>
<span id="saidaTxt">Nenhum resultado...</span><br><br>



<div id="todos_atestados">
    <?php
     $atestadoContagem = new BD;
     $sqlContagem = "
     SELECT 
         COUNT(*) as total 
     FROM 
         u940659928_siupa.tb_afastamento as A 
     INNER JOIN 
         u940659928_siupa.tb_funcionario as f 
         ON (A.fk_funcionario = f.id) 
     INNER JOIN 
         u940659928_siupa.tb_cargo AS c 
         ON (f.fk_cargo = c.id) 
     INNER JOIN 
         u940659928_siupa.tb_afastamentos as afs 
         ON (A.fk_afastamentos = afs.id)
 ";
 $resultadoAtestadoContagem = $atestadoContagem->consulta($sqlContagem);
 var_dump($resultadoAtestadoContagem);
 print_r($_GET);

// Número de registros por página
$registrosPorPagina = 10;

// Determina a página atual (padrão é 1 se não for especificada)
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula o offset para a consulta SQL
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Consulta SQL principal com LIMIT e OFFSET para paginação

    $consulta_atestado = new BD;
    $sqlConsulta_Atestados = "
    SELECT 
        A.id as idAfastamento, 
        afs.afastamento, 
        afs.id as afastamento_id, 
        A.*, 
        f.nome, 
        f.id as idf, 
        c.titulo 
    FROM 
        u940659928_siupa.tb_afastamento as A 
    INNER JOIN 
        u940659928_siupa.tb_funcionario as f 
        ON (A.fk_funcionario = f.id) 
    INNER JOIN 
        u940659928_siupa.tb_cargo AS c 
        ON (f.fk_cargo = c.id) 
    INNER JOIN 
        u940659928_siupa.tb_afastamentos as afs 
        ON (A.fk_afastamentos = afs.id) 
    ORDER BY 
        A.id DESC 
    LIMIT $registrosPorPagina OFFSET $offset
";
    $resultadoConsulta_Atestados = $consulta_atestado->consulta($sqlConsulta_Atestados);

   

    foreach ($resultadoConsulta_Atestados as $resultado_atestado) {

        $firstDate  = new DateTime($resultado_atestado->data_inicio);
        $secondDate = new DateTime($resultado_atestado->data_fim);
        $intvl = $firstDate->diff($secondDate);
        $totalDias = $intvl->format('%R%a') + 1;
        $dias = $intvl->d;
        $dias = $dias + 1;
        //verifica se está ativo ou nome
        $dt_atual = date("Y-m-d");
        $hoje = new DateTime($dt_atual);

        //compara o formato completo da data se é maior ou igual a hoje
        if ($secondDate->format('c') >= $hoje->format('c')) {
            $classe_css = "ativo";
            $texto_etiqueta = "Ativo";
        } else {
            $classe_css = "inativo";
            $texto_etiqueta = "Inativo";
        }


        $afastamentoUtf8 = $resultado_atestado->afastamento;

       
        
        echo "<div class='box_atestados table-hover ' style='width:auto;' name='$resultado_atestado->nome'><span class='$classe_css' > $texto_etiqueta</span> <span class='tipo_afastamento'>  $afastamentoUtf8 </span><br>";
        echo "<span class='nome_funcionario'><a href='?setor=adm&sub=rh&subsub=atestado_exibe&idafastamento=$resultado_atestado->idAfastamento'> ";

        echo $resultado_atestado->nome . "</a></span> - <span class='nome_cargo'>" . utf8_encode($resultado_atestado->titulo) . "</span><br>";
        echo "De: <input class='data' type='date' value='" . $resultado_atestado->data_inicio . "' readonly> Até: <input class='data'  type='date' value='" . $resultado_atestado->data_fim . "' readonly><br>";

        echo "(" . $totalDias . " dias) | " . $intvl->y . " ano(s), " . $intvl->m . " mes(es) e " . $dias . " dia(s)";
        echo "<br>";
        $afastamentoObs = utf8_decode($resultado_atestado->afastamento_obs);
        echo "📝 $afastamentoObs";
        echo "<br>";


        echo "<button class='bt_editaAtestado form-control' style='width:100px;float:left;margin-right:5px;' data-idatestado='$resultado_atestado->id' data-idfuncionario='$resultado_atestado->fk_funcionario' data-data_inicio='$resultado_atestado->data_inicio' data-data_fim='$resultado_atestado->data_fim' data-afastamento='$resultado_atestado->afastamento' data-afastamentoid='$resultado_atestado->afastamento_id' data-nome='$resultado_atestado->nome' data-cargo='$resultado_atestado->titulo' data-afastamento_obs='$resultado_atestado->afastamento_obs'>Editar</button>";
        








        echo "</div>";
        echo "<p class='limpaFloat'></p>";
        //echo "<hr>";
    }
    ?>

</div>
<div id="dialogCadastraAtestado" title="Cadastrar novo afastamento">
    <div id="dialogCadastraAtestadoConteudo"></div>
</div>

<div id="dialogAnexaDocumentos" title="Anexar Documentos">
    <div id="dialogAnexaDocumentosConteudo">
        <h4></h4>
        <div class="alert alert-primary" role="alert">
            Selecione um arquivo.
        </div>
        <p><input type="file" name="file" class="file form-control" data-idf="teste" id="arquivo" required></p>
        <input type="submit" name="submitArquivo" class="submitArquivo btn btn-primary btn-sm" value="Enviar">
        <div id="carregaAnexos"></div>
    </div>
</div>

<script>
    $(function() {
        // Code goes here



        $(document).ready(function() {
            var busca = null;
            var boxes = $(".box_atestados"); //boxes onde contem os dados a serem pesquisados
            boxes = boxes.toArray();
            var array = [];
            var arrayValores = [];
            for (box in boxes) {
                array.push(boxes[box].attributes.name.value) //lista de valores a serem buscados

            }

            $('#pesquisaAtestados').bind('input', function() {
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
                        $('.box_atestados').show();
                    }

                } else {
                    $('#quantidade').html('');
                    $('#saidaTxt').text('Nenhum resultado...');

                    $('.box_atestados').show()
                }




            });
        });



        $(".alert").hide();

        $("#dialogCadastraAtestado").dialog({
            autoOpen: false,
            resizable: true,
            height: 560,
            width: 650,
            modal: true
        });
        $("#dialogAnexaDocumentos").dialog({
            autoOpen: false,
            resizable: true,
            height: 440,
            width: 500,
            modal: true
        });

        $(".bt_anexaDocumentos").on("click", function(e) {
            e.preventDefault();
            $("#dialogAnexaDocumentos").dialog("open");
            nome = $("#dialogAnexaDocumentosConteudo h4");
            idfuncionario = $(this).data('idfuncionario');
            $(nome).html($(this).data('nome'));
            $("#arquivo").data("idf", idfuncionario);
            linkAnexos = 'administracao/atestados/carregaanexos.php?perfilid=' + idfuncionario;
            $("#carregaAnexos").load(linkAnexos);


        });

        $('.submitArquivo').on('click', function() {

            var file_data = $('.file').prop('files')[0];
            var idf = $('.file').data('idf');

            if (file_data != undefined) {
                $(".submitArquivo")[0].value = "Enviando";

                var form_data = new FormData();
                form_data.append('file', file_data);

                $.ajax({
                    type: 'POST',
                    url: 'administracao/atestados/uploadarquivo.php?id=' + idf,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(response) {
                        if (response == 'success') {
                            //alert('File uploaded successfully.');
                            linkAnexos = 'administracao/atestados/carregaanexos.php?perfilid=' + idf;
                            $("#carregaAnexos").load(linkAnexos);
                            $(".submitArquivo")[0].value = "Enviado!";
                            $(".alert").hide();
                            $(".submitArquivo").css("background-color", "green");
                            setTimeout(function() {
                                $(".submitArquivo").css("background-color", "blue");
                                $(".submitArquivo")[0].value = "Enviar";
                            }, 1200);

                        } else {


                            $(".alert").text("Algo de errado, tente novamente");
                            $(".alert").show();
                            $(".submitArquivo")[0].value = "Enviar";
                            $(".submitArquivo").css("background-color", "blue");
                        }
                        //  location.reload();
                        $('.file').val('');
                    }
                });
            } else {
                $(".alert").show();
            }
            return false;
        });

        $("#cadastraNovo").on("click", function(e) {
            e.preventDefault();
            $.get('administracao/atestados/atestados_buscafuncionario.php', function(data) {
                $('#dialogCadastraAtestadoConteudo').html(data);
            });
            $("#dialogCadastraAtestado").dialog("open");
            $(".ui-dialog-title").html("Cadastrar Novo Afastamento");

        });
        $(".bt_editaAtestado").on("click", function(e) {
            e.preventDefault();
            idescolhido = $(this).data("idfuncionario");
            idatestado = $(this).data("idatestado");
            nomeescolhido = $(this).data("nome");
            cargoescolhido = $(this).data("cargo");
            data_inicio = $(this).data("data_inicio");
            data_fim = $(this).data("data_fim");
            afastamento = $(this).data("afastamento");
            afastamento_id = $(this).data("afastamentoid");
            afastamento_obs = $(this).data("afastamento_obs");




            linkformulario = "administracao/atestados/atestados_formularios.php?acao=edita&idfuncionario=" + idescolhido + "&idatestado=" + idatestado + "&nome=" + nomeescolhido + "&afastamento=" + afastamento + "&afastamento_id=" + afastamento_id + "&cargo=" + cargoescolhido + "&datainicio=" + data_inicio + "&datafim=" + data_fim + "&afastamento_obs=" + afastamento_obs;
            $.get(linkformulario, function(data) {
                $("#dialogCadastraAtestadoConteudo").html(data);
            });
            $("#dialogCadastraAtestado").dialog("open");
            $(".ui-dialog-title").html("Editar atestado");

        });
    });
</script>
<style type="text/css">
    .ativo {
        background-color: green;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .inativo {
        background-color: #ffc133;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #ff6433;
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

    .nome_funcionario {
        font-size: 18px;
        font-weight: bold;
    }

    .nome_cargo {
        font-size: 18px;
    }

    .data {
        box-shadow: 0 0 0 0;
        border: 0 none;
        outline: 0;
        color: #000;
    }

    .box_atestados {
        border: 1px solid #ccc;
        padding: 2px;
        background-color: #fff;
        overflow: hidden;
        height: auto;
    }

    .box_atestados:hover {
        background-color: #e2e7e8;
    }

    .limpaFloat {
        clear: both;
    }

    #carregaAnexos {
        font-size: 12px;
    }
</style>