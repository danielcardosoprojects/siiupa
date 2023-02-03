<script type="text/javascript" src="/siiupa/js/preloader/percent-preloader.min.js"></script>
<link rel="stylesheet" href="/siiupa/js/preloader/percent-preloader.min.css">
<style>
  .dataTables_filter {
    text-align: left !important;
    float: left !important;
    margin-right: 10px;
    ;
  }

  .classesTerapeuticas {
    margin-top: 2px;
  }

  #filtrosFlex {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    justify-content: space-around;
  }

  .teste {
    display: flex;
    margin-right: 10px;
    ;
  }
</style>
<div class="preloader">
  <div class="inner"><span class="percentage"><span id="percentage">15</span>%</span>
  </div>
  <div class="loader-progress" id="loader-progress"> </div>
</div>
<div id="accordion">
  <h3>FILTROS</h3>
  <div id="filtrosFlex">



    <?php


    $sqlClasses = "SELECT c.id, c.categoria, count(c.categoria) as cat_qtd FROM db_farmacia.tb_farmitem as i inner join db_farmacia.tb_farmcategoria as c on (categoria_fk = c.id OR categoria2_fk = c.id  OR categoria3_fk = c.id  OR categoria4_fk = c.id) group by c.categoria order by c.categoria ASC";
    $conClasses = new BD;
    $classesFiltra = $conClasses->consulta($sqlClasses);

    $tituloPagina = ' - Tudo';
    $arrayCategorias = [];
    echo "<a href='/siiupa/farmacia/estoque/' class='btn btn-sm btn-warning'> TODOS</a>  ";
    echo "<a href='/siiupa/farmacia/estoque/filtra/genero-2' class='btn btn-sm btn-warning'>Correlatos</a>  ";
    echo "<a href='/siiupa/farmacia/estoque/filtra/genero-1' class='btn btn-sm btn-warning'>Medicações</a>  ";
    foreach ($classesFiltra as $cFiltra) {

      $categoria = utf8_encode($cFiltra->categoria);
      $arrayCategorias[$cFiltra->id] = $categoria;

      echo "<a href='/siiupa/farmacia/estoque/filtra/classe-$cFiltra->id#imprimir' class='btn btn-sm btn-info classesTerapeuticas'>$categoria ($cFiltra->cat_qtd)</a> ";
      if (isset($_GET['fclasse'])) {
        if ($_GET['fclasse'] == $cFiltra->id) {
          $tituloPagina = " - $categoria";
        }
      }
    }





    /* ESTOQUE */
    ?>
  </div>

</div>
<!-- PESQUISA ANTIGA 
<form id="pesquisaItem" class="form">
  <strong>Buscar item:</strong>
  <input id="entrada" type="txt" placeholder="Digite o item que deseja buscar" class="form-control">
</form>
<strong id="quantidade"></strong>
<span id="saidaTxt"></span>
<hr>
PESQUISA ANTIGA FIM -->

