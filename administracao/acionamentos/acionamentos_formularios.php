<?php
@include_once('../../bd/conectabd.php');
//echo $_SERVER["REQUEST_URI"];
$acao = $_GET['acao'];

if ($acao == 'cria') {
  $idacionamento = "";
  $idfuncionario = $_GET['idfuncionario'];
  $nome = $_GET['nome'];
  $cargo = $_GET['cargo'];
  $motivoAcionamento = '0';
  $motivoAcionamentoTxt = "Selecionar Motivo do Acionamento";
  $afastamentoId = '0';
  $afastamento = "Selecionar o afastamento originário";
  $dataAcionamento = "";
  $ch1h = "";
  $ch6h = "";
  $ch12h = "";
  $ch24h = "";

  $diurno = "";
  $noturno = "";
  $plantao_24h = "";
  $acionamentoobs = "";
} elseif ($acao == 'edita') {
  $idacionamento = $_GET['idacionamento'];
  $idfuncionario = $_GET['idfuncionario'];
  $nome = $_GET['nome'];
  $cargo = $_GET['cargo'];
  $motivoAcionamento = $_GET['acionamentosId'];
  $motivoAcionamentoTxt = utf8_encode($_GET['acionamentostxt']);
  $afastamentoId = $_GET['afastamentoId'];
  if ($afastamentoId != 0) {
    $consulta_afastamento = new BD;
    $sqlConsulta_Afastamento = "SELECT f.nome as nomeAfastado, c.titulo as tituloCargo, afs.afastamento, af.id as idAfastado, af.data_inicio, af.data_fim FROM db_rh.tb_afastamento as af inner join db_rh.tb_funcionario as f on (af.fk_funcionario = f.id) inner join db_rh.tb_afastamentos as afs on (af.fk_afastamentos = afs.id) inner join db_rh.tb_cargo as c on (f.fk_cargo = c.id) WHERE af.id='$afastamentoId'";

    $resultadoConsultaAfastamento = $consulta_afastamento->consulta($sqlConsulta_Afastamento);
    ////////////////////////////////// var_dump($resultadoAfastamento);
    $resultadoAfastamento = $resultadoConsultaAfastamento[0];
    $dataInicio = new DateTime($resultadoAfastamento->data_inicio);
    $dataFim = new DateTime($resultadoAfastamento->data_fim);
    $dataInicio = $dataInicio->format('d/m/Y');
    $dataFim = $dataFim->format('d/m/Y');

    $afastamento = "🏃$resultadoAfastamento->afastamento | $resultadoAfastamento->nomeAfastado - $resultadoAfastamento->tituloCargo - $dataInicio a $dataFim";
  } elseif ($afastamentoId == '0') {
    $afastamentoId = '0';
    $afastamento = "Selecionar o afastamento originário";
  }

  $dataAcionamento = $_GET['dataacionamento'];

  $ch = $_GET['ch'];
  if ($ch == "1h") {
    $ch1h = "checked";
    $ch6h = "";
    $ch12h = "";
    $ch24h = "";
  } elseif ($ch == "6h") {
    $ch1h = "";
    $ch6h = "checked";
    $ch12h = "";
    $ch24h = "";
  } elseif ($ch == "12h") {
    $ch1h = "";
    $ch6h = "";
    $ch12h = "checked";
    $ch24h = "";
  } elseif ($ch == "24h") {
    $ch1h = "";
    $ch6h = "";
    $ch12h = "";
    $ch24h = "checked";
  } else {
    $ch1h = "";
    $ch6h = "";
    $ch12h = "";
    $ch24h = "";
  }



  $turno = $_GET['turno'];
  if ($turno == "diurno") {
    $diurno = "checked";
    $noturno = "";
    $plantao_24h = "";
  } elseif ($turno == "noturno") {
    $diurno = "";
    $noturno = "checked";
    $plantao_24h = "";
  } elseif ($turno == "plantao_24h") {
    $diurno = "";
    $noturno = "";
    $plantao_24h = "checked";
  } elseif($turno =="undefined"){
    $diurno = "checked";
    $noturno = "";
    $plantao_24h = "";
  }

  $acionamentoobs = $_GET['acionamentoobs'];
}


