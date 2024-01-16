<?php
$tableSorter = "<img src='/siiupa/imagens/tablesorter.svg'>";

$sqlRanking = "SELECT i.id, count(tipo) as contTipo, sum(m.quantidade) as qtd, i.nome FROM u940659928_siupa.tb_farmmovimento as m inner join u940659928_siupa.tb_farmitem as i on (m.item_fk = i.id) where tipo='saida' and (datahora between '2022-10-01 00:00:00' and '2022-11-25 23:59:59') group by i.nome order by contTipo DESC;";
//echo $sqlRanking;
$conRanking = new BD;
$resultRanking = $conRanking->consulta($sqlRanking);
echo "Clique no titulo da tabela para alterar a ordenação dos dados.";
echo "<table class='table table-sm table-hovered table-bordered tablesorter' id='tabelaRanking'><thead><th>SAIDAS $tableSorter</th><th>QTD $tableSorter</th><th>ITEM $tableSorter</th></thead><tbody>";

foreach($resultRanking as $rR){
    $nome = utf8_encode($rR->nome);
    $itemLinkTexto = sanitize_title($nome);
    echo "<tr>";
    echo "<td>$rR->contTipo</td>";
    echo "<td>$rR->qtd</td>";
    echo "<td><a href='/siiupa/farmacia/item-detalhe/$rR->id-$itemLinkTexto'>$nome</a></td>";
    echo "</tr>";
    
}
echo "</tbody></table>";


?>

