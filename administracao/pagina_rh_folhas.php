<script type="text/javascript" src="/siiupa/js/script.js"></script>
<script>
  $(function() {});
</script>
<style>
  .coluna_valor {
    text-align: center;
  }
  .ct-series-a .ct-line {
  /* Set the colour of this series line */
  stroke: blue;
  /* Control the thikness of your lines */
  stroke-width: 5px;
  /* Create a dashed line with a pattern */
  stroke-dasharray: 10px 20px;
}
.ct-series-a .ct-point {
  stroke: green;
  /* Control the thikness of your lines */
  stroke-width: 10px;
  /* Create a dashed line with a pattern */
  stroke-dasharray: 10px 20px;
}
.ct-series-a .ct-label{
  stroke:black;
}

/* Nome dos meses*/
.ct-labels span.ct-end{
  display:flex;
  color:black;

  border: 1px solid #fff;

  
}
</style>

<div class="d-flex">
  <a href="?setor=adm&sub=rh&subsub=rhfolhasmodifica" id="bcadastrarFUNCIONARIO" class="btn btn-success">
    <img src="imagens/icones/note_add.svg">
    Criar Folha</a>
</div>
<div class="ct-chart" id="chart0"></div>

<?php

function trataNaoNumericos($naoNumericos)
{
  if ($naoNumericos == '' || $naoNumericos == null) {
    return 0;
  } else {
    return floatval($naoNumericos);
  }
}
$query = "SELECT fls.id, fls.ref_mes, fls.ref_ano, DATE_FORMAT(fls.periodoinicio,'%d\/%m\/%Y'), DATE_FORMAT(fls.periodofim,'%d\/%m\/%Y'), fls.status FROM u940659928_siupa.tb_folhas AS fls order by periodoinicio DESC";
echo '
<table class="table table-hover table-sm">
        <thead>
          <tr>
          <th scope="col">MÊS REFERÊNCIA</th>
            <th scope="col">ANO</th>
            <th scope="col" class="col">VALOR</th>
            <th scope="col">INICIO</th>
            <th scope="col">FIM</th>
            
           
            
          </tr>
        </thead>
        <tbody>
        ';

        echo "<script>folhaRotulos = [];</script>";
        echo "<script>folhaValores = [];</script>";

