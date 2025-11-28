<?php






@include("../bd/conectabd.php");
@include_once("../classes/crud.class.php");

if (isset($_GET['ano_ferias'])) {
  $ano_ferias = $_GET['ano_ferias'];
} else {
  $ano_ferias = '2025';
}

if (isset($_GET['vinculo'])) {
  $filtra_vinculo = "and func.vinculo = '$_GET[vinculo]'";
} else {
  $filtra_vinculo = "";
}

?>
<div style="display:flex;gap:20px;">
  <h1><a class="btn btn-lg btn-outline-success" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2022">2022</a></h1>
  <h1><a class="btn btn-lg btn-outline-success" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2023">2023</a></h1>
  <h1><a class="btn btn-lg btn-outline-success" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2024">2024</a></h1>
  <h1><a class="btn btn-lg btn-outline-success" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2025">2025</a></h1>
  <h1><a class="btn btn-lg btn-outline-success" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2026">2026</a></h1>
</div>

<div style="display:flex;gap:20px;">
  <h2><a class="btn btn-lg btn-outline-info" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2026&vinculo=temporario">TEMPORÁRIOS</a></h2>
  <h2><a class="btn btn-lg btn-outline-info" href="/siiupa/?setor=adm&sub=rh&subsub=ferias&ano_ferias=2026&vinculo=efetivo">EFETIVOS</a></h2>
  
</div>
<?php

class Formulario
{
  function abreForm($nomeid, $method, $action)
  {
    echo "<form name='$nomeid' id='$nomeid' method='$method' action='$action'>";
  }
  function fechaForm()
  {
    echo "</form>";
  }

  function input($label, $tipo, $nomeid, $valor)
  {

    echo "<label>$label <input type='$tipo' name='$nomeid' id='$nomeid' value='$valor'></label>";
  }

  function abreSelect($nomeid, $class = "")
  {

    echo "<select name='$nomeid' id='$nomeid' class='$class'>";
  }
  function option($valor, $texto, $selected = "")
  {
    echo "<option value='$valor' $selected>$texto</option>";
  }
  function fechaSelect()
  {
    echo "</select>";
  }




  function pula($entrada)
  {
    for ($i = 1; $i <= $entrada; $i++) {
      echo "</br>";
    }
  }
}
class Tabela
{
  public function abreTabela($nomeid, $class = "", $mesano)
  {
    echo "<table name='$nomeid' id='$nomeid' class='$class' data-tabela='$mesano'>";
  }
  public function fechaTabela()
  {
    echo "</tbody>";
    echo "</table>";
  }

  public function abreThead()
  {
    echo "<thead><tr>";
  }
  public function tcabecalho($entrada)
  {
    echo "<th scope='col'>$entrada</th>";
  }

  public function fechaThead()
  {
    echo "</tr></thead><tbody>";
  }

  public function tabrelinha($nome = '', $mesano = '')
  {

    echo "<tr class='box_ferias' name='$nome' data-tabela='$mesano'>";
  }

  public function tpopulalinha($entrada)
  {
    echo "<td>$entrada</td>";
  }

  public function tfechalinha()
  {

    echo "</tr>";
  }
}

function mes($entrada)
{
  switch ($entrada) {
    case 1:
      return "Janeiro";
    case 2:
      return "Fevereiro";
    case 3:
      return "Março";
    case 4:
      return "Abril";
    case 5:
      return "Maio";
    case 6:
      return "Junho";
    case 7:
      return "Julho";
    case 8:
      return "Agosto";
    case 9:
      return "Setembro";
    case 10:
      return "Outubro";
    case 11:
      return "Novembro";
    case 12:
      return "Dezembro";
  }
  return $entrada;
}
?>

