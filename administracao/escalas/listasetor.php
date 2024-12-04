<?php
include_once('../../bd/conectabd.php');
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == 'criar') {
        $bdsetores = new BD;
        $sqlsetores  = "SELECT  * FROM u940659928_siupa.tb_setor GROUP BY setor ASC";
        $resultadosetores  = $bdsetores->consulta($sqlsetores);
        echo "<select class='setor form-control'>";
        foreach ($resultadosetores as $setores) {
            echo "<option value='$setores->id'>$setores->setor </option>";
        }
        echo "</select>";
?>
        <select class="mes form-control">
            <option value="01">Janeiro</option>
            <option value="02">Fevereiro</option>
            <option value="03">Março</option>
            <option value="04">Abril</option>
            <option value="05">Maio</option>
            <option value="06">Junho</option>
            <option value="07">Julho</option>
            <option value="08">Agosto</option>
            <option value="09">Setembro</option>
            <option value="10">Outubro</option>
            <option value="11">Novembro</option>
            <option value="12">Dezembro</option>
        </select>
        <input class="ano form-control" value="2025">
<?php
    } elseif ($acao == 'cria') {
        $idsetor = $_GET['setor'];
        $mes = $_GET['mes'];
        $ano = $_GET['ano'];

        $timezone = new DateTimeZone('America/Belem');
        $agora = new DateTime('now', $timezone);
        $criadoem = $agora->format('Y-m-d H:i:s');

        $att = new BD;


        $sql = "INSERT INTO u940659928_siupa.tb_escalas (fk_setor, mes, ano, oficial, created_at) VALUES ($idsetor, $mes, $ano, 'nao', '$criadoem')";


        $busca = $att->conecta();
        $insere = $busca->prepare($sql);
        $insere->execute();
        echo $sql;
    }
}



?>