<?php
include_once("../bd/conectabd.php");
if ($_GET['acao'] == "novoItem") {
    $textoBotao = "Cadastrar item";
    $idItem = "";
    $acao = "novoItem";
} elseif ($_GET['acao'] == "editaItem") {
    $textoBotao = "Editar item";
    $idItem = $_GET['iditem'];
    $acao = "editaItem";
?>


    <script>
        $(function() {
            iditem = $("#idItem").val();
            url = `/siiupa/farmacia/paginafarm_bdjson.php?acao=editaItem&iditem=${iditem}`;
            console.log(url);
            $.getJSON(url, function(data) {

                $("#idItem").val(data.id);


                $("#nomeItem").val(data.nome);

                $("#generoItem [selected]").attr('selected', '');
                $(`#generoItem [value='${data.genero_fk}']`).attr('selected', 'selected');

                $("#categoriaItem").attr('selected', '');
                $(`#categoriaItem [value='${data.categoria_fk}']`).attr('selected', 'selected');

                $("#categoria2Item").attr('selected', '');
                $(`#categoria2Item [value='${data.categoria2_fk}']`).attr('selected', 'selected');


                $("#categoria3Item").attr('selected', '');
                $(`#categoria3Item [value='${data.categoria3_fk}']`).attr('selected', 'selected');


                $("#categoria4Item").attr('selected', '');
                $(`#categoria4Item [value='${data.categoria4_fk}']`).attr('selected', 'selected');



                console.log(data);
                $("#barcodeItem").val(data.barcode);


            });
        });
    </script>
<?php
}

?>
<script>
    $(function() {


        function addClasseTerapeutica(texto, id) {
            console.log(`Id: ${id} | Texto: ${texto}`);
            console.log("oi");
            $("#lista_classes").append(`<input type='text' class='classes_terapeuticas' data-id'${id}' value='${texto}' readonly>`);
        }

    });
</script>
<style>
    #nomeItem {
        width: 400px;
    }

    .custom-combobox {
        position: relative;
        display: inline-block;
    }

    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }

    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
    }

    .classes_terapeuticas {
        background-color: green;
        padding: .2rem .3rem;
        font-size: .1rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        height: 12px;
    }
</style>
<input type="hidden" id="acaoItem" value="<?= $acao; ?>">
<input type="hidden" id="idItem" value="<?= $idItem; ?>">
<h3><?= $textoBotao; ?></h3>
<hr>
<!-- NOME -->
<div class="input-group lg">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Nome</span>
    </div>
    <textarea id="nomeItem" type="text" class="form-control" placeholder="Ex: ACEBROFILINA 5 MG/ML XAROPE 120 ML" aria-label="Username" aria-describedby="basic-addon1"></textarea>
</div>
<br>
<!-- NOME -->
<!-- GENERO -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="generoItem">Genero</label>
    </div>
    <select class="custom-select form-control select2_farmacia" id="generoItem">
        <option value="0" selected>Selecione</option>

    </select> <button class="btn btn-sm" id="novoGenero">+</button>

</div>

<!-- FIM GENERO -->

<div class="ui-widget"><small class='text-danger'>Obs: Não é necessário repetir a mesma classe.</small>
    <label for="tags"></label>
    <input id="tags">
</div>
<!-- CATEGORIA1 -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="categoriaItem">Classe Terapeutica 1</label>
    </div>
    <div class="ui-widget">


        <select class="custom-select select form-control" id="categoriaItem">
            <option value="0" selected></option>


        </select>
    </div>
    <div id="lista_classes"></div>


    <button class="btn btn-sm" id="novaCategoria">+</button>

</div>
<!-- FIM CATEGORIA1 -->
<!-- CATEGORIA2 -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="categoria2Item">Classe Terapeutica 2</label>
    </div>
    <div class="ui-widget">


        <select class="custom-select  form-control select select2_farmacia" id="categoria2Item">
            <option value="0" selected></option>


        </select>
    </div>
    <div id="lista_classes"></div>


    <button class="btn btn-sm" id="novaCategoria">+</button>

</div>
<!-- FIM CATEGORIA1 -->
<!-- CATEGORIA3 -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="categoria3Item">Classe Terapeutica 3</label>
    </div>
    <div class="ui-widget">


        <select class="custom-select  form-control select select2_farmacia" id="categoria3Item">
            <option value="0" selected></option>


        </select>
    </div>
    <div id="lista_classes"></div>


    <button class="btn btn-sm" id="novaCategoria">+</button>

