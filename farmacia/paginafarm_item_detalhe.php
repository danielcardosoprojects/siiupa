<style>
    .saida {
        background-color: #ffc2b1;
        border: 1px solid #400000;
    }

    .entrada {
        background-color: #c6ffc3;
        border: 1px solid #0D4000;

    }

    #ultimosMovimentos>thead {
        background-color: #aed6f1;
        border: 1px solid #000;
    }
</style>

<?php
require 'vendor/autoload.php';

// This will output the barcode as HTML output to display in the browser


$id_item = $_GET['id'];



//consulta o Item
$consultaItem = new BD;
$sqlItem = "SELECT * FROM db_farmacia.tb_farmitem where id='$id_item'";
$resultItem = $consultaItem->consulta($sqlItem);

//carrega as categorias
$consultaCategorias = new BD;
$sqlCategorias = "SELECT * FROM db_farmacia.tb_farmcategoria";
$resultCategorias = $consultaCategorias->consulta($sqlCategorias);
$categorias = [];
foreach ($resultCategorias as $rCat) {
    $textCat = utf8_encode($rCat->categoria);
    $categorias[$rCat->id] = utf8_encode($rCat->categoria);
}

//carrega os generos


if (empty($resultItem)) {
    echo "<h4>Item não localizado.</h4>";
    die;
}



$item = $resultItem[0];

function exibeCategoriasBt($categoria, $categorias)
{
    if ($categoria != "" && $categoria != '0') {
        return "<a class='btn btn-info btn-sm' href='/siiupa/farmacia/estoque/filtra/classe-$categoria'>" . $categorias[$categoria] . "</a> ";
    }
    return "";
}



$item->nome = utf8_encode($item->nome);


    $btUnir = "<button id='unirItem' class='btn btn-sm btn-info' data-esse='$item->id'>Unir a este</button>";

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($item->id, $generator::TYPE_CODE_128)) . '">';

echo "<h2>$item->nome<a href='/siiupa/farmacia/item/edita/$item->id' onclick='itemCarrega(this, event)' id='item_$item->id'><img class='lapis' src='/siiupa/imagens/icones/edita.png'></a></h2>";
echo "Categoria(s): ";
echo exibeCategoriasBt($item->categoria_fk, $categorias);
echo exibeCategoriasBt($item->categoria2_fk, $categorias);
echo exibeCategoriasBt($item->categoria3_fk, $categorias);
echo exibeCategoriasBt($item->categoria4_fk, $categorias);
echo "<span class='btn btn-sm btn-secondary'>ID: $item->id | Código de Barras: $item->barcode</span> $btUnir";





$conLote = new BD;
$sqlConLote = "SELECT *, DATE_FORMAT(data_validade, '%d/%m/%Y') as dataValBr FROM db_farmacia.tb_farmestoque where item_fk = '$item->id' order by data_validade ASC";
$lotes = $conLote->consulta($sqlConLote);

echo "<table class='table table-sm'><thead><th>Produto</th><th>Lote</th><th>Validade</th><th>QTD</th><th>Barcode</th><tbody>";
$total = '';
foreach ($lotes as $lote) {
    $nomeLote = utf8_encode($lote->lote);
    echo "<tr>";
    echo "<td>$lote->nome_produto</td>";
    echo "<td id='lote_$lote->id'>$lote->id →Lote: <span>$nomeLote</span><a href='#' class='editaLote' data-idlote='$lote->id'><img class='lapis' src='/siiupa/imagens/icones/edita.png' alt='Editar'></a></td>";
    echo "<td id='val_$lote->id' data-val='$lote->data_validade'>Val: <span>$lote->dataValBr</span><a href='#' class='editaValidade' data-idlote='$lote->id'><img class='lapis' src='/siiupa/imagens/icones/edita.png' alt='Editar'></a></td><td>Qtd: $lote->estoque</td>";
    echo "<td>$lote->barcode</td>";
    echo "</tr>";
    $total += $lote->estoque;
    //print_r($lote);

}

echo "<tr><td colspan='2'></td><td>Total: $total</td></tr>";
echo "</tbody></table>";


echo "<br>Saídas por setor:";
echo '<div class="ct-chart" id="chart2"></div>';
echo "<hr>";


if (isset($_GET['quantidade'])) {

    $total_reg = $_GET['quantidade'];
    if ($total_reg <= 0) {
        $total_reg = "15";
    }
} else {
    $total_reg = "1500";
} // limita limite número de registros por página

$pagina = isset($_GET['pagina']);

if (!$pagina) {
    $pc = "1";
} else {

    $pc = $_GET['pagina'];
}
$queryString = filter_input(INPUT_SERVER, 'QUERY_STRING');


