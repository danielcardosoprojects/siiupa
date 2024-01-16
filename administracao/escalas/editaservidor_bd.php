<?php
include_once('../../bd/conectabd.php');
$acao = $_GET['acao'];

//acao linha branca
if ($acao == 'linhabranca') {
    $busca = new BD;

    $idef = $_GET['idef'];
    $valor = $_GET['valor'];
    $sql = "UPDATE u940659928_siupa.tb_escala_funcionario SET posbranco='$valor' WHERE id=$idef";


    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();

    echo "Linha Branca alterada com sucesso!";
}
if ($acao == 'posicao') {
    $busca = new BD;

    $idef = $_GET['idef'];
    $valor = $_GET['valor'];
    $sql = "UPDATE u940659928_siupa.tb_escala_funcionario SET posicao='$valor' WHERE id=$idef";


    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();

    echo "Posição alterada com sucesso!";
}

//acao DELETA
if($acao =='deleta'){
    $busca = new BD;

    $idef = $_GET['idef'];
;
    $sql = "DELETE FROM u940659928_siupa.tb_escala_funcionario WHERE id=$idef";


    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();

    echo "Deletado!";

}

if($acao == 'ferias'){
    $busca = new BD;
    $idef = $_GET['idef'];
    $diainicio = $_GET['inicio'];
    $diafim = $_GET['fim'];
    $sql = "UPDATE u940659928_siupa.tb_escala_funcionario SET ferias_inicio='$diainicio', ferias_fim='$diafim' WHERE id=$idef";


    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();

    echo "Férias atualizada";

}

if($acao == 'licenca'){
    $busca = new BD;
    $idef = $_GET['idef'];
    $diainicio = $_GET['inicio'];
    $diafim = $_GET['fim'];
    $texto_licenca = $_GET['textolicenca'];
    $sql = "UPDATE u940659928_siupa.tb_escala_funcionario SET licenca_inicio='$diainicio', licenca_fim='$diafim', licenca_texto='$texto_licenca' WHERE id=$idef";


    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();

    echo "Licença atualizada";

}


?>