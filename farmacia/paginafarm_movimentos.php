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

  .linksMovimento {
    color: #000;
    text-decoration: none;
  }

  .opcoesFiltra {
    display: flex;
    gap: 16px;
    padding: 5px;

  }

  .opcoesCheck {
    padding: 5px;
    border: solid 1px #ccc;
    display: flex;
    flex-direction: column;

  }

  #boxFiltro {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }
</style>


<?php

/*ULTIMOS MOVIMENTOS */
if (isset($_GET['quantidade'])) {

  $total_reg = $_GET['quantidade'];
  if ($total_reg <= 0) {
    $total_reg = "15";
  }
} else {
  $total_reg = "15000";
} // limita limite número de registros por página

$pagina = isset($_GET['pagina']);

if (!$pagina) {
  $pc = "1";
} else {

  $pc = $_GET['pagina'];
}
$queryString = filter_input(INPUT_SERVER, 'QUERY_STRING');
// echo $pc;
//echo $queryString;


$inicio = $pc - 1;
$inicio = $inicio * $total_reg;
if (isset($_GET['datainicio'])) {
  $datainicio = $_GET['datainicio'];
} else {
  $datainicio = date('Y-m-d');
}

if (isset($_GET['datafim'])) {
  $datafim = $_GET['datafim'];
} else {
  $datafim = date('Y-m-d');
}

if (isset($_GET['tipo'])) {
  $tipo = $_GET['tipo'];

  if ($tipo == 't') {
    $chkEntrada = 'checked';
    $chkSaida = 'checked';
    $andTipo = '';
  } elseif ($tipo == 'e') {
    $chkEntrada = 'checked';
    $chkSaida = '';
    $andTipo = "and m.tipo = 'entrada'";
  } elseif ($tipo == 's') {
    $chkEntrada = '';
    $chkSaida = 'checked';
    $andTipo = "and m.tipo = 'saida'";
  }
} else {
  $chkEntrada = 'checked';
  $chkSaida = 'checked';
  $andTipo = "";
}

if (isset($_GET['generoOpt'])) {
  $generoOpt = $_GET['generoOpt'];
  if ($generoOpt == 'Todos') {
    $generoOptTodos = "checked";
    $andGenero = '';
  } else {
    $andGenero = "and i.genero_fk = '$generoOpt'";
  }
} else {
  $generoOptTodos = "checked";
  $generoOpt = '';
}
if (isset($_GET['textobusca'])) {
  $textoBusca = $_GET['textobusca'];
} else {
  $textoBusca = '';
}



echo "<span class='btn btn-light'>Data Inicial:</span><input type='date' class='btn-light' id='datainicio' value='$datainicio'>";
echo "<br>";
echo "<span class='btn btn-light'>Data Final:</span><input type='date' class='btn-light' id='datafim' value='$datafim'>";


echo "<br>";

echo "<div id='boxFiltro'>";
//filtra entrada e saída
echo "<div class='opcoesFiltra'>";

echo "<div class='opcoesCheck'>";
echo "<span>Tipo: </span>";
echo "<span><input class='form-check-input' type='checkbox' value='entrada' id='chkEntrada' $chkEntrada> Entrada</span>";
echo "<span><input class='form-check-input' type='checkbox' value='saida' id='chkSaida' $chkSaida> Saída</span>";
echo "</div>";
//lista generos para filtra
$bdListaGeneros = new BD;
$sqlListaGeneros = "SELECT * FROM db_farmacia.tb_farmgenero";
$resultListaGeneros = $bdListaGeneros->consulta($sqlListaGeneros);
echo "<div class='opcoesCheck'>";
echo "<span>Genero: </span>";
echo "<span><label><input class='form-check-input' type='radio' name='optGenChk' class='optGenChk' value='Todos' $generoOptTodos> Todos</label></span>";

foreach ($resultListaGeneros as $listaGenero) {

  $idGenero = $listaGenero->id;
  $nomeGenero = utf8_encode($listaGenero->genero);
  if ($generoOpt == "$idGenero") {
    $chkGen = 'checked';
  } else {
    $chkGen = '';
  }

  echo "<span><label><input class='form-check-input' type='radio' name='optGenChk' value='$idGenero' $chkGen> $nomeGenero $este</label></span>";
}
echo "</div>";
echo "</div>";

echo "Nome: <input type'text' name='textoBusca' id='textoBusca' value='$textoBusca'>";

echo "<button id='filtraData' class='btn btn-primary'>Filtrar</button>";
echo "</div>";


