<?php
include_once('../../bd/conectabd.php');

if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == "cria") {
        //acao="+cria+"&idfuncionario="+idfuncionario+"&datainicio="+data_inicio+"&datafim="+data_fim;

        
        $fk_funcionario = $_GET['idfuncionario'];
        $fk_afastamentos = $_GET['afastamentos'];
        $data_inicio = $_GET['datainicio'];
        $data_fim = $_GET['datafim'];
        $afastamento_obs = utf8_encode($_GET['afastamento_obs']);
        $add = new BD;
        $sql = "INSERT INTO db_rh.tb_afastamento (fk_funcionario, fk_afastamentos, data_inicio, data_fim, afastamento_obs) VALUES ('$fk_funcionario', '$fk_afastamentos','$data_inicio', '$data_fim', '$afastamento_obs')";


        $busca = $add->conecta();
        $insere = $busca->prepare($sql);
        $insere->execute();
        
        echo "<div style='background-color:#12C06A;text-align:center;color:#fff;'>CADASTRADO COM SUCESSO!<img src='imagens/icones/sucesso.gif' width='100%'> </div>";
        echo "<script>setTimeout(function(){Location.reload()},4000)</script>";
    } elseif($acao== "edita"){
        //$fk_funcionario = $_GET['idfuncionario'];
        $id_atestado = $_GET['idatestado'];
        $fk_afastamentos = $_GET['afastamentos'];
        //$fk_afastamento_id = $_GET['afastamento_id'];
        $data_inicio = $_GET['datainicio'];
        $data_fim = $_GET['datafim'];
        $afastamento_obs = utf8_encode($_GET['afastamento_obs']);

        $add = new BD;
        $sql = "UPDATE db_rh.tb_afastamento SET data_inicio='$data_inicio', data_fim='$data_fim', fk_afastamentos = '$fk_afastamentos', afastamento_obs = '$afastamento_obs' WHERE id=$id_atestado";
        //$sql = "INSERT INTO db_rh.tb_afastamento (fk_funcionario, data_inicio, data_fim) VALUES ('$fk_funcionario', '$data_inicio', '$data_fim')";


        $busca = $add->conecta();
        $insere = $busca->prepare($sql);
        $insere->execute();
        
        echo "<div style='background-color:#12C06A;text-align:center;color:#fff;'><h2>ATUALIZADO COM SUCESO!</h2><img src='imagens/icones/sucesso.gif' width='90%'> </div>";
    }elseif($acao== "consulta_afastamentos"){
        $query = "SELECT * FROM db_rh.tb_afastamentos";


if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $afastamento,$afastamento_obs);
    while ($stmt->fetch()) {
        echo "<option value='$id'>$afastamento</option>";
    }
    $stmt->close();
}
    }
    
}
