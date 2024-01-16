<?php

include("../bd/conectabd.php");
?>
<style>
    table .seleciona_item {
        cursor: pointer;
    }

    .movimento_grupos {
        margin: 5px 0;
        border: 1px solid grey;
        padding: 5px 5px;
        background-color: #d6eaf8;
        text-align: center;
    }

    .movimento_grupos h4 {
        color: #154c79;
        border-bottom: 2px solid lightgrey;
        background-color: #7b91e4;

    }

    .oculto {
        display: none;
    }

    .tipo_movimento {
        display: none;
    }

    .profissional {
        margin: 5px 0;
        border: 1px solid grey;
        padding: 5px 5px;
        background-color: #d6eaf8;
        text-align: center;
    }

    .profissional h4 {
        color: #154c79;
        border-bottom: 2px solid lightgrey;
        background-color: #7b91e4;

    }

    form h2 {
        color: #154c79;
        border-bottom: 4px solid lightgrey;
        border-left: 4px solid lightgrey;
    }
</style>


<form id="formcadastramovimento" action="/siiupa/farmacia/movimento/saida/envia" method="post">
    <h2>SAÍDA DE ITEM DA FARMÁCIA</h2>

    <input type="hidden" name="setor" value="farm" />
    <input type="hidden" name="sub" value="saidamovimento" />
    <input type="hidden" name="acao" value="saidamovimento" />
    <input type="hidden" name="chave" value="<?=uniqid();?>" />
    <div class="movimento_grupos tipo_movimento">
        <span>
            <h4>Tipo de Movimento</h4>
        </span>

        <div>
            <fieldset>


                <label>
                    <h3><input name="tipo_movimento" value="saida" type="radio" aria-label="" class="form-check-input" checked> SAÍDA</h3>
                </label>
            </fieldset>
        </div>

    </div>

    <!-- //////////////////////// O R I G E M /////////////////////////// -->
    <div class="row movimento_grupos">
        <fieldset class='oculto'>
            <div class="row">
                <div class="col">
                    <h4>Origem</h4>
                    <?php

                    $query = "SELECT id, setor FROM u940659928_siupa.tb_farmsetor  where setor='Farmacia'";


                    echo "<select name='origem' class='form-control select2_farmacia'>";
                            echo "<option value='4' selected>Farmacia</option>";
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->execute();
                        $stmt->bind_result($field1, $field2);
                        while ($stmt->fetch()) {
                            echo "<option value='$field1'>$field2</option>";
                        }
                        $stmt->close();
                    }
                    echo "</select>";
                    ?>




                </div>
            </div>
        </fieldset>
        <!-- //////////////////////// D E S T I N O /////////////////////////// -->
        <fieldset>
            <div class="row">
                <div class="col">
                    <h4>Destino</h4>
                    <?php

                    $query = "SELECT id, setor FROM u940659928_siupa.tb_farmsetor order by setor ASC";

                    echo "<select name='destino' class='form-control select2_farmacia'>";
                    echo "<option value='0'>Nenhum</opion>";
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->execute();
                        $stmt->bind_result($field1, $field2);
                        while ($stmt->fetch()) {
                            echo "<option value='$field1'>$field2</option>";
                        }
                        $stmt->close();
                    }
                    echo "</select>";
                    ?>




                </div>
            </div>
        </fieldset>
    </div>

    <!-- PROFISSIONAL -->
    <div class="profissional">
        <span>
            <h4>PROFISSIONAL SOLICITANTE</h4>
        </span>
        <select class="form-select select2_farmacia" aria-label="Default select example" id="profissional" name="profissional">
            <option value='0' selected>Selecione o profissional</option>

            <?php

            $query = "SELECT id, profissional FROM u940659928_siupa.tb_farmprofissional order by profissional ASC";


            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($idProfissional, $profissional);
                while ($stmt->fetch()) {
                    $profissional = $profissional;
                    echo "<option value='$idProfissional'>$profissional</option>";
                }
            }

            ?>
        </select>
    </div>
    <!-- PROFISSIONAL -->
    <!-- //////////////////////// I T E M /////////////////////////// -->
    <div class="movimento_grupos">
        <span>
            <h4>ITEM</h4>
        </span>



        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button type="button" class="btn btn-info" id="busca_item">
                    Selecionar Item
                    <span class="material-icons">
                        search
                    </span></button>



            </div>

        </div>

        <small>Adicionar item</small>
        <div class="input-group mb-3">


            <table class="table table-striped table-sm ">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">CATEGORIA</th>
                        <th scope="col">NOME</th>
                        <th scope="col">ESTOQUE</th>
                        <th scope="col col-md-1">QTD</th>
                        <th scope="col col-md-1"><img src="/siiupa/imagens/icones/lixeira.svg" width="20px"></th>

                    </tr>
                </thead>
                <tbody id="lista_item">

                </tbody>
            </table>
            <br>
        </div>


        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-data">Data</span>
            </div>
            <div class="col-md-2">


                <input name="data" id="data" type="date" size="10" value="" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                <script>










                </script>
            </div>
            <pre>   </pre>
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-data">Hora</span>
            </div>
            <div class="col-md-1">
                <input name="hora" id="hora" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">

            </div>
        </div>
    </div>


    <input type="submit" id="cadastramovimento" class="btn btn-primary" value="Cadastra movimento">


    <!-- //** busca e seleção de item */ -->


