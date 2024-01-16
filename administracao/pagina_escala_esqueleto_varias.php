<?php

@include_once('../bd/conectabd.php');

?>
<html>
<meta charset="utf-8" />

<head>
    <title>SIIUPA</title>


    <style>
        @media print {
            @page {
                size: landscape
            }
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 14px;


        }




        .table {
            width: 100%;
        }

        .table td {
            font-size: 14px;
            text-align: center;
        }

        .caption {
            font-size: 22px;
            font-family: calibri;
            border: 1px solid #000;
            width:100%;
        }

        #tabelaCabecalho {
            border: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }


        #tabelaCabecalho th {
            width: 33%;
            padding: 0;
        }

        .editafuncionario {
            text-align: left;
            min-width: 100px;
            padding: 0;


        }

        #assinatura {
            text-align: center;
            width: 100%;
        }

        #footer {
            margin-top: 5px;
            text-align: center;
            font-size: 10px;
        }

        #legendas {

            text-align: left;
            width: 33%;
            border: 1px solid #000;
            float: left;
            font-size: 10px;
            overflow: hidden;
            padding-left: 5px;
        }
        .link-oculto {
            color:#000;
            text-decoration:none;
        }
        #ferias {

            text-align: left;


            float: left;
        }

        #assinatura {
            margin-left: 5px;
            text-align: center;
            width: 33%;

            border: 0;
            float: left;
            right: 0px;
            display: table-cell;
            width: 65%;
        }

        #assinatura div {
            height: 50px;
            width: 100%;
        }

        .atualizado {
            text-align: right;
            width: 100%;

        }

        #contentescala {
            overflow: hidden;
            font-family: calibri;

        }

        .cargo_servidor {
            background-color: #DCE1E2;
            padding: .1rem .2rem;
            font-size: .5rem;
            border-radius: .2rem;
            color: #5f5f5f;
            cursor: default;
            border-color: #0d6efd;
        }

        @keyframes changeBackgroundColor {
            0% {
                background-color: #FFF;
            }

            20% {
                background-color: lightgreen;
            }

            100% {
                background-color: #FFF;
            }
        }

        #diasdasemana {
            text-align: center;
        }
    </style>

   

</head>