?>

<form>
  <h3><?php echo $nome; ?></h3>
  <input id="acao" type="hidden" value="<?php echo $acao; ?>">
  <input id="idfuncionario" name="idfuncionario" type="hidden" value="<?php echo $idfuncionario; ?>">
  <input id="idacionamento" name="idacionamento" type="hidden" value="<?php echo $idacionamento; ?>">
  <input name="nome" type="hidden" value="<?php echo $nome; ?>">
  <input name="nome" type="hidden" value="<?php echo $nome; ?>">

  <?php
  $consultaValor = new BD;
  $sqlConsultaValor = "SELECT f.fk_cargo, c.valor_plantao, c.valor_transferencia FROM db_rh.tb_funcionario as f inner join db_rh.tb_cargo as c on (f.fk_cargo = c.id) WHERE f.id=$idfuncionario";
  // echo $sqlConsultaValor;
  $resultadoConsultaValor = $consultaValor->consulta($sqlConsultaValor);
  $valorPlantao = $resultadoConsultaValor[0]->valor_plantao;
  $valorTransf = $resultadoConsultaValor[0]->valor_transferencia;
  //var_dump($resultadoConsultaValor);
  ?>
  <input id="valorPlantao" name="valorPlantao" type="hidden" value="<?php echo $valorPlantao; ?>">
  <input id="valorTransf" name="valorTransf" type="hidden" value="<?php echo $valorTransf; ?>">
  <input id="valorAcion" name="valorAcion" type="hidden" value="">

  <br><span><img src="imagens/arrow_right.svg"></span>
  <select id="idMotivo">

    <option value='<?php echo $motivoAcionamento; ?>' class='idmotivo'><?php echo utf8_decode($motivoAcionamentoTxt); ?></option>
    <?php
    // LISTA OS TIPOS DE ACIONAMENTOS
    $consulta_acionamentos = new BD;
    $sqlConsulta_Acionamentos = "SELECT ac.* FROM db_rh.tb_acionamentos as ac";
    $resultadoConsulta_Acionamentos = $consulta_acionamentos->consulta($sqlConsulta_Acionamentos);

    foreach ($resultadoConsulta_Acionamentos as $resultado_acionamentos) {
      $acionamento = utf8_encode($resultado_acionamentos->acionamento);
      $idMotivo = $resultado_acionamentos->id;
      echo "<option class='idmotivo' value='$idMotivo'>$acionamento</option>";
    }
    ?>

  </select><span class="obrigatorio">*</span>
  <hr>
  <span><img src="imagens/arrow_right.svg"><a id="selecionaAfastamento" href="#"><span id='afastamentoid' data-afastamentoid='<?php echo $afastamentoId; ?>'><?php echo $afastamento; ?></span></a></span>
  <hr>
  <label>Data:<span class="obrigatorio">*</span>
    <input id="dataAcionamento" type="date" class="form-control" value="<?php echo $dataAcionamento; ?>">
  </label>
  <hr>
  <div id="linha_horas">
    <div class="form-check" id="cHoraria">C. Horaria:<span class="obrigatorio">*</span>
      <input class="cHorariaRadio" type="radio" name="choraria" id="flexRadioDefault1" value="6h" data-mult="0.5" <?php echo $ch6h; ?>>
      <label class="form-check-label" for="flexRadioDefault1">6h</label>

      <input class="cHorariaRadio" type="radio" name="choraria" id="flexRadioDefault2" value="12h" data-mult="1" <?php echo $ch12h; ?>>
      <label class="form-check-label" for="flexRadioDefault2">12h</label>

      <input class="cHorariaRadio" type="radio" name="choraria" id="flexRadioDefault3" value="24h" data-mult="2" <?php echo $ch24h; ?>>
      <label class="form-check-label" for="flexRadioDefault3">24h</label>

      <div id="radio_1h">
        <input class="cHorariaRadio" type="radio" name="choraria" id="flexRadioDefault4" value="1h" data-mult="2" <?php echo $ch1h; ?>>
        <label class="form-check-label" for="flexRadioDefault4">1h</label>
      </div>

    </div>
  </div>

  <div class="form-check">Turno:<span class="obrigatorio">*</span>
    <input class="turnoRadio" type="radio" name="turno" id="turno1" value="diurno" <?php echo $diurno; ?>>
    <label class="form-check-label" for="turno1">Diurno</label>

    <input class="turnoRadio" type="radio" name="turno" id="turno2" value="noturno" <?php echo $noturno; ?>>
    <label class="form-check-label" for="turno2">Noturno</label>

    <input class="turnoRadio" type="radio" name="turno" id="turno3" value="plantao_24h" <?php echo $plantao_24h; ?>>
    <label class="form-check-label" for="turno3">Plantão 24h</label>
    <hr>



  </div>

  <div class="form-check">


    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">R$</span>
      </div>
      <input id="valor" class="form-control" name="valor" type="number" min="1" step="any" value="" />
    </div>


  </div>
  <hr>
  <span>Observação:</span>
  <textarea id="acionamento_obs"><?php echo $acionamentoobs; ?></textarea>
  <hr>
  <button class="form-control btn btn-primary" id="salvaAcionamento" data-acao="<?php echo $acao; ?>">Salvar</button>