</form>
<script>
    // Busca Javascript
    function itemBusca() {
        let input = document.getElementById('buscaMedBC').value;
        input = input.toLowerCase();
        let x = document.getElementsByClassName('seleciona_item');

        for (i = 0; i < x.length; i++) {
            termo = $(x[i]).data('busca');
            if (!termo.toLowerCase().includes(input)) {
                x[i].style.display = "none";
            } else {
                x[i].style.display = "";
            }
        }
    }
</script>
<div id="dialog-buscaitem" title="Busque e selecione o item">
    <input type="text" onkeyup="itemBusca()" class="form-control" placeholder="Pesquisar" aria-label="Username" aria-describedby="basic-addon1" id="buscaMedBC" value="">

    <!--<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>-->
    <table class="table table-hover table-sm table-striped" id="tabelaItens">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">NOME</th>
                <th scope="col">ESTOQUE</th>
                <th scope="col">CATEGORIA</th>



            </tr>
        </thead>
        <tbody>
            <script>

            </script>
            <?php

            $query = "SELECT I.id, I.nome, I.descricao, I.categoria_fk, I.quantidade, C.categoria, I.barcode FROM u940659928_siupa.tb_farmitem as I INNER JOIN u940659928_siupa.tb_farmcategoria as C on (I.categoria_fk = C.id)";

            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($id, $nome, $descricao, $categoria_fk, $quantidade, $categoria, $barcode);
                while ($stmt->fetch()) {

                    //Consulta todos os estoques, somando dos lotes
                    $estoque = new BD;
                    $sqlEstoque = "SELECT sum(estoque) as estoque FROM u940659928_siupa.tb_farmestoque where item_fk='$id' AND estoque>0 order by data_validade ASC";
                    $estoque = $estoque->consulta($sqlEstoque);



                    foreach ($estoque as $somaEstoque) {
                        $quantidade = $somaEstoque->estoque;
                        if ($quantidade == '') {
                            $quantidade = 0;
                        }
                    }


                    // printf("%s, %s, %s, %s, %s\n", $datahora, $tipo, $novoestoque, $nome, $Origem);

                    echo "
                
                    <tr class='seleciona_item' data-id='$id' data-busca='$barcode $nome' data-categoria='$categoria' data-nome='$nome' data-quantidade='$quantidade'>
                    <td class='seleciona_item_id' data-href='$id'>$id</td>
                    <td class='seleciona_item_nome' data-href='$nome'>$nome</td>
                    <td class='seleciona_item_estoque'>$quantidade</td>
                    <td class='seleciona_item_categoria' data-href='$categoria'>$categoria</td>
                    
                    </tr>
                    ";
                }
                $stmt->close();
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    $(function() {
        //$(".select-origem").chosen();
        //$(".select2_farmacia").select2();



        jQuery("#data").mask("99/99/9999");
        jQuery("#hora").mask("99:99");

        $("#cadastramovimento").click(function() {
            // $("#formcadastramovimento").submit();

            var cont = 0;

            $("#formcadastramovimento input").each(function() {
                if ($(this).val() == "") {
                    $(this).css({
                        "border": "1px solid #F00",
                        "padding": "2px"
                    });
                    cont++;
                } else {
                    $(this).css({
                        "border": "1px solid lightgrey  ",
                        "padding": "2px"
                    });
                }

            });
            var tm_cont = 0;
            var origem_cont = 0;
            var destino_cont = 0;
            var quantidade_cont = 0;
            $("#formcadastramovimento input[type='radio']").each(function() {

                if ($(this)[0]['name'] == "tipo_movimento") {
                    if ($(this)[0]['checked']) {
                        tm_cont++;
                    }
                }

            });



            if ($('select[name=origem]').val() != '0') {
                origem_cont++;
            }


            if ($('select[name=destino]').val() != '0') {
                destino_cont++;
            }


            var paraChecagem = false;


            $(".quantidades").each(function() {
                if ($(this).val() > $(this).data('estoque') || $(this).val() < 1) {
                    quantidade_cont++;
                    $(this).css({
                        "border": "1px solid red",
                        "padding": "2px"
                    });
                }

            });

            if (tm_cont == 0) {
                $("#formcadastramovimento input[name='tipo_movimento']").css({
                    "border": "1px solid red",
                    "padding": "2px"
                });
                paraChecagem = true;
            }
            if (origem_cont == 0) {
                $("#formcadastramovimento select[name='origem']").css({
                    "border": "1px solid red",
                    "padding": "2px"
                });
                paraChecagem = true;
            }
            if (destino_cont == 0) {
                $("#formcadastramovimento select[name='destino']").css({
                    "border": "1px solid red",
                    "padding": "2px"
                });
                paraChecagem = true;
            }
            if (quantidade_cont > 0) {
                alert('A quantidade de saída não pode ser menor que o estoque do item ou negativa. Verifique as quantidades.');
                paraChecagem = true;
            }
            if (paraChecagem) {
                return false;
            }






            if (cont == 0) {
                $("#formcadastramovimento").submit();
            }

        });
        var listaItens = [];




        $(".seleciona_item").click(function() {
            data = new Date();
            var dia = data.getDate();

            function hoje() {
                data = new Date();
                dia = data.getDate();
                mes = data.getMonth()+1;
                ano = data.getFullYear();
                hora = data.getHours();
                minutos = data.getMinutes();
                if (mes < 10) {
                    mes = "0" + mes;
                }
                if (dia < 10) {
                    dia = "0" + dia;
                }


                document.getElementById('data').value = `${ano}-${mes}-${dia}`;
                console.log(`${ano}-${mes}-${dia}`);
                document.getElementById('hora').value = `${hora}:${minutos}`;

            }
            hoje();


            console.log('selecionou');

            let id_item_selecionado = $(this).data('id'); // ${id_item_selecionado}
            let categoria_item_selecionado = $(this).data('categoria'); // ${categoria_item_selecionado}
            let nome_item_selecionado = $(this).data('nome'); // ${nome_item_selecionado}
            let estoque_item_selecionado = $(this).data('quantidade'); // ${estoque_item_selecionado}

            //var linhaString = '<tr class="linha_item-${id_item_selecionado}" data-id="${id_item_selecionado}" data-categoria="${categoria_item_selecionado}" data-nome="${nome_item_selecionado}" data-quantidade="">
            //            <td class="seleciona_item_id col-md-1" data-href="${id_item_selecionado}"><input name="id_${id_item_selecionado}" type="text" id="item_id_${id_item_selecionado}" value="${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly></td>
            //            <td class="seleciona_item_categoria col-md-2" data-href="${categoria_item_selecionado}"><input name="categoria_${id_item_selecionado}" type="text" id="item_categoria_${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly></td>
            //            <td class="seleciona_item_nome" data-href="${nome_item_selecionado}"><input name="nome_${id_item_selecionado}" type="text" id="item_nome_${id_item_selecionado}" class="form-control-plaintext col-md-5" placeholder="Selecione acima" aria-label="item_nome" aria-describedby="basic-addon1" readonly></td>
            //            <td><input name="item_quantidade_${id_item_selecionado}" id="quantidade_${id_item_selecionado}" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1"></td>
            //        </tr>';
            var linhaString =
                `<tr id="linha_item_exclusao_${id_item_selecionado}" class="linha_item-${id_item_selecionado}" data-id="${id_item_selecionado}" data-categoria="${categoria_item_selecionado}" data-nome="${nome_item_selecionado}" data-quantidade="">
            <td class="seleciona_item_id col-md-1" data-href="${id_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][id]" type="text" value="${id_item_selecionado}" id="item_id_${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly>
            </td>
            <td class="seleciona_item_categoria col-md-2" data-href="${categoria_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][categoria]" type="text" value="${categoria_item_selecionado}" id="item_categoria_${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly>
            </td>
            <td class="seleciona_item_nome" data-href="${nome_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][nome]" type="text" value="${nome_item_selecionado}" id="item_nome_${id_item_selecionado}" class="form-control-plaintext col-md-5" placeholder="Selecione acima" aria-label="item_nome" aria-describedby="basic-addon1" readonly>
            </td>
            <td class="estoque_item_nome" data-href="${estoque_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][estoque]" type="text" value="${estoque_item_selecionado}" id="item_nome_${id_item_selecionado}" class="form-control-plaintext text-center col-md-5" placeholder="Selecione acima" aria-label="item_nome" aria-describedby="basic-addon1" readonly>
            </td>
            <td  class="col-md-1">
            <input name="arrayitem[${id_item_selecionado}][qtd]" id="quantidade_${id_item_selecionado}" data-estoque="${estoque_item_selecionado}" type="number" min="0" class="form-control quantidades" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </td>
            <td>
            <div class="exclusao_item" data-linha="linha_item_exclusao_${id_item_selecionado}"><img src="/siiupa/imagens/icones/lixeira.svg" width="20px"></div>
            </td>
            </tr>`;
            if (typeof listaItens[id_item_selecionado] == "undefined") {
                $("#lista_item").append(linhaString);
                listaItens[id_item_selecionado] = "Selecionado";
            } else {
                $.alert({
                    title: 'Item duplicado',
                    content: 'Este item já foi selecionado!',
                });
            }

            $(".exclusao_item").click(function() {

                linha = '#' + $(this).data('linha');
                linha_lote = '#' + $(this).data('linha') + "_lote";
                $(linha).remove();
                $(linha_lote).remove();

            });

            $("#dialog-buscaitem").dialog("close");


            // $("#item_id").val(id_item_selecionado);
            // $("#item_categoria").val(categoria_item_selecionado);
            // $("#item_nome").val(nome_item_selecionado);
            //$("#item_nome").append(nome_item_selecionado);
            //  $("#dialog-buscaitem").dialog("close");

            return false;

        });
        $("#busca_item").click(function() {
            $("#dialog-buscaitem").dialog("open");
        });
        $("#dialog-buscaitem").dialog({
            autoOpen: false,
            resizable: false,
            height: 600,
            width: 600,
            modal: true,
            buttons: {
                //"Delete all items": function() {


                // },
                Fechar: function() {
                    //$("tbody").append('<tr class="seleciona_item" data-id="oi%s" data-categoria="%s" data-nome="%s" data-quantidade="%s"><td class="seleciona_item_id" data-href="%s">%s</td><td class="seleciona_item_categoria" data-href="%s">%s</td><td class="seleciona_item_nome" data-href="%s">%s</td><td>%s</td></tr>');
                    $(this).dialog("close");

                }
            }
        });
    });
</script>