</div>
<!-- FIM CATEGORIA3 -->
<!-- CATEGORIA4 -->

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="categoria4Item">Classe Terapeutica 4</label>
    </div>
    <div class="ui-widget">


        <select class="custom-select  form-control select select2_farmacia" id="categoria4Item">
            <option value="0" selected></option>


        </select>
    </div>
    <div id="lista_classes"></div>


    <button class="btn btn-sm" id="novaCategoria">+</button>

</div>
<!-- FIM CATEGORIA4 -->

<!-- NOME -->
<div class="input-group lg">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Código de Barras</span>
        <a href="#" id="buscaBC">Buscar</a>
        <a href="#" id="abresiteBC">Abrir site</a>
    </div>
    <input id="barcodeItem" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1"></input>
</div>
<br>
<!-- NOME -->
<br>

<hr>
<a class="btn btn-outline-info" id="voltaItem" onclick="itemCarrega(this, event)" href="/siiupa/farmacia/item">Voltar</a>
<a class="btn btn-outline-info" href="/siiupa/farmacia/bd" id="avancaItem"><?= $textoBotao; ?></a>
<div class='busca_escolha'></div>

<script>
    
    carregaCategoria();
    carregaGenero();

    function busca_escolhido(escolhido) {
        $("#nomeItem").val(escolhido.innerHTML);
        $('.busca_escolha').dialog('close');
    }

    $("#barcodeItem").focus();
    inputEle = document.getElementById('barcodeItem');
    inputEle.addEventListener('keyup', function(e) {
        var key = e.which || e.keyCode;
        if (key == 13) { // codigo da tecla enter
            // colocas aqui a tua função a rodar
            bc = $("#barcodeItem").val();
            url = "/siiupa/farmacia/paginafarm_bdjson.php?acao=buscamed&bc=" + bc;
            console.log(url);
            $.getJSON(url, function(data) {

                tituloBruto = '';
                tituloMod = '';


                var botao_opcao = '';
                data.items.forEach(function(index, length) {

                    tituloBruto = index.title;

                    tituloBruto = tituloBruto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                    if (index.title.indexOf("Produtos da") < 0) {
                        //console.log('a'+tituloBruto);


                        tituloBruto = tituloBruto.replace(/[ ][#|].*/, "");
                        tituloBruto = tituloBruto.replace(/[ ][#-][ GTIN].*/, "");
                        tituloBruto = tituloBruto.replace(/[ ][#-][ GTIN].*/, "");
                        tituloBruto = tituloBruto.replace(" ...", "");

                        if (tituloBruto != "") {
                            botao_opcao = botao_opcao + "<button class='btn btn-info' onclick='busca_escolhido(this)'>" + tituloBruto + "</button><hr>";
                        }

                        if (tituloMod.length < tituloBruto.length) {
                            tituloMod = tituloBruto;
                        }
                        //console.log('b'+tituloBruto);


                    }

                    //$("#nomeItem").val(tituloMod);


                });
                $(".busca_escolha").html(botao_opcao);
                $('.busca_escolha').dialog({
                    title: 'Escolha o nome para o item',



                });
                //tituloMod = data.items['1'].title;



                //$("#nomeItem").val(tituloMod);

            });
        }
    });
    $("#buscaBC").click(function(e) {
        bc = $("#barcodeItem").val();
        url = "/siiupa/farmacia/paginafarm_bdjson.php?acao=buscamed&bc=" + bc;
        $.getJSON(url, function(data) {
            tituloBruto = '';
            tituloMod = '';



            data.items.forEach(function(index, length) {

                tituloBruto = index.title;

                tituloBruto = tituloBruto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                if (index.title.indexOf("Produtos da") < 0) {
                    //console.log('a'+tituloBruto);


                    tituloBruto = tituloBruto.replace(/[ ][#|].*/, "");
                    tituloBruto = tituloBruto.replace(/[ ][#-][ GTIN].*/, "");
                    tituloBruto = tituloBruto.replace(/[ ][#-][ GTIN].*/, "");
                    tituloBruto = tituloBruto.replace(" ...", "");
                    if (tituloMod.length < tituloBruto.length) {
                        tituloMod = tituloBruto;
                    }
                    //console.log('b'+tituloBruto);


                }
                $("#nomeItem").val(tituloMod);

            });
        });
    });


    $("#abresiteBC").click(function(e) {
        bc = $("#barcodeItem").val();
        url = "https://cosmos.bluesoft.com.br/produtos/" + bc;
        window.open(url, '_blank');
    });


    function carregaGenero(id = 0) {
        $.getJSON("/siiupa/farmacia/bdjson/carregaGenero", function(data) {
            alvo = $("#generoItem");
            alvo.html('');
            alvo.append('<option value="0"  selected>Selecione</option>');
            $.each(data, function(key, val) {
                if (id == val.id) {
                    selected = "selected";

                } else {

                    selected = "";
                }
                option = `<option value='${val.id}' ${selected}>${val.genero}</option>`;
                alvo.append(option);
            });
        });
    }

    function carregaCategoria(id = 0) {
        $.getJSON("/siiupa/farmacia/bdjson/carregaCategoria", function(data) {
            alvo = $("#categoriaItem");
            alvo2 = $("#categoria2Item");
            alvo3 = $("#categoria3Item");
            alvo4 = $("#categoria4Item");


            alvo.html("");
            alvo2.html("");
            alvo3.html("");
            alvo4.html("");

            alvo.append('<option value="0"  selected>Selecione</option>');
            alvo2.append('<option value="0"  selected>Selecione</option>');
            alvo3.append('<option value="0"  selected>Selecione</option>');
            alvo4.append('<option value="0"  selected>Selecione</option>');
            let availableTags = [];

            $.each(data, function(key, val) {
                valorCategoria = val.categoria + ": " + key;
                availableTags.push(valorCategoria);
                if (id == val.id) {
                    selected = "selected";

                } else {

                    selected = "";
                }
                option = `<option value='${val.id}' ${selected}>${val.categoria}</option>`;
                alvo.append(option);
                alvo2.append(option);
                alvo3.append(option);
                alvo4.append(option);
            });
            $("#tags").autocomplete({
                source: availableTags
            });
            $("#tags").hide();
            //$(".custom-select").chosen();
            //$(".select2_farmacia").select2();
            //tag.replace(/.+[: ]/,'')

        });
    }

    $("#novoGenero").click(function(e) {
        novoGenero = prompt('Digite um nome para o novo gênero');
        if (novoGenero != null & novoGenero.length > 0) {
            $.post('/siiupa/farmacia/bd', {
                acao: 'novoGenero',
                novoGenero: novoGenero
            }, function(data) {
                $.alert(data);
                carregaGenero();
            });

        } else {
            $.alert("Inválido");

        }
    });
    $("#novaCategoria").click(function(e) {
        novaCategoria = prompt('Digite um nome para uma nova categoria');
        if (novaCategoria != null & novaCategoria.length > 0) {
            $.post('/siiupa/farmacia/bd', {
                acao: 'novaCategoria',
                novaCategoria: novaCategoria
            }, function(data) {
                $.alert(data);
                carregaCategoria();
            });
            return null;
        } else {
            $.alert("Inválido");
            return null;
        }
        return null;
    })

    $("#avancaItem").click(function(e) {
        e.preventDefault();

        dados = {
            id: $("#idItem").val(),
            nome: $("#nomeItem").val(),
            categoria: $("#categoriaItem").val(),
            categoria2: $("#categoria2Item").val(),
            categoria3: $("#categoria3Item").val(),
            categoria4: $("#categoria4Item").val(),
            genero: $("#generoItem").val(),
            barcode: $("#barcodeItem").val(),
            acao: $("#acaoItem").val()
        }
        console.log(dados);
        if (verificaVazio(dados)) {

            link = "/siiupa/farmacia/bd";

            $.post(link, {
                id: dados.id,
                nome: dados.nome,
                categoria: dados.categoria,
                categoria2: dados.categoria2,
                categoria3: dados.categoria3,
                categoria4: dados.categoria4,
                genero: dados.genero,
                barcode: dados.barcode,
                acao: dados.acao
            }, function(data) {
                $.alert(data, function() {
                    $("#dialogItem").dialog('close');

                });


            });
        }
    });

    function verificaVazio(input) {
        if (input.nome == '' || input.nome < 1 || input.categoria == 0 || input.genero == 0 || input.barcode == '') {
            $.alert(input.categoria);
            $.alert('Todos os campos são obrigatórios');
            return false;
        }
        return true;
    }
    
</script>