if ($stmt = $conn->prepare($query)) {
  $stmt->execute();
  $stmt->bind_result($flsid, $ref_mes, $ref_ano, $periodoinicio, $periodofim, $status);
  while ($stmt->fetch()) {
    if (isset($valor_geral)) {
      $valor_anterior = $valor_geral;
    } else {
      $valor_anterior = 0;
    }
    $valor_geral = 0;


    $queryx = "SELECT fl.id as id_linha, func.id,func.nome, cargo.funcao_upa, fl.adc_not, fl.ext_6, fl.ext_12, fl.ext_24, fl.acionamento, fl.transferencia, fl.fixos, fl.obs, cargo.valor_plantao, cargo.valor_acionamento, cargo.valor_transferencia FROM u940659928_siupa.tb_folha AS fl INNER JOIN u940659928_siupa.tb_funcionario AS func ON (fl.fk_funcionario = func.id) INNER JOIN u940659928_siupa.tb_cargo AS cargo ON (func.fk_cargo = cargo.id) WHERE fl.fk_folhas = '12' ORDER BY func.nome ASC";

    $consultaValores = new BD;
    $sqlConsultaValores = "SELECT fl.id as id_linha, func.id,func.nome, cargo.funcao_upa, fl.adc_not, fl.ext_6, fl.ext_12, fl.ext_24, fl.acionamento, fl.transferencia, fl.fixos, fl.obs, cargo.valor_plantao, cargo.valor_acionamento, cargo.valor_transferencia FROM u940659928_siupa.tb_folha AS fl INNER JOIN u940659928_siupa.tb_funcionario AS func ON (fl.fk_funcionario = func.id) INNER JOIN u940659928_siupa.tb_cargo AS cargo ON (func.fk_cargo = cargo.id) WHERE fl.fk_folhas = '$flsid' ORDER BY func.nome ASC";
    $resultadoConsultaValores = $consultaValores->consulta($sqlConsultaValores);

    foreach ($resultadoConsultaValores as $resultadoValores) {
      $valor_total = 0;

      if ($resultadoValores->ext_6 == "") {
        $resultadoValores->ext_6 = 0;
      }
      if ($resultadoValores->ext_12 == "") {
        $resultadoValores->ext_12 = 0;
      }
      if ($resultadoValores->ext_24 == "") {
        $resultadoValores->ext_24 = 0;
      }
      if ($resultadoValores->acionamento == "") {
        $resultadoValores->acionamento = 0;
      }
      // $valores_exibe[$func_id] = "";
      $resultadoValores->transferencia = trataNaoNumericos($resultadoValores->transferencia);
      $resultadoValores->fixos = trataNaoNumericos($resultadoValores->fixos);
      $resultadoValores->valor_transferencia = trataNaoNumericos($resultadoValores->valor_transferencia);
      $resultadoValores->ext_6 = trataNaoNumericos($resultadoValores->ext_6);
      $resultadoValores->ext_12 = trataNaoNumericos($resultadoValores->ext_12);
      $resultadoValores->ext_24 = trataNaoNumericos($resultadoValores->ext_24);
      $valor_total = ($resultadoValores->ext_6 * ($resultadoValores->valor_plantao / 2)) + ($resultadoValores->ext_12 * $resultadoValores->valor_plantao) + ($resultadoValores->ext_24 * ($resultadoValores->valor_plantao * 2)) + ($resultadoValores->valor_acionamento * $resultadoValores->acionamento) + ($resultadoValores->valor_transferencia * $resultadoValores->transferencia) + $resultadoValores->fixos;


      $valor_geral += $valor_total;
    }
 
    $valor_geral_reais = numberParaReal($valor_geral);

    if ($valor_anterior > $valor_geral) {
      $variacao = "Aumentou";
    } else {
      $variacao = "Reduziu";
    }
    $ref_mes = mes($ref_mes);
    $ref_mes_curto = substr($ref_mes,0,3);

    //Adiciona os dados para o gráfico.
    if($valor_geral>0){;
    echo "<script>folhaRotulos.push('$ref_mes_curto-$ref_ano');folhaValores.push('$valor_geral');</script>";
    }

    if ($status == "aberta") {
      $status = '<svg width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
 <path d="M368,0c-61.758,0-112,50.242-112,112v112H64c-17.672,0-32,14.328-32,32v224c0,17.672,14.328,32,32,32h288
     c17.672,0,32-14.328,32-32V256c0-17.672-14.328-32-32-32h-32V112c0-26.469,21.531-48,48-48c26.469,0,48,21.531,48,48v80
     c0,17.672,14.328,32,32,32c17.672,0,32-14.328,32-32v-80C480,50.242,429.758,0,368,0z M224,397.063V432c0,8.836-7.164,16-16,16
     c-8.836,0-16-7.164-16-16v-34.938c-18.602-6.613-32-24.195-32-45.063c0-26.512,21.488-48,48-48s48,21.488,48,48
     C256,372.867,242.602,390.449,224,397.063z" fill="green"></svg>';
    } else {
      $status = '<svg width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 406.481 406.481" style="enable-background:new 0 0 406.481 406.481;" xml:space="preserve">
  <rect x="78.241" y="175" style="fill:#1EA6C6;" width="250" height="231.481"/>
  <path style="fill:#B3B3B3;" d="M302.269,175V99.028c0-26.454-10.296-51.315-29-70.019C254.574,10.306,229.704,0,203.241,0
     c-54.602,0-99.028,44.426-99.028,99.028V175h35.185V99.028c0-35.204,28.639-63.843,63.843-63.843
     c17.065,0,33.093,6.639,45.139,18.704c12.065,12.056,18.704,28.083,18.704,45.139V175H302.269z"/>
  <polygon style="fill:#FFFFFF;" points="191.957,343.55 149.008,300.356 159.645,289.78 190.779,321.092 245.788,252.753 
     257.473,262.158 " title="Fechada"></svg>';
    }

    printf('
        
        <tr>
        <th scope="row"><a href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=%s&ref_mes=%s&ref_ano=%s">%s %s</a></th>
        <td>%s</td>
        <td class="coluna_valor">%s</td>
        <td>%s</td>
        <td>%s</td>
        

      </tr>', $flsid, $ref_mes, $ref_ano, $status, $ref_mes, $ref_ano, $valor_geral_reais, $periodoinicio, $periodofim);
  }
  $stmt->close();
}

function numberParaReal($numero)
{

  return  "R$ " . number_format($numero, 2, ",", ".");;
}
echo '</tbody>
</table>';



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
      var data = {

// A labels array that can contain any sort of values

labels: folhaRotulos.reverse(),
// Our series array that contains series objects or in this case series data arrays
series: [
    folhaValores.reverse()
]
};

var plugin = {
//width: 500,
height: 200,
plugins: [
    Chartist.plugins.ctPointLabels({
        textAnchor: 'middle',
        color:'blue',
        
    }),
    
    
],low: 0,
  showArea: false,
  showPoint: true,
  fullWidth: false,
  
}

var chart = new Chartist.Line('#chart0', data, plugin);
chart.on('draw', function(data) {
  if(data.type === 'line' || data.type === 'area') {
    data.element.animate({
      d: {
        begin: 2024 * data.index,
        dur: 2000,
        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
        to: data.path.clone().stringify(),
        easing: Chartist.Svg.Easing.easeOutQuint
      }
    });
  }
});
</script>