<script>
  $(function() {
    $(document).ready(function() {
      var busca = null;
      var boxes = $(".box_ferias"); //boxes onde contem os dados a serem pesquisados
      boxes = boxes.toArray();
      var array = [];
      var arrayValores = [];  
      for (box in boxes) {
        array.push(boxes[box].attributes.name.value) //lista de valores a serem buscados

      }

      $('#pesquisaFerias').bind('input', function() {
        busca = $('#entrada').val().toLowerCase();

        if (busca !== '') {
          var corresponde = false;
          var saida = Array();
          var quantidade = 0;
          for (var key in array) {

            corresponde = array[key].toLowerCase().indexOf(busca) >= 0;
            if (corresponde) {
              saida.push(array[key]);
              nome = array[key];
              arrayValores[nome] = boxes[key];
              $(boxes[key]).show();
              tabela = $(boxes[key]).data('tabela');
              tabela = "table[data-tabela=\"" + tabela + "\"]";
              console.log(tabela);
              quantidade += 1;
            } else {
              $(boxes[key]).hide();
              tabela = $(boxes[key]).data('tabela');
              tabela = "table[data-tabela=\"" + tabela + "\"]";
              $(tabela).hide();

            }
          }
          if (quantidade) {
            $('#saidaTxt').text('');
            //$('#quantidade').html(quantidade + ' resultados!<br><br>');
            for (var ind in saida) {

              nomeSaida = saida[ind]
              arrayValores[nomeSaida]
              //$('#saidaTxt').append(arrayValores[nomeSaida]);

            }

          } else {
            $('#quantidade').html('');
            $('#saidaTxt').text('Nenhum resultado...');
            $('.box_ferias').show();
          }

        } else {
          $('#quantidade').html('');
          $('#saidaTxt').text('Nenhum resultado...');

          $('.box_ferias').show()
        }




      });
    });


    $("#imprimirferias").click(function() {
      var elem = $('#ferias_impressao');
      var mywindow = window.open('', 'PRINT', 'height=400,width=600');

      mywindow.document.write('<html><head><title>' + document.title + '</title>');
      mywindow.document.write('<link rel="stylesheet" href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">');
      mywindow.document.write('</head><body >');
      //mywindow.document.write('<img src="imagens/siiupa.png">');

      mywindow.document.write(elem.html());
      mywindow.document.write('</body></html>');

      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10*/

      mywindow.print();
      // mywindow.close();


      return true;
    });
    $('#btfiltraferias').click(function() {
      setorselecionado = $('#setor').val();
      ano_ferias = <?=$ano_ferias;?>;
      var filtrar = '?setor=adm&sub=rh&subsub=ferias&ano_ferias='+ano_ferias+'&idsetor=' + setorselecionado;
      window.location.href=filtrar;
      //location.assign(filtrar);
    });

    $('.editaobservacao').dblclick(function() {
      var celula = $(this);
      var valorinicial = celula.html();
      var feriasid = celula.data('feriasid');
      var campo = celula.data('campo');
      //insere o input com o valor inicial dentro para editar
      var inputedita = "<form class='formedita'><input type='text' class='celulaedita' value='" + valorinicial + "' size='5'><button type='submit' class='btneditaobservacao'>Alterar</button><form>";
      celula.html(inputedita);
      $('.celulaedita').focus();
      $('.celulaedita').select();

      $('.formedita').submit(function() {

        event.preventDefault();
        var valor = $('.celulaedita').val();
        linkatt = 'administracao/ferias/atualiza_ferias.php?id=' + feriasid + '&campo=' + campo + '&valor=' + valor;


        $.get(linkatt, function(data) {

          celula.html(data);


        });
        $.get()
      });

    });
  });
</script>

<a href="#" id="imprimirferias" class="btn btn-success">
  Imprimir
</a>
<?php
echo "<div id='ferias_impressao'>"; //////////// AREA DE IMPRESSA INICIO //////////////
echo "<h1>Férias / Recesso $ano_ferias</h1>";
//////////////////////////// FILTRAR E BUSCAR //////////////////////////
$form = new Formulario;
$form->abreForm('filtraFerias', 'GET', '?');

