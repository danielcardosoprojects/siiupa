<style>
    h2 {
        color: #000;
    }
    table {
        font-size: 14px;
        font-family: calibri;
        color: #000;
    }

    td {
        border: 1px solid #000;
        color: #000;
    }

    .ass {
        width: 300px;
    }

    .total {
        text-align: right;
    }

    @media print {
        .table {
            -webkit-column-count: 2;
            /* Chrome, Safari, Opera */
            -moz-column-count: 2;
            /* Firefox */
            column-count: 2;
        }

    }

    @media print {
        .pagebreak {
            page-break-before: always;
        }

        /* page-break-after works, as well */
    }

    thead {
        display: table-row-group;
    }
</style>


<?php
header('Content-type: text/html; charset=utf-8');
include_once('../bd/conectabd.php');
$diax = $_GET['dia']+1;
$mes = $_GET['mes'];
$ano = $_GET['ano'];


$titulo = 'não definido';
if (isset($_GET['dia'])) {
    $dia = $_GET['dia'];
    $tdia = $dia; //dia para a data
    $dia = 'd' . $dia;
}
if (isset($_GET['mes'])) {
    $mes = $_GET['mes'];
}

if (isset($_GET['ano'])) {
    $ano = $_GET['ano'];
}
?>
<script>
document.title = "<?php echo "Lista almoço dia $dia - $mes $ano";?>";


    </script>
<?php
echo "<div><h2>LISTA ALMOÇO $tdia/$mes/$ano - <a href='?dia=$diax&mes=$mes&ano=$ano'>.</a></h2></div>";
$query = "SELECT s.setor, f.nome, ef.id FROM u940659928_siupa.tb_escala_funcionario AS ef INNER JOIN u940659928_siupa.tb_funcionario AS f ON (ef.fk_funcionario = f.id) INNER JOIN u940659928_siupa.tb_setor as s ON (f.fk_setor = s.id) Where ef.oficial = 'sim' and ef.mes=$mes and ef.ano=$ano and (ef.$dia like '%D%' OR ef.$dia like '%P%'  OR ef.$dia like '%M%') and f.id NOT IN ('14', '17', '260', '201', '107', '309', '123', '216','387')/*exclui adm e direcao*/ ORDER BY s.setor ASC, f.nome ASC";
//echo $query;


if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($setor, $nome, $id);
    $setorgrupo = "";
    global $i;
    global $totalgeral;
    echo "<table class='table border-primary'>";
    while ($stmt->fetch()) {
        if ($setorgrupo == $setor) {

            $i = $i + 1;
            $totalgeral = $totalgeral + 1;
            echo "<tr>";
            echo "<td>$nome</td>";
            echo "<td class='ass'></td>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td COLSPAN='2' class='total'>$i</td>";

            echo "</tr>";


            $i = 1;
            $totalgeral = $totalgeral + 1;
            echo "<thead>";
            echo "<th >$setor</th>";
            echo "<th></th>";
            echo "</thead>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td>$nome</td>";
            echo "<td class='ass'></td>";
            echo "</tr>";
            $setorgrupo = $setor;
        }
    }
    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>$i</td>";
    echo "</tr>";

    //guarda padrão
    echo "<thead>";
    echo "<th>GMC</th>";
    echo "<th></th>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>GD I</td>";
    echo "<td class='ass'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>GD II</td>";
    echo "<td class='ass'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>2</td>";
    echo "</tr>";
    $totalgeral = $totalgeral + 2 + 2;
    //fim guarda

     //BIOMEDIOCOS PADRÕES
     echo "<thead>";
     echo "<th>OUTROS    </th>";
     echo "<th></th>";
     echo "</thead>";
     echo "<tbody>";
     echo "<tr>";
     echo "<td>BIOMÉDICO(A)</td>";
     echo "<td class='ass'></td>";
     echo "</tr>";

     echo "<tr>";
     echo "<td>MOTORISTA</td>";
     echo "<td class='ass'></td>";
     echo "</tr>";

     echo "<tr>";
     echo "<td COLSPAN='2' class='total'>2</td>";
     echo "</tr>";
     echo "</tbody>";
       echo "<br/>";
     //fimbiomedico
     echo "<thead>";
     echo "<th>Total    </th>";
     echo "<th></th>";
     echo "</thead>";


     echo "<tbody>";
    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>Total geral: $totalgeral</td>";
    $totalAlmoco = $totalgeral;

    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    $stmt->close();
}
echo '<div class="pagebreak"> </div>';

