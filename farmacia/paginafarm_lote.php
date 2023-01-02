<style>
    td {
        border: 1px solid #000;
    }
</style>
<?php
$consultaLotes = new BD;
$sqlLotes = "SELECT e.id, i.nome, e.lote, count(e.lote) as qtd FROM db_farmacia.tb_farmestoque as e inner join db_farmacia.tb_farmitem as i on (e.item_fk = i.id) group by lote;";
$rLotes = $consultaLotes->consulta($sqlLotes);

echo "<table>";
echo "<thead>";

echo "<th>Lote</th>";
echo "<th>Repetições de Lote</th>";
echo "</thead>";
echo "<tbody>";
foreach ($rLotes as $lote) {

    if(intval($lote->qtd)>1){
        echo "<tr>";

        echo "<td>$lote->lote</td>";
        echo "<td>$lote->qtd</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2'>";
        $consultaItens = new BD;
        $sqlCItens = "SELECT e.item_fk, i.nome, e.lote FROM db_farmacia.tb_farmestoque as e inner join db_farmacia.tb_farmitem as i on (e.item_fk = i.id) where lote='$lote->lote'";
        $rCItens = $consultaItens->consulta($sqlCItens);
        foreach ($rCItens as $itens){
            $nome = utf8_encode($itens->nome);
            echo "<a href='/siiupa/farmacia/item-detalhe/$itens->item_fk-lote'>$nome</a> <br>";
        }
        unset($consultaItens);

        echo "</td>";
        echo "</tr>";
    }
    
}
echo "</tbody>";
echo "</table>";