if (isset($_GET['idsetor'])) {
  $idsetor = $_GET['idsetor'];
  if ($idsetor != "") {
    $fitrasetor = "AND func.fk_setor = '$idsetor'";
  } else {
    $fitrasetor = "";
  }
} else {
  $fitrasetor = "";
}

$query = "SELECT s.id, s.setor, s.categoria FROM u940659928_siupa.tb_setor as s ORDER BY s.setor ASC";
$form->abreSelect('setor', $class = "form-select");
$form->option("", "Todos");

if ($stmt = $conn->prepare($query)) {
  $stmt->execute();
  $stmt->bind_result($id, $setor, $categoria);
  while ($stmt->fetch()) {

    $valor = $setor . " - " . $categoria;

    if ($idsetor == $id) {
      $selected_filtro_setor = "selected";
    } else {
      $selected_filtro_setor = "";
    }
    $form->option($id, $valor, $selected_filtro_setor);
  }
  $stmt->close();
}
$form->fechaSelect();
$form->input("", "submit", "btfiltraferias", "Filtrar");
$form->fechaForm();

////////////////////////// FIM DA BUSCA E FILTRO //////////////////
?>

<strong>Buscar nome:</strong>
<form id="pesquisaFerias">
  <input id="entrada" type="txt" placeholder="O que você quer buscar?">
  <input type="submit" value="Pesquisar"></input>
</form>

<?php
///////////////////////////// TABELA ////////////////////////////////////

$tabela = new Tabela;
/* $tabela->abreTabela('tabelaFerias', $class = 'table table-striped table-bordered table-hover');
$tabela->abreThead();
$tabela->tcabecalho('NOME');
$tabela->tcabecalho('Função');
$tabela->tcabecalho('Setor');
$tabela->tcabecalho('ANO');
$tabela->tcabecalho('MÊS');
$tabela->tcabecalho('INÍCIO');
$tabela->tcabecalho('TÉRMINO');
$tabela->tcabecalho('VINCULO');
$tabela->tcabecalho('OBSERVAÇÃO');

$tabela->fechaThead();
*/

/////////////////////////// linhas da tabela ///////////////////


//$query = "SELECT func.nome, c.titulo, s.setor, DATE_FORMAT(ferias.datainicio, '%d\/%m\/%Y'), DATE_FORMAT(ferias.datafim, '%d\/%m\/%Y'), ferias.ref_mes, ferias.ref_ano, func.vinculo, ferias.observacao FROM u940659928_siupa.tb_ferias AS ferias INNER JOIN u940659928_siupa.tb_funcionario AS func ON (ferias.fk_funcionario = func.id) INNER JOIN u940659928_siupa.tb_cargo AS c ON (func.fk_cargo = c.id) INNER JOIN u940659928_siupa.tb_setor AS s ON (func.fk_setor = s.id) WHERE func.status='ATIVO' $fitrasetor ORDER BY s.setor, ref_mes, c.titulo, nome ASC";
$query = "SELECT ferias.id, func.nome, c.titulo, s.setor, DATE_FORMAT(ferias.datainicio, '%d\/%m\/%Y'), DATE_FORMAT(ferias.datafim, '%d\/%m\/%Y'), ferias.ref_mes, ferias.ref_ano, func.vinculo, ferias.observacao FROM u940659928_siupa.tb_ferias AS ferias INNER JOIN u940659928_siupa.tb_funcionario AS func ON (ferias.fk_funcionario = func.id) INNER JOIN u940659928_siupa.tb_cargo AS c ON (func.fk_cargo = c.id) INNER JOIN u940659928_siupa.tb_setor AS s ON (func.fk_setor = s.id) WHERE func.status='ATIVO' $filtra_vinculo /*AND func.vinculo IN('TEMPORARIO')*/ AND ferias.ref_ano ='$ano_ferias'/* AND NOT (func.fk_setor = '17' OR func.fk_setor = '21') */ $fitrasetor ORDER BY ref_ano ASC, ref_mes ASC, func.nome ASC";
//echo $query;

