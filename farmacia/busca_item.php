<?php
include("../bd/conectabd.php");
?> <script>
    $("#cadastrar_novo_item").click(function(e) {
        e.preventDefault();
        btItem = $(this);
        linkCI = btItem.attr("href");
        console.log(linkCI);
        dialogItem = $("#dialogItem");
        $.get(linkCI, function(data) {
            dialogItem.html(data);

        });
        dialogItem = $("#dialogItem");
        dialogItem.dialog("open");
        dialogItem.dialog({
            position: {
                my: "center",
                at: "center",
                of: window
            },
            beforeClose: function(event, ui) {
                $("#dialog-buscaitem").load("/siiupa/farmacia/busca_item.php");
            }
        });

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
                console.log(data);
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
            let label_input = '<div class="input-group mb-3">  <div class="input-group-prepend">    <span class="input-group-text" id="basic-addon1">@</span>  </div>';

            //var linhaString = '<tr class="linha_item-${id_item_selecionado}" data-id="${id_item_selecionado}" data-categoria="${categoria_item_selecionado}" data-nome="${nome_item_selecionado}" data-quantidade="">
            //            <td class="seleciona_item_id col-md-1" data-href="${id_item_selecionado}"><input name="id_${id_item_selecionado}" type="text" id="item_id_${id_item_selecionado}" value="${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly></td>
            //            <td class="seleciona_item_categoria col-md-2" data-href="${categoria_item_selecionado}"><input name="categoria_${id_item_selecionado}" type="text" id="item_categoria_${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly></td>
            //            <td class="seleciona_item_nome" data-href="${nome_item_selecionado}"><input name="nome_${id_item_selecionado}" type="text" id="item_nome_${id_item_selecionado}" class="form-control-plaintext col-md-5" placeholder="Selecione acima" aria-label="item_nome" aria-describedby="basic-addon1" readonly></td>
            //            <td><input name="item_quantidade_${id_item_selecionado}" id="quantidade_${id_item_selecionado}" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1"></td>
            //        </tr>';
            var linhaString =
                `<tr></tr><tr id="linha_item_exclusao_${id_item_selecionado}" class="linha_item-${id_item_selecionado} linhas" data-id="${id_item_selecionado}" data-categoria="${categoria_item_selecionado}" data-nome="${nome_item_selecionado}" data-quantidade="">
            <td class="seleciona_item_id col-md-1" data-href="${id_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][id]" type="text" value="${id_item_selecionado}" id="item_id_${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly>
            </td>
            <td class="seleciona_item_categoria col-md-2" data-href="${categoria_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][categoria]" type="text" value="${categoria_item_selecionado}" id="item_categoria_${id_item_selecionado}" class="form-control-plaintext col-md-6" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly>
            </td>
            <td class="seleciona_item_nome" data-href="${nome_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][nome]" type="text" value="${nome_item_selecionado}" id="item_nome_${id_item_selecionado}" class="form-control-plaintext col-md-5 item_nome" placeholder="Selecione acima" aria-label="item_nome" aria-describedby="basic-addon1" readonly>
            </td>
            <td class="estoque_item_nome" data-href="${estoque_item_selecionado}">
            <input name="arrayitem[${id_item_selecionado}][estoque]" type="text" value="${estoque_item_selecionado}" id="item_nome_${id_item_selecionado}" class="form-control-plaintext text-center col-md-5" placeholder="Selecione acima" aria-label="item_nome" aria-describedby="basic-addon1" readonly>
            </td>
            <td  class="col-md-1">
            <input name="arrayitem[${id_item_selecionado}][qtd]" id="quantidade_${id_item_selecionado}" type="number" min="0" class="form-control quantidades" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </td>
            <td>
            <div class="exclusao_item" data-linha="linha_item_exclusao_${id_item_selecionado}"><img src="/siiupa/imagens/icones/lixeira.svg" width="20px"></div>
            </td>
            <tr id="linha_item_exclusao_${id_item_selecionado}_lote">
            <td>Lote:</td>
            <td>
            <input name="arrayitem[${id_item_selecionado}][lote]" id="lote_${id_item_selecionado}" type="text" class="form-control"  aria-describedby="inputGroup-sizing-sm">
            </td>
            <td>Validade:</td>
            <td>
            <input name="arrayitem[${id_item_selecionado}][validade]" id="validade_${id_item_selecionado}" type="date" class="form-control">
            </td>
            

                
                
            </td></tr></tr>`;

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
</script>
<input type="text" onkeyup="itemBusca()" class="form-control" placeholder="Pesquisar" aria-label="Username" aria-describedby="basic-addon1" id="buscaMedBC" value="">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span><a href="/siiupa/farmacia/item/novo" class="btn btn-sm" id="cadastrar_novo_item">+ Cadastrar novo</a></p>
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

        <?php

        $query = "SELECT I.id, I.nome, I.descricao, I.categoria_fk, I.quantidade, C.categoria, I.barcode FROM db_farmacia.tb_farmitem as I INNER JOIN db_farmacia.tb_farmcategoria as C on (I.categoria_fk = C.id)";

        if ($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($id, $nome, $descricao, $categoria_fk, $quantidade, $categoria, $barcode);
            while ($stmt->fetch()) {

                //Consulta todos os estoques, somando dos lotes
                $estoque = new BD;
                $sqlEstoque = "SELECT sum(estoque) as estoque FROM db_farmacia.tb_farmestoque where item_fk='$id' AND estoque>0 order by data_validade ASC";
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