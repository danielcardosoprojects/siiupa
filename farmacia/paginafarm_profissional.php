<?php

include_once("../bd/conectabd.php");

if (!isset($_GET['acao'])) {


?>

    <a href="/siiupa/farmacia/profissional?acao=editar" onclick='profissionalCarrega(this, event)' id="editarProfissional" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px"> Lista de Profissionais</a>
    <br>
    <br>
    <a href="/siiupa/farmacia/profissional?acao=cadastra" onclick='profissionalCarrega(this, event)' id="cadastrarProfissional" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px"> Cadastrar novo profissional</a>

    <?php

} else {
    $acao = $_GET['acao'];
    if ($acao == 'cadastra') {
    ?> Nome:
        <input type="text" value="" class="form-control" id="nomeProfissional">
        Função
        <select name="" class=" form-control floatleft" id="cargoProfissional">
            <option value="">Selecionar</option>
            <?php
            $query = "SELECT descricao FROM u940659928_siupa.tb_cargo ORDER BY DESCRICAO ASC";


            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($descricao);
                while ($stmt->fetch()) {
                    echo "<option value='$descricao'>$descricao</option>";
                }
                $stmt->close();
            }
            ?>
        </select>
        Registro Conselho
        <input type="text" value="" class="form-control" id="conselhoProfissional">


        <a href="/siiupa/farmacia/profissional" onclick='profissionalCarrega(this, event)' id="volta" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px">Voltar</a>
        <a href="#" onclick='avanca(this, event)' id="avanca" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px">Continuar</a>
        <script>
            function avanca(link, e) {
                e.preventDefault();
                nomeProfissional = $("#nomeProfissional").val();
                cargoProfissional = $("#cargoProfissional").val();
                if (cargoProfissional == "" || nomeProfissional == "") {
                    $.alert("Nome ou Cargo não podem estar vazios.");
                    return;
                }
                conselhoProfissional = $("#conselhoProfissional").val();
                acao = "cadastraprofissional";

                $.post("/siiupa/farmacia/registra/profissional/cadastraProfissional", {
                    nome: nomeProfissional,
                    cargo: cargoProfissional,
                    conselho: conselhoProfissional
                }, function(data) {

                    $("#dialogProfissional").html(data);
                });
            }
        </script>
    <?php
    } elseif ($acao == "editar") {
        $query = "SELECT id, profissional, funcao, n_conselho FROM u940659928_siupa.tb_farmprofissional";

        echo "<script>
                function editaProfissional(seleciona, e ){
                    e.preventDefault();
                    selecionado = $(seleciona);
                    
                    $.post('/siiupa/farmacia/profissional?acao=edita', {
                        
                        nome: selecionado.data('profissional'),
                        idProfissional: selecionado.data('idprofissional'),
                        cargo: selecionado.data('cargo'),
                        conselho: selecionado.data('conselho')
                        
                    }, function(data) {
    
                        $('#dialogProfissional').html(data);
                        $('#editaNomeProfissional').focus();
                    });
                }
        </script>";
        if ($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($idProfissional, $profissional, $cargo, $conselho);
            while ($stmt->fetch()) {
                echo "<a href='#' class='btn btn-outline-info' data-profissional='$profissional' data-cargo='$cargo' data-conselho='$conselho' data-idProfissional='$idProfissional' onclick='editaProfissional(this, event)' >$profissional - $cargo</a><br>";
            }
            $stmt->close();
        }
    } elseif ($acao == "edita") {
        echo "<input type='hidden' value='".$_POST['idProfissional']."' id='idProfissional'></input>";
        echo "Nome: <input type='text' value='" . $_POST['nome'] . "' id='editaNomeProfissional' class='form-control'><br>";

        echo "Cargo: <select id='editaCargoProfissional'  class='form-control'>";
        echo "<option value='" . $_POST['cargo'] . "'>" . $_POST['cargo'] . "</option>";
        $query = "SELECT descricao FROM u940659928_siupa.tb_cargo ORDER BY DESCRICAO ASC";


        if ($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($descricao);
            while ($stmt->fetch()) {
                echo "<option value='$descricao'>$descricao</option>";
            }
            $stmt->close();
        }
        echo "</select>";
        echo "<br>Conselho:<input type='text' value='" . $_POST['conselho'] . "' id='editaConselhoProfissional'  class='form-control'>";
    ?>
    <a href="#" onclick='atualizaProfissional(this, event)' id="avanca" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px">Salvar</a>

    <script>
                function atualizaProfissional(seleciona, e ){
                    e.preventDefault();
                    idProfissional = $("#idProfissional").val();
                    nomeAtualizar = $("#editaNomeProfissional").val();
                    cargoAtualizar = $("#editaCargoProfissional").val();
                    conselhoAtualizar = $("#editaConselhoProfissional").val();
                    $.post('/siiupa/farmacia/registra/profissional/atualizaProfissional', {
                        id: idProfissional,
                        nome: nomeAtualizar,
                        cargo: cargoAtualizar,
                        conselho: conselhoAtualizar
                        
                    }, function(data) {
    
                        $('#dialogProfissional').html(data);
                        $('#editaNomeProfissional').focus();
                    });
                }
        </script>
<?php
    }
}

?>