if ($stmt = $conn->prepare($query)) {
  $stmt->execute();
  
  $stmt->bind_result($feriasid, $nome, $funcao, $setor, $datainicio, $datafim, $ref_mes, $ref_ano, $vinculo, $observacao);
  while ($stmt->fetch()) {
    $grupomes[$ref_ano . $ref_mes][$nome] = ["feriasid" => $feriasid, "nome" => $nome, "funcao" => $funcao, "setor" => $setor, "ref_ano" => $ref_ano, "ref_mes" => $ref_mes, "datainicio" => $datainicio, "datafim" => $datafim, "vinculo" => $vinculo, "observacao" => $observacao];
    $ref_mes = mes($ref_mes);
    /* $tabela->tabrelinha();
    $tabela->tpopulalinha($nome);
    $tabela->tpopulalinha($funcao);
    $tabela->tpopulalinha($setor);
    $tabela->tpopulalinha($ref_ano);
    $tabela->tpopulalinha($ref_mes);
    $tabela->tpopulalinha($datainicio);
    $tabela->tpopulalinha($datafim);
    $tabela->tpopulalinha($vinculo);
    //$tabela->tpopulalinha($observacao);
    echo "<td class='editaobservacao' data-feriasid='$feriasid' data-campo='observacao'>$observacao</td>";
    $tabela->tfechalinha();
    */
  }
  $stmt->close();
}
//////////////////// fecha a tabela ////////////////////////
//$tabela->fechaTabela();


uksort($grupomes, 'strnatcmp');
//print_r($grupomes);

foreach ($grupomes as $anomes) {

  $mes_nome = key($grupomes);
  $mes_nome = substr($mes_nome, 4);
  $ano = substr(key($grupomes), 0, 4);
  $mesano = mes($mes_nome) . substr(key($grupomes), 0, 4);
  echo "<h3 style='background-color:#000;color:#fff;padding:3px 5px;text-transform: uppercase;' class='card-title' name='" . mes($mes_nome) . "'>" . mes($mes_nome) . " - " . substr(key($grupomes), 0, 4) . "</h3>";

  $tabela->abreTabela('tabelaFerias', $class = 'table table-striped table-bordered table-hover border-dark', $mesano);

  $tabela->abreThead();
  $tabela->tcabecalho('NOME');
  $tabela->tcabecalho('Cargo');
  $tabela->tcabecalho('Setor');
  $tabela->tcabecalho('ANO');
  $tabela->tcabecalho('MÊS');
  $tabela->tcabecalho('INÍCIO');
  $tabela->tcabecalho('TÉRMINO');
  $tabela->tcabecalho('VINCULO');
  $tabela->tcabecalho('OBSERVAÇÃO');

  $tabela->fechaThead();
  foreach ($anomes as $linha) {

    $linha = (object) $linha;
    $mesano = mes($linha->ref_mes) . $linha->ref_ano;
    $tabela->tabrelinha($linha->nome, $mesano);
    $tabela->tpopulalinha($linha->nome);
    $tabela->tpopulalinha($linha->funcao);
    $tabela->tpopulalinha($linha->setor);
    $tabela->tpopulalinha($linha->ref_ano);
    $tabela->tpopulalinha(mes($linha->ref_mes));
    $tabela->tpopulalinha($linha->datainicio);
    $tabela->tpopulalinha($linha->datafim);
    $tabela->tpopulalinha($linha->vinculo);
    //$tabela->tpopulalinha($observacao);
    echo "<td class='editaobservacao' data-feriasid='$linha->feriasid' data-campo='observacao'>$linha->observacao</td>";
    $tabela->tfechalinha();
  }
  $tabela->fechaTabela();
  next($grupomes);
}

echo "</div>"; /////////////////////////// fim da area de impressao