/////////////////////////// JANTA /////////////////////////////////////////
$totalgeral = 0;
$i = "";
echo "<div><h2>LISTA JANTA $tdia/$mes/$ano</h2></div>";
$query = "SELECT s.setor, f.nome, ef.id FROM u940659928_siupa.tb_escala_funcionario AS ef INNER JOIN u940659928_siupa.tb_funcionario AS f ON (ef.fk_funcionario = f.id) INNER JOIN u940659928_siupa.tb_setor as s ON (f.fk_setor = s.id) Where ef.oficial = 'sim' and ef.mes=$mes and ef.ano=$ano and (ef.$dia like '%N%' OR ef.$dia like '%P%') ORDER BY s.setor ASC, f.nome ASC";


if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($setor, $nome, $id);
    $setorgrupo = "";
    global $i;
    global $totalgeral;
    echo "<table class='table'>";
    while ($stmt->fetch()) {
        if ($setorgrupo == $setor) {

            $i = $i + 1;
            $totalgeral = $totalgeral + 1;
            echo "<tr>";
            echo "<td>$nome</td>";
            echo "<td class='ass'></td>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td COLSPAN='2' class='total'>$i</td>";

            echo "</tr>";


            $i = 1;
            $totalgeral = $totalgeral + 1;
    
            echo "<thead>";
      
            echo "<th >$setor</th>";
            echo "<th></th>";
            echo "</thead>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td>$nome</td>";
            echo "<td class='ass'></td>";
            echo "</tr>";
            $setorgrupo = $setor;
        }
    }
    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>$i</td>";
    echo "</tr>";

    //guarda padrão
    echo "<thead>";
    echo "<th>GMC</th>";
    echo "<th></th>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>GD I</td>";
    echo "<td class='ass'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>GD II</td>";
    echo "<td class='ass'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>2</td>";
    echo "</tr>";

    //BIOMEDIOCOS PADRÕES
    echo "<thead>";
    echo "<th>Outros(A)    </th>";
    echo "<th></th>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>Biomédico(A)(PRO-ANALISYS)</td>";
    echo "<td class='ass'></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Motorista(HMC)</td>";
    echo "<td class='ass'></td>";
    echo "</tr>";
   
    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>2</td>";
    echo "</tr>";
    $totalgeral = $totalgeral + 2 + 2;
    //fim guarda
    echo "<thead>";
    echo "<th>Total    </th>";
    echo "<th></th>";
    echo "</thead>";

    echo "<tr>";
    echo "<td COLSPAN='2' class='total'>Total geral: $totalgeral</td>";
    $totalJanta = $totalgeral;

    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    $stmt->close();
}

?>
<input type="hidden" name="texto" id="texto" value="<?=$dia;?>/<?=$mes;?>/<?=$ano;?> Almoço: <?=$totalAlmoco;?> Janta: <?=$totalJanta;?>">
<script>
    // window.onload = function() {
    
    var query = location.search.slice(1);
    var partes = query.split('&');
    var data = {};
    partes.forEach(function(parte) {
        var chaveValor = parte.split('=');
        var chave = chaveValor[0];
        var valor = chaveValor[1];
        data[chave] = valor;
        proximodia = parseInt(data.dia) + parseInt(1);
        link = "pagina_almoco.php?dia=" + proximodia + "&mes=" + data.mes + "&ano=" + data.ano;
    });
    console.log(link);
        totalAlmoco = '<?=$totalAlmoco;?>';
        totalJanta = '<?=$totalJanta;?>';
        hoje = `${data.dia}/${data.mes}/${data.ano} Almoço: ${totalAlmoco} Janta: ${totalJanta}`;
        
        //window.prompt('Basta copiar', hoje);
        window.print();
            setTimeout(() => {window.location.href = link;}, 2000);
        
</script>