<body style="font-family: calibri;margin-top:0;">
    <div id="contentescala_<?=$_GET['id'];?>">
        <?php

        class data
        {
            function dia()
            {
                return date("d", strtotime($this->data));
            }
            function qtddias()
            {
                return date("t", strtotime($this->data));
            }
            function diasemana()
            {
                $ingles = date("w", strtotime($this->data));

                switch ($ingles) {
                    case 0:
                        return "D";
                    case 1:
                        return "S";
                    case 2:
                        return "T";
                    case 3:
                        return "Q";
                    case 4:
                        return "Q";
                    case 5:
                        return "S";
                    case 6:
                        return "S";
                }
                return date("w", strtotime($this->data));
            }
            function diasemanaext()
            {
                $ingles = date("w", strtotime($this->data));

                switch ($ingles) {
                    case 0:
                        return "Domingo";
                    case 1:
                        return "Segunda";
                    case 2:
                        return "Terça";
                    case 3:
                        return "Quarta";
                    case 4:
                        return "Quinta";
                    case 5:
                        return "Sexta";
                    case 6:
                        return "Sabado";
                }
                return date("w", strtotime($this->data));
            }
            function mesext($entrada)
            {
                switch ($entrada) {
                    case 1:
                        return "Janeiro";
                    case 2:
                        return "Fevereiro";
                    case 3:
                        return "MarÇo";
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
        }




        class Tabela
        {
            public function abreTabela($nomeid, $class, $id = '')
            {
                echo "<table name='$nomeid' id='$nomeid' class='$class' $id>";
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

            public function tabrelinha()
            {

                echo "<tr>";
            }

            public function tpopulalinha($entrada, $mesclalinhas = '')
            {
                if ($mesclalinhas != '') {
                    $mesclalinhas = "rowspan='$mesclalinhas'";
                }
                echo "<td $mesclalinhas>$entrada</td>";
            }

            public function tfechalinha()
            {

                echo "</tr>";
            }
        }
        //IMPRIME
        if (!isset($_GET['setor'])) {
            function pega($entrada)
            {
                if (isset($_GET[$entrada])) {
                    return $_GET[$entrada];
                }
                return null;
            }
            $setorExt = pega('setorExt');
            $mesExt = pega('mesExt');
            $anoExt = pega('anoExt');
            $tituloPagina = "Escala " . $setorExt . " - " . $mesExt . " " . $anoExt;

          
        }
        if (isset($_GET['id'])) {
            $idescala = $_GET['id'];
        } else {
        }
        $sql = "SELECT s.setor, e.* FROM u940659928_siupa.tb_escalas AS e INNER JOIN u940659928_siupa.tb_setor AS s ON (e.fk_setor = s.id) WHERE e.id=$idescala ";
        $busca = new BD;
        $resultado = $busca->consulta($sql);
        $mesext = new data;
        $mesext = $mesext->mesext($resultado[0]->mes);
        $legendaescala = $resultado[0]->legenda;
        global $atualizado;
        $atualizado = date("d\/m\/y H:s", strtotime($resultado[0]->updated_at));;



        $tab = new Tabela;

        $tab->abreTabela('tabelaCabecalho', $class = '');
        $tab->abreThead();
        $tab->fechaThead();
        $tab->tabrelinha();
        $tab->tpopulalinha('<img src="/siiupa/imagens/gov_logo_2021.png" width="200px">');
        $tab->tpopulalinha('PREFEITURA MUNICIPAL DE CASTANHAL<br>SECRETARIA MUNICIPAL DE SAÚDE-SESMA<br>COORDENAÇÃO DE URGÊNCIA E EMERGÊNCIA<br>UPA III - GOVERNADOR ALMIR GABRIEL', $mesclalinhas = '3');
        $tab->tpopulalinha('<img src="/siiupa/imagens/upa_hor_logo.JPG" height="45px">');
        $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('<img src="/siiupa/imagens/pmc_logo.PNG" height="45px">', $mesclalinhas = '4');
        $tab->tpopulalinha('');
        $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('');
        $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('');
        $tab->tfechalinha();
        $tab->tabrelinha();
        $tab->tpopulalinha('');

        $tab->tfechalinha();
        $tab->fechaTabela();

        ?>
        <table class="table caption-top  table-bordered table-hover" id="tabela_escala">
            <caption class="border-bottom-0 caption">

                <?php echo strtoupper($resultado[0]->setor . " - " . $mesext . " - " . $resultado[0]->ano); ?>
            </caption>
            <thead id="tabelathead">
                <tr>
                    <th scope="col" style="background-color:#fff;width:auto;">Escala <button id="editar_posicoes"></button></th>
                    <?php


                    $dia = "01";
                    $mes = $resultado[0]->mes;
                    $ano = $resultado[0]->ano;
                    $data = new data;
                    $data->data = "$ano-$mes-$dia";


                    $qtddias = $data->qtddias();


                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data->data = "$ano-$mes-$i";
                        $cadadia = $data->dia();
                        $fds = date("w", strtotime($data->data));

                        if ($fds == 0 || $fds == 6) {
                            $corfds = " background-color:#ccc";
                        } else {
                            $corfds = " background-color:#fff";
                        }
                        echo "<th scope='col' style='text-align:center;$corfds'>$cadadia</th>";
                    }

                    ?>
                </tr>
                <tr>
                    <th col="scope" class="table" style="background-color:#fff;width:auto;">NOME</th>
                    <?php




                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data = new data;
                        $data->data = "$ano-$mes-$i";
                        $diadasemana = $data->diasemana();
                        $fds = date("w", strtotime($data->data));
                        if ($fds == 0 || $fds == 6) {
                            $corfds = " background-color:#ccc";
                        } else {
                            $corfds = " background-color:#fff";
                        }
                        echo "<th scope='col' id='diasdasemana' style='text-align:center;$corfds'> $diadasemana</th>";
                    }

                    ?>
                </tr>
            </thead>
            <tbody>

                <?php



                $sqlserv = "SELECT c.funcao_upa, c.titulo, f.fk_cargo, f.nome, ef.* FROM u940659928_siupa.tb_escala_funcionario as ef INNER JOIN u940659928_siupa.tb_funcionario AS f ON (ef.fk_funcionario = f.id) INNER JOIN u940659928_siupa.tb_cargo AS c ON (f.fk_cargo = c.id) WHERE ef.fk_escala=$idescala order by ef.posicao ASC, f.nome ASC, ef.id ASC";
                $buscaserv = new BD;
                $resultadoserv = $buscaserv->consulta($sqlserv);
                $feriaslegenda = "";
                foreach ($resultadoserv as $serv) {

                    //prepara a legenda de ferias//

                    $sqlferiasleg = "SELECT DATE_FORMAT(ferias.datainicio, '%d/%m/%Y') as feriasinicio, DATE_FORMAT(ferias.datafim, '%d/%m/%Y') as feriasfim,ferias.* FROM u940659928_siupa.tb_ferias as ferias WHERE ferias.fk_funcionario = '$serv->fk_funcionario' AND (MONTH(ferias.datainicio) = $mes OR MONTH(ferias.datafim) = $mes) AND ferias.ref_ano = $ano";
                    $buscaferiasleg = new BD;
                    $resultadoferiasleg = $buscaferiasleg->consulta($sqlferiasleg);

                    if (count($resultadoferiasleg) == 1) {
                        $feriaslegenda = $feriaslegenda . $serv->nome . ": " . $resultadoferiasleg[0]->feriasinicio . " a " . $resultadoferiasleg[0]->feriasfim . "<br>";
                    } //fim da legenda de ferias

                    $nome = reduzirNome($serv->nome, 50);
                    $primeiroNome = reduzirNome($serv->nome, 5);





                    $nomeexemplo = "<tr id='$serv->id' class='linha_escala' data-idposicao='$serv->id'><th scope='row' class='editafuncionario table-sm $serv->id' data-idef='$serv->id' data-idf='$serv->fk_funcionario' data-nomeservidor='$nome' data-posicao='$serv->posicao'><a href='#' id='$serv->id' class='link-oculto'>".utf8_encode($nome)."</a><span class='cargo_servidor'>$serv->titulo</span></th>";

                    echo $nomeexemplo;
                    $data = "$ano-$mes-$dia";
                    $qtddias = date("t", strtotime($data));



                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data = "$ano-$mes-$i";
                        $dia = date("d", strtotime($data));
                        $diasemana = date("w", strtotime($data));

                        $idlinha = $serv->id;
                        $diasemanaext = new data;
                        $diasemanaext->data = "$ano-$mes-$i";
                        $diadasemanaext = $diasemanaext->diasemanaext();

                        if ($i == $serv->ferias_inicio) {
                            $dias = $serv->ferias_fim - $serv->ferias_inicio + 1;
                            echo "<td colspan='$dias' style='letter-spacing: .15rem;'>FÉRIAS/RECESSO REGULAMENTARES</td>";
                            $i = $i + $dias - 1;
                            continue;
                        }
                        if ($i == $serv->licenca_inicio) {
                            $diaslicenca = $serv->licenca_fim - $serv->licenca_inicio + 1;


                            echo "<td colspan='$diaslicenca' style='letter-spacing: .15rem; font-family: calibri'>" . $serv->licenca_texto . "</td>";
                            $i = $i + $diaslicenca - 1;
                            continue;
                        }

                        //pega o plantao do dia especifico
                        $plantaodia = $serv->{"d$i"};

                        //verifica se é mais de uma letra, para poder diminuir se for o caso
                        if (strlen($plantaodia) > 1) {
                            $tamanholetra = "style='font-size:11.2px;padding:0;'";
                        } else {
                            $tamanholetra = "";
                        }
                        echo "<td id='dia$i' class='dia$i editadia align-middle $idlinha' data-toggle='tooltip' data-placement='bottom' data-idlinha='$idlinha' data-dia='d$i' title='$primeiroNome | Dia $i | $diadasemanaext ' $tamanholetra>";

                        echo $plantaodia;
                        echo "</td>";
                    }
                    echo "</tr>";
                    //adicionalinha em branco se estiver marcado no pos branco
                    if ($serv->posbranco == "sim") {
                        $mescla = $qtddias + 1;
                        echo "<tr class='linhabranca'><td colspan='$mescla' style='height:15px'></td></tr>";
                    }
                }

                ?>


            </tbody>
        </table>
        <div id='footer'>

            <div id='legendas'>

                <div><strong>Legendas</strong></div>
                <div id="replacelegendas">
                    <div id='legenda' data-ide='<?php echo $idescala; ?>'>
                        <?php
                        if ($legendaescala == "") {
                            $legendaescala = "<br><br>";
                        }
                        echo utf8_encode($legendaescala); ?>

                    </div>
                </div>


                <div>
                    <div id="ferias">
                        <?php if ($feriaslegenda != "") {
                            echo "<div><strong>Férias/Recesso</strong></div>";
                            echo "<div>";
                            echo $feriaslegenda;
                            echo "</div>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <div id='assinatura'>
            <!-- <div class='atualizado'>Atualizado em: <?php echo $atualizado; ?></div> -->
            <div><br/><br/>_____________________________<br>Assinatura Responsável</div>
        </div>

    </div>
    </div>







</body>

</html>
<?php

function reduzirNome($texto, $tamanho)
{
    // Se o nome for maior que o permitido
    if (strlen($texto) > ($tamanho - 2)) {
        $texto = strip_tags($texto);

        // Pego o primeiro nome
        $palavas    = explode(' ', $texto);
        $nome       = $palavas[0];

        // Pego o ultimo nome
        $palavas    = explode(' ', $texto);
        $sobrenome  = trim($palavas[count($palavas) - 1]);

        // Vejo qual e a posicao do ultimo nome
        $ult_posicao = count($palavas) - 1;

        // Crio uma variavel para receber os nomes do meio abreviados
        $meio = '';

        // Listo todos os nomes do meios e abrevio eles
        for ($a = 1; $a < $ult_posicao; $a++) :

            // Enquanto o tamanho do nome nao atingir o limite de caracteres
            // completo com o nomes do meio abreviado
            if (strlen($nome . ' ' . $meio . ' ' . $sobrenome) <= $tamanho) :
                $meio .= ' ' . strtoupper(substr($palavas[$a], 0, 1));
            endif;
        endfor;
    } else {
        $nome       = $texto;
        $meio       = '';
        $sobrenome  = '';
    }

    return trim($nome . $meio . ' ' . $sobrenome);
}


?>
