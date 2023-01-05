<style>
  .dataTables_filter  {
text-align: left !important;
float: left !important;
margin-right: 10px;;
}
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
</style>


<?php

if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 1) {


  /*ULTIMOS MOVIMENTOS */
  if (isset($_GET['quantidade'])) {

    $total_reg = $_GET['quantidade'];
    if ($total_reg <= 0) {
      $total_reg = "15";
    }
  } else {
    $total_reg = "15";
  } // limita limite número de registros por página

  $pagina = isset($_GET['pagina']);

  if (!$pagina) {
    $pc = "1";
  } else {

    $pc = $_GET['pagina'];
  }
  $queryString = filter_input(INPUT_SERVER, 'QUERY_STRING');
  //echo $pc;
  //echo $queryString;
  $inicio = $pc - 1;
  $inicio = $inicio * $total_reg;
  $query = "SELECT m.novoestoque, m.estoqueanterior, DATE_FORMAT(m.datahora,'%d\/%m\/%Y %H:%i'), m.tipo, m.quantidade, m.setor_origem_fk as Origem, m.setor_dest_fk as Destino, m.usuario as usuario_id, i.nome, s.setor as Setor1, s2.setor as Setor2, u.usuario as usuarioNome, m.item_fk FROM db_farmacia.tb_farmmovimento AS m INNER JOIN db_farmacia.tb_farmitem AS i ON (m.item_fk = i.id) INNER JOIN db_farmacia.tb_farmsetor AS s ON (m.setor_origem_fk = s.id) INNER JOIN db_farmacia.tb_farmsetor AS s2 ON (m.setor_dest_fk = s2.id) INNER JOIN login.usuarios AS u on (m.usuario = u.id) ORDER BY m.id DESC";

  $todosResultadosBusca = mysqli_query($conn, $query);
  $tr = $todosResultadosBusca->num_rows; // verifica o número total de registros
  $tp = $tr / $total_reg; // verifica o número total de páginas

  
  echo "
    
    <h4>Últimos movimentos</h4>
    <h5><small>NE: Novo estoque; DIF: Diferença entre o novo estoque e o estoque anterior;</small></h5>
<table class='table table-hover table-bordered  table-sm' id='ultimosMovimentos'>
  <thead>
    <tr>
      <th scope='col'>DATA</th>
      <th scope='col'>MOVIMENTO</th>
      <th scope='col'>QUANTIDADE</th>
      <th scope='col' title='Novo estoque'>NE</th>
      <th scope='col'>ITEM</th>
      <th scope='col'>ORIGEM</th>
      <th scope='col'>DESTINO</th>
      <th scope='col'>USUÁRIO</th>
    </tr>
  </thead>
  <tbody>";

  if ($stmt = $conn->prepare("$query LIMIT $inicio,$total_reg")) {
    $stmt->execute();
    $stmt->bind_result($estoqueanterior, $novoestoque, $datahora, $tipo, $quantidade, $Origem, $Destino, $usuario, $nome, $Setor1, $Setor2, $usuarioNome, $item_fk);
    while ($stmt->fetch()) {
      if($tipo=="entrada"){
      $qtd_correto = intval($novoestoque)-intval($estoqueanterior);
      } elseif($tipo=="saida"){
        $qtd_correto = intval($estoqueanterior)-intval($novoestoque);
      }



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
          <th scope='row'>$datahora</th>
          <td>$tipoBolha $tipo</td>
          <td>$quantidade (DIF: $qtd_correto)</td>
          <td title='Novo estoque'>$novoestoque</td>
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
    echo " <a href='/siiupa/farmacia/pagina/1/quantidade/$total_reg' class='btn btn-secondary btn-sm'><< 1</a> ";
  }

  if ($tp > 1) {


    //NUMERAÇÕES DA PÁGINA

    if($pc < 10) {
      $limita = 1;  
      $limitaMais = 10;
      
    } elseif ($pc<=(ceil($tp)-11)){
      $limita = $pc-10;
      $limitaMais = 10;
     
    } elseif(!($pc<=(ceil($tp)-10))){
      $limita = $pc-10;
      $limitaMais = ceil($tp)-$pc;
   
    }

    for ($i = $limita; $i <= $pc+$limitaMais; $i++) {

      if ($pc == $i) {
        $botaoPaginas = "btn-info";
      } else {
        $botaoPaginas = "btn-secondary";
      }
      echo "<a href='/siiupa/farmacia/pagina/$i/quantidade/$total_reg' class='btn $botaoPaginas btn-sm'>$i</a> ";
    }
  }

  //PROXIMA
  $ultimaPagina = ceil($tp);
  if ($pc < $tp) {
    echo " <a href='/siiupa/farmacia/pagina/$ultimaPagina/quantidade/$total_reg' class='btn btn-secondary btn-sm'>$ultimaPagina >></a>";
  }
}

?>