<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@include_once("../../bd/conectabd.php");
$acao = $_GET['acao'];
if ($acao == 'busca') {

    $nome = $_GET['nome'];
    $busca_setor = $_GET['setor'];
    if ($busca_setor == "") {
        $sqlsetor = "";
    } else {
        $sqlsetor = "AND fk_setor = $busca_setor";
    }
    $chave = uniqid();

    $buscanome = $nome; //preg_replace('/[^[:alnum:]_]/', '',$nome);
    $bdaddservidor = new BD;
    $sqladdservidor = "SELECT c.titulo, f.* FROM u940659928_siupa.tb_funcionario as f INNER JOIN u940659928_siupa.tb_cargo AS c ON (f.fk_cargo = c.id) WHERE f.nome like '%$buscanome%' AND (f.status = 'ATIVO' OR f.status = 'TERCEIRIZADO') $sqlsetor ORDER BY f.nome ASC";
    $resultadoaddservidor = $bdaddservidor->consulta($sqladdservidor);
    echo "<input type='hidden' value='$chave' id='chaveAddServ'>";
    echo "<table class='table table-bordered table-striped table-hover' style='font-size:29px !important'><theady><th>Nome</th><th>Cargo</th></theady><tbody>";
    foreach ($resultadoaddservidor as $addservidor) {
        echo "<tr>";
        echo "<td><a class='escolhido' data-idescolhido='$addservidor->id' data-nome='$addservidor->nome' data-cargo='$addservidor->titulo' href='#'>" . utf8_encode($addservidor->nome) . "</a><td>" . utf8_encode($addservidor->titulo) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";

    echo `<script></script>`;
}
if ($acao == 'insere') {
    $id = $_GET['id'];
    $idservidor = $_GET['idservidor'];
    $mes = $_GET['mes'];
    $ano = $_GET['ano'];

    $busca = new BD;
    $sql = "INSERT INTO u940659928_siupa.tb_escala_funcionario (fk_escala, fk_funcionario, mes, ano) VALUES ('$id','$idservidor','$mes','$ano')";

    $busca = $busca->conecta();
    $insere = $busca->prepare($sql);
    $insere->execute();
    echo "Adicionado com sucesso!";
} elseif ($acao == 'inseretodos') {
    $id = $_GET['id'];
    $mes = $_GET['mes'];
    $ano = $_GET['ano'];
    $todos = utf8_encode($_POST['todos']);
    $chave = $_POST['chave'];
    $todos = json_decode($todos, true);

    //CONSULTA Chave PARA EVITAR DUPLICACAO
    $buscaChave = new BD;
    $sqlBChave = "SELECT chave FROM u940659928_siupa.tb_escalas where chave='$chave'";

    $buscaChave = $buscaChave->conecta();
    $consultaChave = $buscaChave->prepare($sqlBChave);
    $consultaChave->execute();

    if ($consultaChave->rowCount() == 0) {
    $virgula = "";
    $values = "";
    foreach ($todos as $idservidor) {
        $values .= $virgula;

        $values .= "('$id','$idservidor','$mes','$ano')";
        $virgula = ",";
    }
    $busca = new BD;
    $sql = "INSERT INTO u940659928_siupa.tb_escala_funcionario (fk_escala, fk_funcionario, mes, ano) VALUES $values";
    $rBusca = $busca->consulta($sql);

    $attChave = new BD;
    $sqlAttChave = "UPDATE u940659928_siupa.tb_escalas where id=$id SET chave=$chave";
    $rAttChave = $attChave->consulta($sqlAttChave);

    echo "Adicionados todos com sucesso!";
    echo "<script>window.location.reload();</script>";

} else {
    echo "Atualize a página.";
}

    //var_dump($todosArray);
}
