<?php

@include("../bd/conectabd.php"); ?>
<script type="text/javascript" src="./js/script.js"></script>
<style type="text/css">
    .valor {
        background-color: green;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;

    }

    .coluna_valor {
        width: 120px;
        text-align: right;
    }

    .colunaHorasAcionamento {
        width: 120px;
        text-align: center;

    }

    .afastamento {
        background-color: #a934ff;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;
        font-weight: bold;

    }

    .tabelaAcionamento {
        border: solid 1px #000;
    }

    .tabelaAcionamento th {
        text-align: center;
    }

    textarea {
        width: 100%;
    }

    #obs_cel {
        text-align: right;
    }

    .accordionescalas div {
        font-size: 10px;
    }
</style>
<script>
    $(document).ready(function() {
    $("#obs_textarea").jqte();
    });
    $(function() {
        

        $(".accordionescalas").accordion({
            collapsible: true,
            active: 2
        });

        $(".accordionFaltas").accordion({
            collapsible: true,
            active: 0
        });

        $(".accordionAcionamentos").accordion({
            collapsible: true,
            active: 0
        });





        total_ext6 = $(".ext_6").val() * $(".ext_6").data("valor");
        total_ext12 = $(".ext_12").val() * $(".ext_12").data("valor");
        total_ext24 = $(".ext_24").val() * $(".ext_24").data("valor");
        total_transferencia = $(".transferencia").val() * $(".transferencia").data("valor");
        total_fixos = $(".fixos").val();
        total_ext6 = parseInt(total_ext6) || 0;
        total_ext12 = parseInt(total_ext12) || 0;
        total_ext24 = parseInt(total_ext24) || 0;
        total_transferencia = parseInt(total_transferencia) || 0;
        total_fixos = parseInt(total_fixos) || 0;

        valor_total = parseInt(total_ext6) + parseInt(total_ext12) + parseInt(total_ext24) + parseInt(total_transferencia) + parseInt(total_fixos);
        $(".valor_total").val(valor_total);
        $(".att_valor").keyup(function() {

            total_ext6 = $(".ext_6").val() * $(".ext_6").data("valor");
            total_ext12 = $(".ext_12").val() * $(".ext_12").data("valor");
            total_ext24 = $(".ext_24").val() * $(".ext_24").data("valor");
            total_transferencia = $(".transferencia").val() * $(".transferencia").data("valor");
            total_fixos = $(".fixos").val();
            total_ext6 = parseInt(total_ext6) || 0;
            total_ext12 = parseInt(total_ext12) || 0;
            total_ext24 = parseInt(total_ext24) || 0;
            total_transferencia = parseInt(total_transferencia) || 0;
            total_fixos = parseInt(total_fixos) || 0;

            valor_total = parseInt(total_ext6) + parseInt(total_ext12) + parseInt(total_ext24) + parseInt(total_transferencia) + parseInt(total_fixos);
            $(".valor_total").val(valor_total);


        });



        $("#buscaNome").submit(function() {


            var nome = $('#nome').val();
            var idfolha = $('#idfolha').val();
            var link = '?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&nome=' + nome + '&idfolha=' + idfolha;
            loadCanvas('administracao/pagina_rh_folha_adicionaservidor.php?nome=' + nome + '&idfolha=' + idfolha)
            // window.location.replace(link);
            return false;
        });
        $("#btenviar").click(function(e) {
            e.preventDefault();
            var nome = $('#nome').val();
            var idfolha = $('#idfolha').val();

            var link = '?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&nome=' + nome + '&idfolha=' + idfolha;
            
            loadCanvas('administracao/pagina_rh_folha_adicionaservidor.php?nome=' + nome + '&idfolha=' + idfolha)
            // window.location.replace(link);
            //  console.log(link);


        });

        $("#btadicionaservidor").click(function() {
            //alert();
            console.log($("#adicionaservidor").serialize());
            var link = '?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&acao=adicionar&' + $("#adicionaservidor").serialize();
            window.location.replace(link);
            console.log(link);

        });
    });
