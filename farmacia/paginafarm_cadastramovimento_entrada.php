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

    .tipo_movimento {
        display: none;
    }

    .destino {
        display: none;
    }

    .profissional {
        margin: 5px 0;
        border: 1px solid grey;
        padding: 5px 5px;
        background-color: #d6eaf8;
        text-align: center;
        display: none;
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
    .linhas{
        border-top: 1px solid black;
    }
    .item_nome {
        font-weight: bold;
    }
</style>


<form id="formcadastramovimento" action="/siiupa/farmacia/movimento/entrada/envia" method="post">
    <h2>ENTRADA DE ITEM NA FARMÁCIA</h2>

    <input type="hidden" name="setor" value="farm" />
    <input type="hidden" name="sub" value="entradamovimento" />
    <input type="hidden" name="acao" value="entradamovimento" />
    <input type="hidden" name="chave" value="<?=uniqid();?>" />
    <div class="movimento_grupos tipo_movimento">


        <div>
            <fieldset class='tipo_movimento'>
                <span>
                    <h4>Tipo de Movimento</h4>
                </span>
                <label>
                    <h3><input name="tipo_movimento" value="entrada" type="radio" aria-label="" class="form-check-input" checked>ENTRADA</h3>
                </label>

                <label>

                </label>
            </fieldset>
        </div>

    </div>

    <!-- //////////////////////// O R I G E M /////////////////////////// -->
    <div class="row movimento_grupos">
        <fieldset>
            <div class="row">
                <div class="col">
                    <h4>Origem</h4>
                    <?php

                    $query = "SELECT id, setor FROM u940659928_siupa.tb_farmsetor order by setor ASC";


                    echo "<select name='origem' class='form-control select2_farmacia'>";
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
        <!-- //////////////////////// D E S T I N O /////////////////////////// -->
        <fieldset class='destino'>
            <div class="row">
                <div class="col">
                    <h4>Destino</h4>
                    <?php

                    $query = "SELECT id, setor FROM u940659928_siupa.tb_farmsetor where setor='Farmacia';";

                    echo "<select name='destino' class='form-control'>";
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
    </div>

    <!-- PROFISSIONAL -->
    <div class="profissional">
        <span>
            <h4>PROFISSIONAL SOLICITANTE</h4>
        </span>
        <select class="form-select" aria-label="Default select example" id="profissional" name="profissional">
            <option value='0' selected>Selecione o profissional</option>

            <?php

            $query = "SELECT id, profissional FROM u940659928_siupa.tb_farmprofissional";


            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($idProfissional, $profissional);
                while ($stmt->fetch()) {
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
    
</div>
<script>
    $(function() {
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

            $(".quantidades").each(function() {
                if ($(this).val() < 1) {
                    
                    cont++;
                    alert("Não é permitido numero negativo.");
                    
                    $(this).css({
                        "border": "1px solid red",
                        "padding": "2px"
                    });
                    return;
                } else {
                    $(this).css({
                        "border": "1px solid green",
                        "padding": "2px"
                    });
                }

            });


            var paraChecagem = false;

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

          
               
          
            if (paraChecagem) {
                return false;
            }






            if (cont == 0) {
                $("#formcadastramovimento").submit();
            }
            

        });
        




        
        $("#busca_item").click(function() {
            $("#dialog-buscaitem").load("/siiupa/farmacia/busca_item.php");
            $("#dialog-buscaitem").dialog("open");
        });
        $("#dialog-buscaitem").dialog({
            autoOpen: false,
            resizable: false,
            height: 600,
            width: 800,
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