<a href="#estoqueImpressao" id="imprimir" class="btn btn-outline-success"><img src="/siiupa/imagens/icones/impressora.svg" width="20px"> Visualizar impressão</a>
<script>
  $("#accordion").accordion({
    collapsible: true,
    active: 2
  });
  $(function() {

    $(document).ready(function() {
      if (lapis) {
        $(".lapis").show()
      };
      busca = null;
      boxes = $(".box_itens"); //boxes onde contem os dados a serem pesquisados

      boxes = boxes.toArray();

      array = [];
      arrayValores = [];
      for (box in boxes) {
        array.push(boxes[box].attributes.name.value) //lista de valores a serem buscados

      }
      /* PESQUISA ANTIGA


      $('#pesquisaItem').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
          event.preventDefault();
        }

      });


      $('#pesquisaItem').bind('input', function(event) {



        busca = $('#entrada').val().toLowerCase();

        if (busca !== '') {
          console.log(busca);
          corresponde = false;
          saida = Array();
          quantidade = 0;
          for (key in array) {


            corresponde = array[key].toLowerCase().indexOf(busca) >= 0;
            if (corresponde) {
              saida.push(array[key]);
              console.log(boxes[key]);
              nome = array[key];
              arrayValores[nome] = boxes[key];
              $(boxes[key]).show();
              quantidade += 1;
            } else {
              $(boxes[key]).hide();

            }
          }
          if (quantidade) {
            $('#saidaTxt').text('');
            $('#quantidade').html(quantidade + ' resultados!<br><br>');
            for (ind in saida) {

              nomeSaida = saida[ind]
              arrayValores[nomeSaida]
              //$('#saidaTxt').append(arrayValores[nomeSaida]);

            }

          } else {
            $('#quantidade').html('');
            $('#saidaTxt').text('Nenhum resultado...');
            $('.box_itens').show();
          }

        } else {
          $('#quantidade').html('');
          $('#saidaTxt').text('Nenhum resultado...');

          $('.box_itens').show()
        }




      });*/

      $("#imprimir").click(function() {
        $('.lapis').hide();

        var elem = $('#estoqueImpressao');
        corpo = elem.html();
        tituloPaginaAtual = $("#tituloPaginaAtual").html();
        dataAtual = $("#tituloPaginaAtual").data('dataatual');
        var mywindow = window.open('', 'PRINT', 'height=500,width=900');

        mywindow.document.write('<html><head><title>' + tituloPaginaAtual + ' - ' + dataAtual + ' - Farmácia - ' + document.title + '</title>');
        mywindow.document.write('<link rel="stylesheet" href="/siiupa/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<div style="text-align:center;width:100%"><img src="/siiupa/imagens/cabeçalho_2022.JPG">');
        mywindow.document.write('<br><br><h3><img src="/siiupa/imagens/icones/farmacia.svg" height="30px"> Farmácia - UPA</h3></div>');

        mywindow.document.write(corpo);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        setTimeout(() => {
          mywindow.print();
        }, 2000);

        // mywindow.close();


        return true;
      });
    });


  });
</script>

<?php
//filtros//
if (isset($_GET['fclasse'])) {
  $fclasse = $_GET['fclasse'];
  $where = "WHERE categoria_fk = '$fclasse' OR categoria2_fk = '$fclasse' OR categoria3_fk='$fclasse' OR categoria4_fk='$fclasse'";
} else {
  $fclasse = '';
  $where = '';
}

if (isset($_GET['fgenero'])) {
  $fgenero = $_GET['fgenero'];
  $gwhere = "WHERE genero_fk='$fgenero'";
  if ($fgenero == '1') {
    $tituloPagina = " - Medicação";
  } elseif ($fgenero == '2') {
    $tituloPagina = " - Correlatos";
  }
} else {
  $fgenero = '';
  $gwhere = '';
}
$query = "SELECT i.id as itemid, i.nome, g.genero, c.categoria, i.categoria_fk, i.categoria2_fk, i.categoria3_fk, i.categoria4_fk, i.quantidade, i.barcode FROM db_farmacia.tb_farmitem as i INNER JOIN db_farmacia.tb_farmcategoria as c ON (i.categoria_fk = c.id) INNER JOIN db_farmacia.tb_farmgenero as g ON (i.genero_fk = g.id) $where $gwhere order by nome ASC";
//echo $query;

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Belem');


echo '
<hr>
<div id="estoqueImpressao">
<h4 id="tituloPaginaAtual" data-dataatual="' . date("d-m-Y") . '">Estoque' . $tituloPagina . '</h4>
<table class="table table-sm table-hover table-bordered table-striped" id="tabelaEstoque">
<p class="text-right">Castanhal, ' . utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))) . " - " . date("H:i:s") . "<br>Usuário: " . utf8_encode($_SESSION["nomeusuario"]) . '</p>
<thead>
<tr>
 <th scope="col">#</th>
  <th scope="col">ITEM</th>
  <th scope="col">GENERO</th>
  <th scope="col">CATEGORIA</th>
  <th scope="col">QUANTIDADE</th>
  <th scope="col">barcode</th>
</tr>
</thead>
<tbody>';

