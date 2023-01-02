<?php
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == "cria") {
        //acao=cria&idfuncionario="+idescolhido+"&nome="+nomeescolhido+"&cargo="+cargoescolhido
        $idfuncionario = $_GET['idfuncionario'];
        $nome = $_GET['nome'];
        $cargo = $_GET['cargo'];
        $texto_botao = "Cadastrar";
        $idatestado = "";
        $data_inicio = "";
        $data_fim = "";
        $afastamento = "Selecione";
        $afastamento_id = "";
        $afastamento_obs = "";
    } elseif ($acao == "edita") {
        $idfuncionario = $_GET['idfuncionario'];
        $idatestado = $_GET['idatestado'];
        $afastamento = $_GET['afastamento'];
        $afastamento_id = $_GET['afastamento_id'];
        $nome = $_GET['nome'];
        $cargo = $_GET['cargo'];
        $data_inicio = $_GET['datainicio'];
        $data_fim = $_GET['datafim'];
        $afastamento_obs = $_GET['afastamento_obs'];
        $texto_botao = "Salvar";
    }
}
?>
<div id="janelaAtestados">
    <form class="form-control" id="dadosAtestado">
        <input id="input_acao" type="hidden" class="form-control" value="<?php echo $acao; ?>">
        <input id="input_idfuncionario" type="hidden" class="form-control" value="<?php echo $idfuncionario; ?>">
        <input id="input_idatestado" type="hidden" class="form-control" value="<?php echo $idatestado; ?>">
        <label>Nome: <input id="input_nome" type="text" class="form-control" value="<?php echo $nome; ?>" readonly></label></br>
        <label>Cargo: <input id="input_cargo" type="text" class="form-control" value="<?php echo $cargo; ?>" readonly></label></br>
        <label>Tipo de Afastamento:<br>
            <select id="afastamentos" name="afastamentos" class="form-control">
                <option value="<?php echo $afastamento_id; ?>"><?php echo utf8_encode($afastamento); ?></option>
            </select>
        </label>
        <label>Data início:<input id="input_data_inicio" type="date" class="form-control" value="<?php echo $data_inicio; ?>"></label>
        <label>Data fim:<input id="input_data_fim" type="date" class="form-control" value="<?php echo $data_fim; ?>"></label></br>
        <div class="container" id="btSomaData">
            <div class="row">
                <div class="col-sm">
                  Dias:  <small><input type="number"class="form-control somaData" id="calculaDias" value="">
           
           <!--         <button class="form-control btSomaDias">Calcular</button></small>  desabilitado-->
                </div>
          
            </div>
        </div>





        

        <label for="input_afastamento_obs">Observação:</label><textarea id="input_afastamento_obs" type="text" class="form-control"><?php echo $afastamento_obs;?></textarea></br>

        <button type="submit" class="form-control" id="btAtestadoSubmit"><?php echo $texto_botao; ?></button>
    </form>

</div>




<script>
    $(function() {
        //$("#btSomaData button").click(function(e) {
            $("#calculaDias").bind('input', function() {
                
//            e.preventDefault();
            soma = $(".somaData")[0].value

            dataInicio = $("#input_data_inicio")[0].value
            //converte de aaaa-mm-dd para aaaa/mm/dd            
            dataInicio = dataInicio.split("-")[0]+"/"+dataInicio.split("-")[1]+"/"+dataInicio.split("-")[2]

            console.log(dataInicio)
            var data1 = new Date(dataInicio)
            console.log(data1)

            var umdia = 1000 * 60 * 60 * 24
            data1.setDate(data1.getDate() + parseInt(soma) - parseInt(1))

            dia = ("00" + data1.getDate()).slice(-2)
            mes = parseInt(data1.getMonth()) + parseInt(1)
            mes = ("00" + mes).slice(-2)
            ano = data1.getFullYear()

            
            dataFim = $("#input_data_fim")[0]
            console.log(ano+"/"+mes+"/"+dia)
            dataFim.value = ano+"-"+mes+"-"+dia
        });
        $("#btAtestadoSubmit").click(function(e) {
            e.preventDefault();
            acao = $("#input_acao").val();
            idfuncionario = $("#input_idfuncionario").val();
            idatestado = $("#input_idatestado").val();
            nome = $("#input_nome").val();
            cargo = $("#input_cargo").val();
            afastamentos = $("#afastamentos").val();
            data_inicio = $("#input_data_inicio").val();
            data_fim = $("#input_data_fim").val();
            afastamento_obs = $("#input_afastamento_obs").val();
            linkformulario = "administracao/atestados/atestados_executa.php?acao=" + acao + "&idatestado=" + idatestado + "&idfuncionario=" + idfuncionario + "&afastamentos=" + afastamentos + "&datainicio=" + data_inicio + "&datafim=" + data_fim + "&afastamento_obs="+afastamento_obs;
            $.get(linkformulario, function(data) {
                $("#dialogCadastraAtestadoConteudo").html(data);
                $("#subsubconteudo").load("administracao/pagina_rh_atestados.php");
                setTimeout(function() {
                    $("#dialogCadastraAtestado").dialog("close");
                }, 2000);

            });
        });
        afastamentos = "administracao/atestados/atestados_executa.php?acao=consulta_afastamentos";
        $.get(afastamentos, function(data) {
            $("#afastamentos").append(data);
        });

    });
</script>
<style>
    #btSomaData {
        margin-top: 5px;
    }
</style>