?>
<script type="text/javascript">
  $(document).ready( function () {
    $('#ultimosMovimentos').DataTable({
      language: {
                        url:"/siiupa/js/dataTables/pt-BR.json"
          },
          "lengthMenu": [ [25, 50, -1], [25, 50, "Todos"] ],
    });
} );
  function filtraData() {
    datainicio = $("#datainicio").val();
    datafim = $("#datafim").val();
    generoOpt = $("input[name='optGenChk']:checked").val();
    textoBusca = $("#textoBusca").val();


    chkEntrada = $("#chkEntrada")[0].checked;
    chkSaida = $("#chkSaida")[0].checked;
    let tipo = 't';
    if (chkEntrada && !chkSaida) {
      tipo = 'e';
    } else if (!chkEntrada && chkSaida) {
      tipo = 's';
    } else if (!chkEntrada && !chkSaida) {
      tipo = 't';
    }



    if (datainicio != "" && datafim != "") {
      if (datainicio <= datafim) {

        window.location.href = `/siiupa/farmacia/movimentos/${datainicio}-a-${datafim}&${tipo}&${generoOpt}&${textoBusca}`;
      } else {
        $.alert("A data final deve ser maior ou igual a data inicial.");
      }
    }
  }

  //pesquisa se apertar o botão filtrar ou se aperta enter no input nome
  $("#filtraData").click(filtraData);
  $("#textoBusca").keyup(function(e){
    if(e.keyCode == 13)
    {
      filtraData();
    }
});
</script>

<?php

$query = "SELECT DATE_FORMAT(m.datahora,'%d\/%m\/%Y %H:%i'), m.tipo, sum(m.quantidade) as quantidade, m.setor_origem_fk as Origem, m.setor_dest_fk as Destino, m.usuario as usuario_id, i.nome, s.setor as Setor1, s2.setor as Setor2, u.usuario as usuarioNome, m.item_fk FROM db_farmacia.tb_farmmovimento AS m INNER JOIN db_farmacia.tb_farmitem AS i ON (m.item_fk = i.id) INNER JOIN db_farmacia.tb_farmsetor AS s ON (m.setor_origem_fk = s.id) INNER JOIN db_farmacia.tb_farmsetor AS s2 ON (m.setor_dest_fk = s2.id) INNER JOIN login.usuarios AS u on (m.usuario = u.id) where m.datahora between '$datainicio 00:00:00' and '$datafim 23:59:59'  $andTipo $andGenero and i.nome like '%$textoBusca%' group by tipo, m.item_fk, m.datahora order BY m.datahora, i.nome  ASC ";
//echo $query;

$todosResultadosBusca = mysqli_query($conn, $query);
$tr = $todosResultadosBusca->num_rows; // verifica o número total de registros
$tp = $tr / $total_reg; // verifica o número total de páginas

$tableSorter = "<img src='/siiupa/imagens/tablesorter.svg' width='10px'>";
$datainicial = date_parse($datainicio);
$datafinal = date_parse($datafim);
//var_dump($datainicial);
$dataExibe1 = new DateTime();
$dataExibe2 = new DateTime();
$dataExibe1->setTime(0, 0, 0);
$dataExibe2->setTime(23, 59, 59);
$dataExibe1->setDate($datainicial['year'], $datainicial['month'], $datainicial['day']);
$dataExibe2->setDate($datafinal['year'], $datafinal['month'], $datafinal['day']);






echo "
    
    <h4 id='periodoFiltro'>De: " . $dataExibe1->format('d/m/Y') . " a: " . $dataExibe2->format('d/m/Y') . "</h4>
<table class='table table-sm table-hover table-bordered table-striped tablesorter' id='ultimosMovimentos'>
  <thead>
    <tr>
      <th scope='col'>DATA</th>
      <th scope='col'>MOV</th>
      <th scope='col'><span>QTD</span></th>
      <th scope='col'>ITEM</th>
      <th scope='col'>ORIGEM</th>
      <th scope='col'>DESTINO</th>
      <th scope='col'>USUÁRIO</th>
    </tr>
  </thead>
  <tbody>";

if ($stmt = $conn->prepare("$query LIMIT $inicio,$total_reg")) {
  $stmt->execute();
  $stmt->bind_result($datahora, $tipo, $quantidade, $Origem, $Destino, $usuario, $nome, $Setor1, $Setor2, $usuarioNome, $item_fk);
  while ($stmt->fetch()) {


    if ($tipo == 'saida') {
      $tipoBS = 'table-danger';
      $tipoBolha = "<img src='/siiupa/imagens/icones/saida.fw.png'>";
    } else {
      $tipoBS = 'table-success';
      $tipoBolha = "<img src='/siiupa/imagens/icones/entrada.fw.png'>";
    }
    // printf("%s, %s, %s, %s, %s\n", $datahora, $tipo, $novoestoque, $nome, $Origem);
    $linkItemDetalha = "/siiupa/farmacia/item-detalhe/$item_fk-" . sanitize_title($nome);
    echo "
          <tr class='$tipoBS'>
          <td scope='row'><small>$datahora</small></td>
          <td>$tipoBolha $tipo</td>
          <td>$quantidade</td>
          <td><a class='linksMovimento' href='$linkItemDetalha'>$nome <img src='/siiupa/imagens/icones/info.fw.png'></a></td>
          <td>$Setor1</td>
          <td>$Setor2</td>
          <td>$usuarioNome</td>
        </tr>
          ";
  }
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