$inicio = $pc - 1;
$inicio = $inicio * $total_reg;
$query = "SELECT m.id as idmovimento, DATE_FORMAT(m.datahora,'%d\/%m\/%Y %H:%i'), m.tipo, m.quantidade, m.setor_origem_fk as Origem, m.setor_dest_fk as Destino, m.usuario as usuario_id, i.nome, s.setor as Setor1, s2.setor as Setor2, u.usuario as usuarioNome FROM db_farmacia.tb_farmmovimento AS m INNER JOIN db_farmacia.tb_farmitem AS i ON (m.item_fk = i.id) INNER JOIN db_farmacia.tb_farmsetor AS s ON (m.setor_origem_fk = s.id) INNER JOIN db_farmacia.tb_farmsetor AS s2 ON (m.setor_dest_fk = s2.id) INNER JOIN login.usuarios AS u on (m.usuario = u.id) where m.item_fk = '$id_item' ORDER BY m.id DESC";
//echo $query;


$todosResultadosBusca = mysqli_query($conn, $query);
$tr = $todosResultadosBusca->num_rows; // verifica o número total de registros
$tp = $tr / $total_reg; // verifica o número total de páginas

$tableSorter = "<img src='/siiupa/imagens/tablesorter.svg'>";
echo "
          
          <h4>Movimentos</h4>
      <table class='table table-hover table-bordered tablesorter table-sm' id='ultimosMovimentos'>
        <thead>
          <tr>
          <th scope='col'>ID</th>
            <th scope='col'>DATA $tableSorter</th>
            <th scope='col'>MOVIMENTO</th>
            <th scope='col'>QTD</th>
            <th scope='col'>ITEM</th>
            <th scope='col'>ORIGEM</th>
            <th scope='col'>DESTINO</th>
            <th scope='col'>USUÁRIO</th>
          </tr>
        </thead>
        <tbody>";

if ($stmt = $conn->prepare("$query LIMIT $inicio,$total_reg")) {
    $stmt->execute();
    $stmt->bind_result($idmovimento, $datahora, $tipo, $quantidade, $Origem, $Destino, $usuario, $nome, $Setor1, $Setor2, $usuarioNome);
    while ($stmt->fetch()) {
        if ($tipo == 'saida') {

            $tipoBS = 'table-danger';
            $tipoBolha = "<img src='/siiupa/imagens/icones/saida.fw.png'>";
            $setoresSaida[$Setor2] += $quantidade;
        } else {
            $tipoBS = 'table-success';
            $tipoBolha = "<img src='/siiupa/imagens/icones/entrada.fw.png'>";
        }

        // printf("%s, %s, %s, %s, %s\n", $datahora, $tipo, $novoestoque, $nome, $Origem);
        echo "
                <tr class='$tipoBS'>
                <td>$idmovimento</td>
                <th scope='row'>$datahora</th>
                <td>$tipoBolha $tipo</td>
                <td>$quantidade</td>
                <td>$nome</td>
                <td>$Setor1</td>
                <td>$Setor2</td>
                <td>$usuarioNome</td>
              </tr>
                ";
    }




    echo "<script>";
    echo "var labels = [];";
    echo "var catVals = [];";
    foreach ($setoresSaida as $key => $ss) {
        echo "labels.push('$key: $ss');";
        echo "catVals.push('$ss');";
    }
    echo "</script>";

    $stmt->close();
}
echo '</tbody>
      </table>';

$queryString = filter_input(INPUT_SERVER, 'QUERY_STRING');

$anterior = $pc - 1;
$proximo = $pc + 1;
//substitui a pagina na queryString

$queryString = str_replace("&pagina=$pc", "", $queryString);



if ($pc > 1) {
    echo " <a href='/siiupa/farmacia/pagina/$anterior/quantidade/$total_reg' class='btn btn-secondary btn-sm'><<</a> ";
}

if ($tp > 1) {


    //NUMERAÇÕES DA PÁGINA


    for ($i = 1; $i <= ceil($tp); $i++) {

        if ($pc == $i) {
            $botaoPaginas = "btn-info";
        } else {
            $botaoPaginas = "btn-secondary";
        }
        echo "<a href='/siiupa/farmacia/pagina/$i/quantidade/$total_reg' class='btn $botaoPaginas btn-sm'>$i</a> ";
    }
}

//PROXIMA

if ($pc < $tp) {
    echo " <a href='/siiupa/farmacia/pagina/$proximo/quantidade/$total_reg' class='btn btn-secondary btn-sm'>>></a>";
}

?>
<script type="text/javascript">
    $("#unirItem").click(() => {
        let esse = $("#unirItem").data('esse');
        let outro = prompt('Digite o outro item');
        $.get(`/siiupa/farmacia/paginafarm_inserebd.php?acao=uniritem&esse=${esse}&outro=${outro}`, function(data) {
            $.alert(data);
        });

    });
    new Chartist.Bar('#chart2', {
        labels,
        series: [catVals],
    }, {
        fullWidth: true,
        chartPadding: {
            right: 40
        },
        axisX: {
            // On the x-axis start means top and end means bottom
            position: 'bottom'
        },
        axisY: {
            // On the y-axis start means left and end means right
            position: 'start'
        }
    });
</script>
<script src="/siiupa/farmacia/app_itemdetalhe.js"></script>