</script>
<a href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['idfolha']; ?>" id="voltarasfolhas" class="btn btn-secondary">
    <img src="imagens/icones/back.svg">
    Voltar à Folha
</a>
<?php
function MesExtenso($mes)
{
    switch ($mes) {
        case "01":
            echo "JANEIRO";
            break;
        case "02":
            echo "FEVEREIRO";
            break;
        case "03":
            echo "MARÇO";
            break;
        case "04":
            echo "ABRIL";
            break;
        case "05":
            echo "MAIO";
            break;
        case "06":
            echo "JUNHO";
            break;
        case "07":
            echo "JULHO";
            break;
        case "08":
            echo "AGOSTO";
            break;
        case "09":
            echo "SETEMBRO";
            break;
        case "10":
            echo "OUTUBRO";
            break;
        case "11":
            echo "NOVEMBRO";
            break;
        case "12":
            echo "DEZEMBRO";
            break;
    }
}
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == 'adicionar') {
        echo "entrou em adicionar";



        $idservidor = $_GET['idservidor'];
        $idfolha = $_GET['idfolha'];
        $adc_not = $_GET['adc_not'];
        $ext_6 = $_GET['ext_6'];
        $ext_12 = $_GET['ext_12'];
        $ext_24 = $_GET['ext_24'];
        $acionamento = $_GET['acionamento'];
        $transferencia = $_GET['transferencia'];
        $fixos = $_GET['fixos'];
        $valor_total = $_GET['valor_total'];
        $obs = $_GET['obs'];

        $query = "INSERT INTO db_rh.tb_folha (fk_funcionario, fk_folhas, adc_not, ext_6, ext_12, ext_24, acionamento, transferencia, fixos, obs) VALUES ('$idservidor' ,  '$idfolha' , '$adc_not' , '$ext_6' , '$ext_12' , '$ext_24' ,  '$acionamento' , '$transferencia','$fixos' , '$obs')";
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            echo "New record created successfully. Last inserted ID is: " . $last_id;
            print("<script>alert('Sucesso!');
        var link2 = '?setor=adm&sub=rh&subsub=rhfolhaexibe&id=$idfolha';
        window.location.replace(link2);
        
        </script>");
        } else {
            echo "Opa! Algo deu errado! \n Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } elseif ($acao == 'altera') {
        echo "entrou em alterar";

        $acao = "<input type='hidden' name='acao' value='altera'>";
        $idlinhafolha = $_GET['idlinhafolha'];
        $idservidor = $_GET['idservidor'];
        $idfolha = $_GET['idfolha'];
        $adc_not = $_GET['adc_not'];
        $ext_6 = $_GET['ext_6'];
        $ext_12 = $_GET['ext_12'];
        $ext_24 = $_GET['ext_24'];
        $acionamento = $_GET['acionamento'];
        $transferencia = $_GET['transferencia'];
        $fixos = $_GET['fixos'];
        $valor_total = $_GET['valor_total'];
        $obs = $_GET['obs'];

        $query = "INSERT INTO db_rh.tb_folha (fk_funcionario, fk_folhas, adc_not, ext_6, ext_12, ext_24, acionamento, transferencia, fixos, obs) VALUES ('$idservidor' ,  '$idfolha' , '$adc_not' , '$ext_6' , '$ext_12' , '$ext_24' ,  '$acionamento', '$transferencia' , '$fixos' , '$obs')";
        $query = "UPDATE `db_rh`.`tb_folha` SET `adc_not` = '$adc_not', `ext_6` = '$ext_6', `ext_12` = '$ext_12', `ext_24` = '$ext_24', `acionamento` = '$acionamento', `transferencia` = '$transferencia', `fixos` = '$fixos', `obs` = '$obs' WHERE (`id` = '$idlinhafolha')";
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            echo "Alterado com sucesso. Last inserted ID is: " . $last_id;
            print("<script>alert('Sucesso!');
        var link2 = '?setor=adm&sub=rh&subsub=rhfolhaexibe&id=$idfolha';
        window.location.replace(link2);
        
        </script>");
        } else {
            echo "Opa! Algo deu errado! \n Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } elseif ($acao == 'seleciona') //AQUI RECEBEO O SERVIDOR SELECIONADO
    {
        $envia_id_linha_folha = "";


        $idselecionado = $_GET['idservidor'];
        $sqlbusca = "SELECT  f.*, f.id AS idfuncionario, c.funcao_upa, c.valor_plantao, c.valor_acionamento, c.valor_transferencia, c.id, s.setor FROM tb_funcionario AS f INNER JOIN tb_cargo AS C ON f.fk_cargo = c.id INNER JOIN tb_setor AS s ON f.fk_setor = s.id WHERE f.id='$idselecionado'";
        $resultbusca = mysqli_query($conn, $sqlbusca);
        if (mysqli_num_rows($resultbusca) > 0) {
            while ($rownomes = mysqli_fetch_assoc($resultbusca)) {
                $dados = (object) $rownomes;
                $valor_ext6 = $dados->valor_plantao / 2;
                $valor_ext12 = $dados->valor_plantao;
                $valor_ext24 = $dados->valor_plantao * 2;
                $idfolha = $_GET['idfolha'];

                if (isset($_GET['subacao'])) {
                    $subacao = $_GET['subacao'];



                    if ($subacao == 'alterar') {
                        //echo "Subacao alterar";
                        $acao = "<input type='hidden' name='acao' value='altera'>";
                        $queryalterar = "SELECT fl.id, func.nome, cargo.funcao_upa, fl.adc_not, fl.ext_6, fl.ext_12, fl.ext_24, fl.acionamento, fl.transferencia, fl.fixos, fl.obs, cargo.valor_plantao, cargo.valor_acionamento FROM db_rh.tb_folha AS fl INNER JOIN db_rh.tb_funcionario AS func ON (fl.fk_funcionario = func.id) INNER JOIN db_rh.tb_cargo AS cargo ON (func.fk_cargo = cargo.id) WHERE fl.fk_folhas = '$idfolha' AND fl.fk_funcionario = $idselecionado";
                        if ($stmtalterar = $conn->prepare($queryalterar)) {
                            $stmtalterar->execute();
                            $stmtalterar->bind_result($fl_id, $nome, $funcao_upa, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, $fixos, $obs, $valor_plantao, $valor_acionamento);
                            $acao = "<input type='hidden' name='acao' value='altera'>";
                            while ($stmtalterar->fetch()) {
                                
                                if ($adc_not == "SIM") {
                                    $marca_adc_not = "checked";
                                } else {
                                    $marca_adc_not = "";
                                }
                                $envia_id_linha_folha = "<input type='hidden' name='idlinhafolha' value='$fl_id'>";
                            }
                            $stmtalterar->close();
                        }
                    } elseif ($subacao == 'adicionar') {

                        $marca_adc_not = "";
                        $ext_6 = "";
                        $ext_12 = "";
                        $ext_24 = "";
                        $acionamento = "";
                        $transferencia = "";
                        $fixos = "";
                        $valor_total = "";
                        $obs = "";

                        $acao = "<input type='hidden' name='acao' value='adicionar'>";
                    }
                }
                //var_dump($dados);
                echo '
                <form id="adicionaservidor">
                <input type="hidden" value="' . $dados->idfuncionario . '" name="idservidor">
               <input type="hidden" value="' . $idfolha . '" name="idfolha" id="idfolha">
            <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOME</th>
                    <th scope="col">FUNÇÃO</th>
                    <th scope="col">ADC.NOT</th>
                    <th scope="col">06h</th>
                    <th scope="col">12h</th>
                    <th scope="col">24h</th>
                    <th scope="col">ACION.</th>
                    <th scope="col">TRANSF.</th>
                    <th scope="col">FIXOS</th>
                    <th scope="col">VALOR TOTAL</th>
                    
                
                    
                </tr>
                </thead>
                <tbody>
                ';
                echo "<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><span class='valor'>R$$valor_ext6,00</span></td>
                <td><span class='valor'>R$$valor_ext12,00</span></td>
                <td><span class='valor'>R$$valor_ext24,00</span></td>
                <td></td>
                <td><span class='valor'>R$$dados->valor_transferencia,00</span></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>";
                $valor_total= "";
                printf('
        
                    <tr>
                    <td>1</td>
                    <th scope="row">%s</th>
                    <td>%s</td>
                    <td><label><input type="checkbox" name="adc_not" value="SIM" %s>SIM</label></td>
                    <td><input type="text" maxlength="4" size="2" class="ext_6 att_valor" name="ext_6" data-valor="' . $valor_ext6 . '" value="%s"></td>
                    <td><input type="text" maxlength="4" size="2" class="ext_12 att_valor" name="ext_12" data-valor="' . $valor_ext12 . '" value="%s"></td>
                    <td><input type="text" maxlength="4" size="2" class="ext_24 att_valor" name="ext_24" data-valor="' . $valor_ext24 . '" value="%s"></td>
                    <td><input type="text" maxlength="4" size="2" class="acionamento" name="acionamento" data-valor="' . $dados->valor_acionamento . '" value="%s"</td>
                    <td><input type="text" maxlength="4" size="2" class="transferencia att_valor" name="transferencia" data-valor="' . $dados->valor_transferencia . '" value="%s"></td>
                    <td><input type="text" maxlength="4" size="2" class="fixos att_valor" name="fixos" value="%s"></td>
                    <td>R$ <input type="text" maxlength="5" size="5" class="valor_total" name="valor_total" value="%s" readonly></td>
                    <tr><td></td><td></td><td id="obs_cel">OBSERVAÇÃO:</td><td colspan="8"><textarea id="obs_textarea" name="obs">%s</textarea></td></tr>

                </tr>', $dados->nome, $dados->funcao_upa, $marca_adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, $fixos, $valor_total, $obs);


                //var_dump($dados);
                echo '</tbody>
                    </table>';
                echo $envia_id_linha_folha;
                echo $acao;
                $idfolha = $_GET['idfolha'];
                echo '<div style="text-align:center">
                
                <a href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=' . $idfolha . '" id="voltarasfolhas" class="btn btn-secondary">
                <img src="imagens/icones/voltar.svg" width="40px">
                <br>Cancelar
                </a>
                <a name="btadicionaservidor" id="btadicionaservidor" class="btn btn-success">
                <img src="imagens/icones/salvar.svg">
                Salvar</a></div>
                    </form><hr>';

                /////////// FALTAS INICIO








                echo '<div class="accordionFaltas">
                <h3>AFASTAMENTOS DO SERVIDOR</h3>
                <div>';
                echo "<table>";
                echo "<tbody>";

                $idservidor = $_GET['idservidor'];

                $sqlAfastamentos = "SELECT afs.afastamento,afs.id as afastamento_id, A.*, f.nome, c.titulo FROM db_rh.tb_afastamento as A inner join db_rh.tb_funcionario as f ON (A.fk_funcionario = f.id) inner join db_rh.tb_cargo as c on (f.fk_cargo = c.id) inner join db_rh.tb_afastamentos as afs on (A.fk_afastamentos = afs.id) where A.fk_funcionario = '$idservidor' order by A.data_fim DESC";
                if ($bancoAfastamentos = $conn->query($sqlAfastamentos)) {

                    while ($dadosAfastamentos = $bancoAfastamentos->fetch_object()) {
                        $espaco = " ";
                        $hifen = " - ";

                        $pulalinha = "</br>";
                        $data_inicio = new DateTime($dadosAfastamentos->data_inicio);
                        $data_fim = new DateTime($dadosAfastamentos->data_fim);
                        $periodo = $data_inicio->diff($data_fim);
                        $periodo = $periodo->days + 1;
                        $mesInicio = mes($data_inicio->format("m"));
                        $mesFim = mes($data_fim->format("m"));
                        if ($periodo == 1) {
                            $entredata = "";
                        } else {
                            $entredata = " à " . $data_fim->format("d/m/Y");
                        }
                        if ($mesInicio == $mesFim) {
                            $mesPeriodo = $mesInicio . "/" . $data_inicio->format("y");
                        } else {
                            $mesPeriodo = "$mesInicio/" . $data_inicio->format("y") . " → $mesFim/" . $data_fim->format("y");
                        }



                        echo "<tr>";
                        echo "<td><span class='valor'>$mesPeriodo</span></td><td><span class='afastamento' style='text-align:center'>$dadosAfastamentos->afastamento</span></td><td>" . $espaco . $dadosAfastamentos->nome  . $hifen . $data_inicio->format("d/m/Y") . $entredata . $hifen . $periodo . " dia(s)</td>";
                        echo "</tr>";
                    }
                    $bancoAfastamentos->close();
                }
                echo "</tbody></table>";
                echo '</div></div>';

                echo '<div class="accordionAcionamentos">
                <h3>ACIONAMENTOS DO SERVIDOR</h3>
                <div>';
                echo "<table class='table table-hover' id='tabelaAcionamento'>";
                echo "<thead>
                <th>Nome</th>
                <th>Data Acionamento</th>
                <th>CH</th>
                <th>Valor</th>
                <th>Motivo</th>
                <th>Afastamento</th>
                
                </thead>";
                echo "<tbody>";

                $consulta_acionamento = new BD;
                $sqlConsulta_Acionamento = "SELECT ac.*, f.nome, acs.acionamento FROM db_rh.tb_acionamento as ac inner join db_rh.tb_funcionario as f on (ac.fk_funcionario = f.id) inner join db_rh.tb_acionamentos as acs on(ac.fk_acionamentos = acs.id) WHERE ac.fk_funcionario = '$idservidor' ORDER BY ac.id DESC";
                $resultadoConsulta_Acionamento = $consulta_acionamento->consulta($sqlConsulta_Acionamento);

                foreach ($resultadoConsulta_Acionamento as $resultado_acionamento) {
                    echo "<tr>";
                    $fk_afastamento = $resultado_acionamento->fk_afastamento;


                    $data_acionamento = new DateTime($resultado_acionamento->data_acionamento);

                    $dataAcionamento = $data_acionamento->format('d/m/Y');

                    if ($resultado_acionamento->turno == "diurno") {
                        $turnoAcionamento = "D";
                    } elseif ($resultado_acionamento->turno == "noturno") {
                        $turnoAcionamento = "N";
                    } elseif ($resultado_acionamento->turno == "plantao_24h") {
                        $turnoAcionamento = "P";
                    }
                    echo "<td>$resultado_acionamento->nome</td><td>$dataAcionamento</td><td class='colunaHorasAcionamento'>$resultado_acionamento->qtd_horas $turnoAcionamento</td><td class='coluna_valor'>R$ $resultado_acionamento->valor,00</td><td>" . utf8_encode($resultado_acionamento->acionamento) . "</td>";
                    echo "<td>";
                    if ($resultado_acionamento->fk_afastamento != 0) {
                        $consulta_afastamento = new BD;
                        $sqlConsulta_Afastamento = "SELECT f.nome as nomeAfastado, c.titulo as tituloCargo, afs.afastamento, af.id as idAfastado, af.data_inicio, af.data_fim FROM db_rh.tb_afastamento as af inner join db_rh.tb_funcionario as f on (af.fk_funcionario = f.id) inner join db_rh.tb_afastamentos as afs on (af.fk_afastamentos = afs.id) inner join db_rh.tb_cargo as c on (f.fk_cargo = c.id) WHERE af.id='$resultado_acionamento->fk_afastamento'";

                        $resultadoConsultaAfastamento = $consulta_afastamento->consulta($sqlConsulta_Afastamento);
                        ////////////////////////////////// var_dump($resultadoAfastamento);
                        $resultadoAfastamento = $resultadoConsultaAfastamento[0];
                        $dataInicio = new DateTime($resultadoAfastamento->data_inicio);
                        $dataFim = new DateTime($resultadoAfastamento->data_fim);
                        $dataInicio = $dataInicio->format('d/m/Y');
                        $dataFim = $dataFim->format('d/m/Y');
                        echo "<span class='tipo_afastamento'>$resultadoAfastamento->afastamento</span>";
                        echo "<span> <img src='imagens/pessoa_falta.svg'><a href='#'>$resultadoAfastamento->nomeAfastado - $resultadoAfastamento->tituloCargo - $dataInicio a $dataFim</a></sp>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
                echo '</div></div>';

                /*
                if ($banco_escalas = $conn->query($query)) {

                    while ($dadosEscala = $banco_escalas->fetch_object()) {
                        
                    }
                    $banco_escalas->close();
                }



  */              //////////////// FALTAS FIM
                ////////////////// ESCALAS INICIO
                $id_servidor = $_GET['idservidor'];
                echo '<hr>';
                echo '
                <div class="accordionescalas">
                <h3>ESCALAS DO SERVIDOR</h3>
                <div>';

                echo '<table class="table table-bordered table-hover table-striped">
                <thead>';

                echo "<th>Setor</th>";
                echo "<th>Mês/Ano</th>";
                for ($i = 1; $i <= 31; $i++) {

                    echo '<th>';
                    echo $i;
                    echo '</th>';
                }
                $query = "SELECT s.setor, e.legenda as legendas, ef.d1, ef.* FROM db_rh.tb_escala_funcionario as ef inner join (db_rh.tb_escalas as e) on (fk_escala = e.id) inner join (db_rh.tb_setor as s) on (e.fk_setor = s.id) where ef.fk_funcionario = $id_servidor order by ef.id desc";

                echo '</thead><tbody>';
                if ($banco_escalas = $conn->query($query)) {

                    while ($dadosEscala = $banco_escalas->fetch_object()) {
                        echo "<tr>";
                        echo "<td>$dadosEscala->setor</td>";
                        echo "<td>" . mes($dadosEscala->mes) . "/$dadosEscala->ano</td>";
                        for ($i = 1; $i <= 31; $i++) {
                            $dia_escala = utf8_decode($dadosEscala->{"d$i"});

                            //$legendas = utf8_decode(strip_tags($dadosEscala->legendas));//Tira as tags HTML e depois codifica pra UTF

                            $legendas =  utf8_decode(preg_replace("/<\/*[a-zA-Z0-9_]+>/", " | ",  $dadosEscala->legendas));

                            echo "<td title='$legendas'>$dia_escala</td>";
                        }
                        echo "</tr>";
                    }
                    $banco_escalas->close();
                }

                echo '
                </tbody>
                </table>
                </div>
                </div>';


                ////////////////// ESCALAS FIM

                //////////////////////* FOLHAS ANTERIORES */
                echo '<hr>';
                echo '<h3>FOLHAS DE PAGAMENTO ANTERIORES:</h3>';
                echo  "<small><small>Exibindo do mais recente para o mais antigo.</small></small>";
                echo '
                    <table id="dados_folhas" class="table  table-bordered  border-dark table-sm table-hover table-striped Tabela_folha" style="font-size:12px">
                            <thead>
                              <tr>
                                <th scope="col">N#</th>
                                <th scope="col">COMPETÊNCIA</th>
                                <th scope="col">NOME</th>
                                
                                <th scope="col">FUNÇÃO</th>
                                <th scope="col">ADC.NOT</th>
                                <th scope="col">06h</th>
                                <th scope="col">12h</th>
                                <th scope="col">24h</th>
                                <th scope="col">ACION.</th>
                                <th scope="col">TRANSF.</th>
                                <th scope="col">FIXOS</th>
                                <th scope="col">VALOR TOTAL</th>
                                <th scope="col" class="col-2">OBS</th>
                               
                                
                              </tr>
                            </thead>
                            <tbody>
                            ';
                $idfolha_aberta = $idfolha;
                $query = "SELECT fls.ref_mes, fls.ref_ano, fl.fk_folhas, fl.id as id_linha, func.id,func.nome, cargo.funcao_upa, fl.adc_not, fl.ext_6, fl.ext_12, fl.ext_24, fl.acionamento, fl.transferencia, fl.fixos, fl.obs, cargo.valor_plantao, cargo.valor_acionamento, cargo.valor_transferencia FROM db_rh.tb_folha AS fl INNER JOIN db_rh.tb_funcionario AS func ON (fl.fk_funcionario = func.id) inner join db_rh.tb_folhas as fls on (fl.fk_folhas = fls.id) INNER JOIN db_rh.tb_cargo AS cargo ON (func.fk_cargo = cargo.id) WHERE fk_funcionario = '$dados->idfuncionario' ORDER BY id_linha DESC";

                if ($stmt = $conn->prepare($query)) {
                    $stmt->execute();
                    $stmt->bind_result($ref_mes, $ref_ano, $idfolha, $id_linha, $func_id, $nome, $funcao_upa, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, $fixos, $obs, $valor_plantao, $valor_acionamento, $valor_transferencia);




                    $i = 0;
                    $valor_geral = 0;
                    while ($stmt->fetch()) {
                        if ($idfolha == $idfolha_aberta) {
                            continue;
                        }
                        $i++;

                        if ($ext_6 == "") {
                            $ext_6 = 0;
                        }
                        if ($ext_12 == "") {
                            $ext_12 = 0;
                        }
                        if ($ext_24 == "") {
                            $ext_24 = 0;
                        }
                        if ($acionamento == "") {
                            $acionamento = 0;
                        }
                        $valores_exibe[$func_id] = "";
                        $transferencia = trataNaoNumericos($transferencia);
                        $fixos = trataNaoNumericos($fixos);
                        $valor_transferencia = trataNaoNumericos($valor_transferencia);
                        $ext_6 = trataNaoNumericos($ext_6);
                        $ext_12 = trataNaoNumericos($ext_12);
                        $ext_24 = trataNaoNumericos($ext_24);
                        $valor_total = ($ext_6 * ($valor_plantao / 2)) + ($ext_12 * $valor_plantao) + ($ext_24 * ($valor_plantao * 2)) + ($valor_acionamento * $acionamento) + ($valor_transferencia * $transferencia) + $fixos;
                        $link_para_alterar = "?setor=adm&sub=rh&subsub=rhfolhaexibe&id=$idfolha";


                        printf("
                                    
                                    <tr class='align-middle linha_tabela' data-idlinha='%s'>
                                    <td>%s</td>
                                    <td>%s/%s</td>
                                   
                                    <td title='%s'><a class='text-dark text-decoration-none'>%s</a></td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td  class='table-responsive-lg text-right' style='text-align:right'><i>R$</i> %s</td>
                                    <td>%s</td>
                            
                                  </tr>", $id_linha, $i, mes($ref_mes), $ref_ano, $id_linha, $nome, $funcao_upa, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, number_format($fixos, 2, ',', '.'), number_format($valor_total, 2, ',', '.'), $obs);
                        $valor_geral = $valor_geral + $valor_total;
                    }
                    $stmt->close();
                }
                echo "<tr><td colspan='11' style='text-align:right'>Total: </td><td colspan='2'>R$ $valor_geral,00</td></tr>";
                echo '</tbody>
                        </table>';




                /**************** FIM ANTERIRES */
            }
        }
    }
} else {

    $idfolha = $_GET['idfolha'];
    //BUSCA O MES E ANO DA FOLHA SOMENTE PARA O TITULO
    $querymesano = "SELECT fls.ref_mes, fls.ref_ano FROM db_rh.tb_folhas as fls WHERE fls.id=$idfolha";


    if ($stmt = $conn->prepare($querymesano)) {
        $stmt->execute();
        $stmt->bind_result($ref_mes, $ref_ano);
        while ($stmt->fetch()) {
            $mes = mes($ref_mes);
            $ano = $ref_ano;
        }
        $stmt->close();
    }
    echo "<h4>Folha de Pagamento </br>$mes/$ano</h4>";
?>

    <!-- <h1>Adicionar servidor</h1> -->

    <form action="" method="" id="buscaNome">
        <input type="hidden" value="<?php echo $_GET['idfolha']; ?>" name="idfolha" id="idfolha" action="?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor">
        <label for="nome">Nome do servidor</label>
        <br><input type="text" name="nome" id="nome" class="form-control">
        </br>

        <div class="d-flex form-control mb-3">
            <a href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['idfolha']; ?>" id="bcancela" class="btn btn-danger"">
                <img src=" imagens/icones/cancelar.svg" width="15px">
                Cancelar</a>
            <a class="btn btn-success" id="btenviar"><img src="imagens/icones/buscar.svg" width="30px"> Buscar</img></a>
            


        </div>

    </form>
    <div id="mostraservidor">
        <?php
        if (isset($_GET['nome'])) {
            $nome = $_GET['nome'];
            $where = "WHERE f.nome LIKE '%" . $nome . "%' ORDER BY f.nome ASC ";
        } else {
            $where = "WHERE status='ATIVO'";
        }
        $sqlbusca = "SELECT  f.*, f.id AS idfuncionario, c.descricao AS cargo, c.id, s.setor FROM tb_funcionario AS f INNER JOIN tb_cargo AS C ON f.fk_cargo = c.id INNER JOIN tb_setor AS s ON f.fk_setor = s.id $where  ";
        $resultbusca = mysqli_query($conn, $sqlbusca);




        echo mysqli_num_rows($resultbusca) . " resultado(s).";

        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <!-- <th scope="col">AÇÃO</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">NOME</th>
                    <th scope="col">CARGO</th>
                    <th scope="col">SETOR</th>
                    <th scope="col">VINCULO</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $contalinha = 1;
                if (mysqli_num_rows($resultbusca) > 0) {
                    while ($rownomes = mysqli_fetch_assoc($resultbusca)) {
                        $dados = (object) $rownomes;
                        $dados->idfolha = $_GET['idfolha'];


                        echo "<tr>";
                        // echo "<td><span class='material-icons'>account_circle</span></td>";
                        echo "<th scope='row'><a class='abreperfil' href='/siiupa/administracao/pagina_rh_folha_adicionaservidor.php?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&acao=seleciona&idservidor=$dados->idfuncionario&idfolha=$dados->idfolha&subacao=adicionar'>$dados->idfuncionario</a></th>";
                        echo "<td>$dados->nome  <a  class='copiarNome' data-text='$dados->nome' href='#'><i><span class='material-icons'>content_copy</span></i></a></td>";
                        echo "<td>$dados->fk_cargo - $dados->cargo</td>";
                        echo "<td>$dados->setor</td>";
                        echo "<td>$dados->vinculo</td>";
                        echo "</tr>";
                        $contalinha++;
                    }
                } else {
                    echo "0 results";
                }
                
                mysqli_close($conn);

                ?>
                <script>
                    $(".abreperfil").click(function(e){
                        e.preventDefault();
                        // console.log(this.href);
                        loadCanvas(this.href)
                    });
                </script>
            </tbody>
        </table>

    </div>

<?php
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
function trataNaoNumericos($naoNumericos)
{
    if ($naoNumericos == '' || $naoNumericos == null) {
        return 0;
    } else {
        return floatval($naoNumericos);
    }
}
?>