</form>


<!-- Modal -->
<div class="modal" id="exampleModalCenter" tabindex="0" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Selecione o afastamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="fecharModal" data-dismiss="modal">Fechar</button>

      </div>
    </div>
  </div>
</div>

<div id="dialogAfastamento" title="Basic dialog">
</div>
<style>
  /* Important part */
  .modal-dialog {
    overflow-y: initial !important
  }

  .modal-body {
    height: 80vh;
    overflow-y: auto;
  }

  .obrigatorio {
    color: red;
    font-size: 9px;
  }

  #acionamento_obs {
    width: 100%;
  }
</style>
<script>
  if ($("#acao").val() == "edita") {
    $("#linha_horas").show();
    atualizaValor($('input.cHorariaRadio:checked').data('mult'));
    atualizaMotivo();
  } else {
    $("#linha_horas").hide();
  }
  $("#radio_1h").hide();
  $('#idMotivo').change(function() {
    atualizaMotivo();
  });

  function atualizaMotivo() {
    motivo = $("#idMotivo option:selected")[0].value;
    if (motivo == 2) {
      $("#valorAcion")[0].value = $("#valorTransf")[0].value;
      $("#linha_horas").hide();
      $("#flexRadioDefault4").prop("checked", true);
      atualizaValor(1);
    } else {
      $("#valorAcion")[0].value = $("#valorPlantao")[0].value;
      $("#linha_horas").show();
      $("#flexRadioDefault2").prop("checked", true);
      atualizaValor(1);
    }
  }
  $('.cHorariaRadio').change(function() {


    atualizaValor($(this)[0].dataset.mult);

  });

  function atualizaValor(mult) {
    valorAcion = parseFloat($("#valorAcion")[0].value);
    multiplicado = mult * valorAcion;
    $("#valor")[0].value = multiplicado;
  }

  function centralizaDialog(iddialog) {
    $(iddialog).dialog({
      position: {
        my: "center",
        at: "center",
        of: window
      }
    });
  }


  $("#selecionaAfastamento").click(function(e) {

    $("#dialogAfastamento").dialog({


      title: "Selecione o afastamento",
      open: function(event, ui) {
        $.get('administracao/acionamentos/busca_afastamentos.php', function(data) {
          $('#dialogAfastamento').html(data);
        }).done(function() {

          centralizaDialog("#dialogAfastamento");

          $('.selecionado').click(function(e) {
            console.log($(this).data('nome'));
            afastamentoId = $(this).data('afastamentoid');
            nome = $(this).data('nome');
            data_inicio = $(this).data('data_inicio');
            data_fim = $(this).data('data_fim');
            cargo = $(this).data('cargo');
            dias = $(this).data('dias');


            texto = "<span id='afastamentoid' data-afastamentoid='" + afastamentoId + "'>" + nome + ' - ' + cargo + '-' + data_inicio + ' a ' + data_fim + ' - ' + dias + " dia(s)</span>";

            $('#selecionaAfastamento').html(texto);
            $("#dialogAfastamento").dialog("close");
            centralizaDialog("#dialog");
          });
        });


      },


      modal: true,
      width: 500,
      maxHeight: 600

    });
  });
  /*
    $('#exampleModalCenter').modal('show');
    $(".close").hide();

    $('#exampleModalCenter').appendTo("body");
    $.get('administracao/acionamentos/busca_afastamentos.php', function(data) {
      $('.modal-body').html(data);
      $('.selecionado').click(function(e) {
        console.log($(this).data('nome'));
        afastamentoId = $(this).data('afastamentoid');
        nome = $(this).data('nome');
        data_inicio = $(this).data('data_inicio');
        data_fim = $(this).data('data_fim');
        cargo = $(this).data('cargo');
        dias = $(this).data('dias');


        texto = "<span id='afastamentoid' data-afastamentoid='" + afastamentoId + "'>" + nome + ' - ' + cargo + '-' + data_inicio + ' a ' + data_fim + ' - ' + dias + " dia(s)</span>";

        $('#selecionaAfastamento').html(texto);
        $("#exampleModalCenter").modal('hide');
      });

    });


        }); */

  $("#fecharModal").click(function(e) {
    $("#exampleModalCenter").modal('hide');
  });

  $('#salvaAcionamento').click(function(e) {

    e.preventDefault();
    if (acao == "cria") {

      idfuncionario = $('#idfuncionario')[0].value;
      idMotivo = $("select option:selected")[0].value;
      afastamentoid = $("#afastamentoid")[0].dataset.afastamentoid;
      dataAcionamento = $("#dataAcionamento")[0].value;
      choraria = $(".cHorariaRadio:checked")[0].value;
      turno = $(".turnoRadio:checked")[0].value;
      valor = $("#valor")[0].value;
      acionamento_obs = ($("#acionamento_obs")[0].value);
    } else {
      idacionamento = $('#idacionamento').val();
      idfuncionario = $('#idfuncionario').val();
      idMotivo = $("select option:selected").val();
      afastamentoid = $("#afastamentoid").data('afastamentoid');
      dataAcionamento = $("#dataAcionamento").val();
      choraria = $('input.cHorariaRadio:checked').val();
      turno = $(".turnoRadio:checked").val();
      valor = $("#valor").val();
      acionamento_obs = $("#acionamento_obs").val();
    }
    if (idMotivo == 0 || dataAcionamento == "" || valor == 0) {
      $.alert({
        title: 'Preenchimento Obrigatório!',
        content: 'Motivo do acionamento \n Data do Acionamento \n Valor',
      });
    } else {

      acao = $(this).data('acao');
      if (acao == "cria") {
        console.log("id funcionario:" + idfuncionario + "\n" + idMotivo + afastamentoid + dataAcionamento + choraria + turno + valor + acionamento_obs);
        linkAcionamento = "administracao/acionamentos/acionamentos_executa.php?acao=cria&idfuncionario=" + idfuncionario + "&acionamentos=" + idMotivo + "&afastamento=" + afastamentoid + "&data_acionamento=" + dataAcionamento + "&qtd_horas=" + choraria + "&turno=" + turno + "&valor=" + valor + "&acionamento_obs=" + acionamento_obs;
        console.log(linkAcionamento);
        $.get(linkAcionamento, function(data) {
          $('#dialog').html(data);
        });
      } else if (acao == "edita") {
        linkAcionamento = "administracao/acionamentos/acionamentos_executa.php?acao=edita&idacionamento="+idacionamento+"&idfuncionario=" + idfuncionario + "&acionamentos=" + idMotivo + "&afastamento=" + afastamentoid + "&data_acionamento=" + dataAcionamento + "&qtd_horas=" + choraria + "&turno=" + turno + "&valor=" + valor + "&acionamento_obs=" + acionamento_obs;
        $.get(linkAcionamento, function(data) {
          $('#dialog').html(data);
        });
        console.log(linkAcionamento);
      }
    }

  });
</script>