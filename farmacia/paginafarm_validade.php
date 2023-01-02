<?php


$val = new BD;

$data = new DateTime();
$hoje = $data->format('Y-m-d');
$sqlVal = "SELECT date_format(e.data_validade, '%d/%m/%Y') as validade, e.lote, e.estoque, i.nome, i.id FROM db_farmacia.tb_farmestoque as e inner join db_farmacia.tb_farmitem as i on (e.item_fk = i.id) where e.estoque > 0 and data_validade <= '$hoje' order by validade ASC;";
//echo $sqlVal;


$rVal = $val->consulta($sqlVal);


echo "<h4>Itens com a data de validade menor ou igual a hoje.</h4>";

echo "<table class='table table-sm table-hovered table-bordered'>
<thead><th>Validade</th><th>Lote</th><th>Item</th></thead><tbody>";

foreach ($rVal as $item){
    $nome = utf8_encode($item->nome);
    $itemLink = sanitize_title($nome);
    echo "<tr>";
    echo "<td>$item->validade</td>";
    echo "<td>$item->lote</td>";
    echo "<td><a href='/siiupa/farmacia/item-detalhe/$item->id-$itemLink'>$nome</a></td>";
    
    echo "</tr>";
}

echo "</tbody></table>";


?>