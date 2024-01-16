<?php
header("Content-type: text/html; charset=utf-8");

include_once('../../bd/conectabd.php');

if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == "cria") {
        //acao="+cria+"&idfuncionario="+idfuncionario+"&datainicio="+data_inicio+"&datafim="+data_fim;
        //acao=cria&idfuncionario=&acionamentos=&afastamento=&data_acionamento=&qtd_horas=&acionamento_obs=
        
        $fk_funcionario = $_GET['idfuncionario'];
        $fk_acionamentos = $_GET['acionamentos'];
        $fk_afastamento = $_GET['afastamento'];
        if($fk_afastamento == "nenhum"){
            $fk_afastamento = 0;
        }
        $data_acionamento = $_GET['data_acionamento'];
        $qtd_horas = $_GET['qtd_horas'];
        $turno = $_GET['turno'];
        $valor = $_GET['valor'];
        $acionamento_obs = $_GET['acionamento_obs'];
        $acionamento_obs = utf8_decode($acionamento_obs);
        
        $add = new BD;
        $sql = "INSERT INTO u940659928_siupa.tb_acionamento (`fk_funcionario`, `fk_acionamentos`, `fk_afastamento`, `data_acionamento`, `qtd_horas`, `turno`, `valor`, `acionamento_obs`) VALUES ('$fk_funcionario', '$fk_acionamentos', '$fk_afastamento', '$data_acionamento', '$qtd_horas', '$turno', '$valor', '$acionamento_obs')";
        //INSERT INTO `db_rh`.`tb_acionamento` (`fk_funcionario`, `fk_acionamentos`, `data_acionamento`, `qtd_horas`, `turno`, `acionamento_obs`) VALUES ('14', '1', '2022-07-26', '16H', 'DIURNO', 'TESTE');

        $busca = $add->conecta();
        $insere = $busca->prepare($sql);
        $insere->execute();
        
        echo "<div style='background-color:#12C06A;text-align:center;color:#fff;'>ACIONAMENTO CADASTRADO COM SUCESSO!<img src='imagens/icones/sucesso.gif' width='100%'> </div>";
        echo "<script>setTimeout(function(){location.reload(true);},2000)</script>";
    } elseif($acao== "edita"){
        //$fk_funcionario = $_GET['idfuncionario'];
        $idacionamento = $_GET['idacionamento'];
        $fk_funcionario = $_GET['idfuncionario'];
        $fk_acionamentos = $_GET['acionamentos'];
        $fk_afastamento = $_GET['afastamento'];
        if($fk_afastamento == "nenhum"){
            $fk_afastamento = 0;
        }
        $data_acionamento = $_GET['data_acionamento'];
        $qtd_horas = $_GET['qtd_horas'];
        $turno = $_GET['turno'];
        $valor = $_GET['valor'];
        $acionamento_obs = $_GET['acionamento_obs'];
        $acionamento_obs = utf8_decode($acionamento_obs);
        
        $att = new BD;
        $sql = "UPDATE u940659928_siupa.tb_acionamento SET fk_acionamentos='$fk_acionamentos', fk_afastamento='$fk_afastamento', data_acionamento='$data_acionamento', qtd_horas='$qtd_horas', turno='$turno', valor='$valor', acionamento_obs='$acionamento_obs'  WHERE tb_acionamento.id='$idacionamento'";
        
        $busca = $att->conecta();
        $insere = $busca->prepare($sql);
        $insere->execute();
        
      
        
        echo "<div style='background-color:#12C06A;text-align:center;color:#fff;'>ACIONAMENTO ATUALIZADO COM SUCESSO!<img src='imagens/icones/sucesso.gif' width='100%'> </div>";
        echo "<script>setTimeout(function(){";
        echo "redireciona_box = '?setor=adm&sub=rh&subsub=acionamentos#box_$idacionamento';";
        echo "window.location.href= redireciona_box;";
        echo "location.reload(true);";
        
        echo "},2000)";
        
    } elseif($acao== "deleta"){
        $idacionamento = $_GET['idacionamento'];

        $sqlDeletaAcionamento = "DELETE FROM u940659928_siupa.tb_acionamento WHERE (id = '$idacionamento');";
        $deletaAcionamento = new BD;
        $rDeleta = $deletaAcionamento->consulta($sqlDeletaAcionamento);
        echo '<div class="alert alert-primary" role="alert">
        Deletado!
      </div>
      ';


    }
    
    elseif($acao== "consulta_afastamentos"){
        $query = "SELECT * FROM u940659928_siupa.tb_afastamentos";


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
