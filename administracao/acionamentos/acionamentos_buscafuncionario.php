<style>
    *{
       font-size: medium !important;
    }
    .formularioacionamentos{
        display:flex;
        flex-direction: column;
        gap: 10px;
    }
    #dialogaddresultadobusca{
        margin-top: 5px;
    }

</style>
<div id="dialogadd" title="Adicionar Servidor">
    <form class="form-control formularioacionamentos">
        <label for="buscar">Nome:</label><input type="text" name="buscar" id="nomebuscar" class="form-control form-control-sm">
        <select name='busca_servidor_setor' id='busca_servidor_setor' class='form-control form-control-sm'>
            <option value="" selected> TODOS </option>

            <?php
            include_once('../../bd/conectabd.php');


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


            <button type="submit" class="btn btn-primary" id="btBuscaFuncionario">Buscar</button>
    </form>
    <div id="dialogaddresultadobusca">
        <caption>Busque pelo nome</caption>
    </div>
</div>
<script>
    //administracao/escalas/buscarservidor.php?acao=busca&nome=
    $(function() {
        $("#btBuscaFuncionario").click(function(e) {
            e.preventDefault();
            nomebuscar = $("#nomebuscar").val();
            busca_servidor_setor = $("#busca_servidor_setor").val();
            linkbusca = "administracao/escalas/buscarservidor.php?acao=busca&nome="+nomebuscar+"&setor="+busca_servidor_setor;
            $.get(linkbusca, function(data) {
                $("#dialogaddresultadobusca").html(data);
                $(".escolhido").click(function() {
                idescolhido = $(this).data("idescolhido");
                nomeescolhido = $(this).data("nome");
                cargoescolhido = $(this).data("cargo");
                linkformulario = "administracao/acionamentos/acionamentos_formularios.php?acao=cria&idfuncionario="+idescolhido+"&nome="+nomeescolhido+"&cargo="+cargoescolhido;
                //alert(linkformulario);
                $.get(linkformulario, function(data){
                   $("#dialog").html(data);
               });
          //      
            });
            });
            
        });
    });
</script>