if ($stmt = $conn->prepare($query)) {
  $stmt->execute();
  $stmt->bind_result($itemid, $nome, $genero, $categoria, $categoria_fk, $categoria2_fk, $categoria3_fk, $categoria4_fk, $quantidade, $barcode);
  while ($stmt->fetch()) {
    // printf("%s - %s - %s - %s<br>", $itemid, $nome, $categoria, $quantidade);
    $itemLinkTexto = sanitize_title($nome);
    echo "
<tr class='box_itens' name='$nome $itemid $barcode'>
  
  <td>$itemid</td>

  <td scope='row'><a href='/siiupa/farmacia/item-detalhe/$itemid-$itemLinkTexto'><strong>$nome</strong> <img src='/siiupa/imagens/icones/info.fw.png'></a> <a href='/siiupa/farmacia/item/edita/$itemid' onclick='itemCarrega(this, event)' id='item_$itemid'><img class='lapis' src='/siiupa/imagens/icones/edita.png'></a>
  ";

    $conLote = new BD;
    $sqlConLote = "SELECT *, DATE_FORMAT(data_validade, '%d/%m/%Y') as dataValBr FROM db_farmacia.tb_farmestoque where item_fk = '$itemid' and estoque > 0";
    $lotes = $conLote->consulta($sqlConLote);

    foreach ($lotes as $lote) {
      echo "<br><small><small>→Lote: $lote->lote | Val: $lote->dataValBr | Qtd: $lote->estoque</small></small>";


      //CONVERTER OS NOMES DOS ITENS PARA OS LOTES-ESTOQUES
      // $sqlTemp = "UPDATE db_farmacia.tb_farmestoque SET nome_produto = '$nome', barcode = '$barcode' WHERE (id = '$lote->id');";
      // $sqlTemps .= $sqlTemp;
      // $tempBd = new BD;
      //$tempBd->consulta($sqlTemp);

    }


    $numberRandom = mt_rand(0, 100);
    if ($numberRandom > 80) {
      $colorProgress = "bg-success";
    } elseif ($numberRandom < 40 && $numberRandom > 20) {
      $colorProgress = "bg-warning";
    } elseif ($numberRandom <= 20) {
      $colorProgress = "bg-danger";
    } else {
      $colorProgress = "";
    }

    echo '<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar ' . $colorProgress . '" style="width: ' . $numberRandom . '%;height:5px;"></div>
  </div>
  ';
    echo "</td>";

    echo "<td>$genero</td>";

    //CATEGORIZA
    $categoria1 = $arrayCategorias[$categoria_fk];
    $categoria2 = $arrayCategorias[$categoria2_fk];
    $categoria3 = $arrayCategorias[$categoria3_fk];
    $categoria4 = $arrayCategorias[$categoria4_fk];

    if ($categoria2 != null) {
      $categoria2 = "<br>" . $categoria2;
    }
    if ($categoria3 != null) {
      $categoria3 = "<br>" . $categoria3;
    }
    if ($categoria4 != null) {
      $categoria4 = "<br>" . $categoria4;
    }

    echo "<td>$categoria1$categoria2$categoria3$categoria4</td>";

    $consultaEstoque = new BD;
    $sqlConsultaEstoque = "SELECT sum(estoque) as estoque FROM db_farmacia.tb_farmestoque where item_fk='$itemid' AND estoque>0 order by data_validade ASC;";

    $totalEstoque = $consultaEstoque->consulta($sqlConsultaEstoque);

    foreach ($totalEstoque as $estoque) {
      if ($estoque->estoque == '') {
        $qtd_estoque = 0;
      } else {
        $qtd_estoque = $estoque->estoque;
      }
      echo "
    <td>$qtd_estoque</td>
    ";
    }


    echo "
    <td>$barcode</td>
  
</tr>";
  }
  $stmt->close();
  // echo $sqlTemps;
}

echo '</tbody>
</table>

</div>';


?>
<script>
  $(document).ready(function() {
    $('#tabelaEstoque').DataTable({
      //"dom": '<"wrapper"flipt>',
      "dom": '<"top"<"teste"f><"teste"l>ip>rt<"bottom"p><"clear">',
      "lengthMenu": [
        [25, 50, -1],
        [25, 50, "Todos"]
      ],
      "order": [
        [1, 'asc']
      ],
      fixedHeader: true,
      language: {
        url: "/siiupa/js/dataTables/pt-BR.json"
      },
      columnDefs: [{
        target: 5,
        visible: false,
        searchable: true,
      }]
    });

  });
</script>