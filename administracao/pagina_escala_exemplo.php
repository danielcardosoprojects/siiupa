<?php
include_once('../bd/conectabd.php');


?>
<html>

<head>
    <title>SIIUPA</title>


    <style>
        body {
            color: blue;
        }
        .table,
        .table th,
        .table td {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: small;
        }

        .table {
            width: 100%;
            
        }

        .table td {
            font-size: 11px;
            text-align: center;
        }

        caption {
            font-size: 22px;
            font-family: calibri;
            border: 1px solid #000;
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
        }

        #ferias {
            margin-left: 5px;
            text-align: left;
            width: 30%;
            border: 1px solid #000;
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
            color: blue;

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

    <script>
        $(function() {
            


            $(".editadia").dblclick(function() {
                //var altera = prompt("Digite", $(this).text());
                input = "<input type='text' value='" + $(this).text() + "' id='editando' size='1'>";
                $(this).html(input);
                $("#editando").focus();
                $("#editando").select();
                var editadia = $(this);
                $("#editando").on('focusout', function(e) {
                  
                    var valor = $("#editando").val();
                    //alert('You pressed enter!'+valor);
                    var idlinha = editadia.data('idlinha');
                    var dia = editadia.data('dia');
                    editadia.load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {
                        
                        editadia.css("animation", "changeBackgroundColor 2s 1");
                    });
                });




            });
            $(".editadia").on('keypress', function(e) {
                if (e.which == 13) {
                    var valor = $("#editando").val();
                    //alert('You pressed enter!'+valor);
                    var idlinha = $(this).data('idlinha');
                    var dia = $(this).data('dia');
                    $(this).load('administracao/escalas/atualiza.php?id=' + idlinha + '&dia=' + dia + '&valor=' + valor, function() {
                        
                        $(this).css("animation", "changeBackgroundColor 2s 1");
                    });


                }
            });



        });
    </script>

</head>

<body style="font-family: calibri;">
    <div id="contentescala">
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
        <table class="table caption-top table-sm table-bordered table-hover" id="tabela_escala">
            <caption>
                ADMINISTRACAO - OUTUBRO/2021
            </caption>
            <thead>
                <tr>
                    <th scope="col">Escala</th>
                    <?php


                    $dia = "01";
                    $mes = "10";
                    $ano = "2021";
                    $data = new data;
                    $data->data = "$ano-$mes-$dia";


                    $qtddias = $data->qtddias();


                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data->data = "$ano-$mes-$i";
                        $cadadia = $data->dia();
                        echo "<th scope='col'>$cadadia</th>";
                    }

                    ?>
                </tr>
                <tr>
                    <th col="scope">NOME</th>
                    <?php




                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data = new data;
                        $data->data = "$ano-$mes-$i";
                        $diadasemana = $data->diasemana();
                        echo "<th scope='col' id='diasdasemana'>$diadasemana</th>";
                    }

                    ?>
                </tr>
            </thead>
            <tbody>

                <?php



                $sqlserv = "SELECT f.nome, ef.* FROM u940659928_siupa.tb_escala_funcionario as ef INNER JOIN u940659928_siupa.tb_funcionario AS f ON (ef.fk_funcionario = f.id)";
                $buscaserv = new BD;
                $resultadoserv = $buscaserv->consulta($sqlserv);

                foreach ($resultadoserv as $serv) {
                    $nome = reduzirNome($serv->nome, 30);
                    $nomeexemplo = '<tr><th scope="row">' . $nome . '</th>';

                    echo $nomeexemplo;
                    $data = "$ano-$mes-$dia";
                    $qtddias = date("t", strtotime($data));



                    for ($i = 1; $i <= $qtddias; $i++) {
                        $data = "$ano-$mes-$i";
                        $dia = date("d", strtotime($data));
                        $diasemana = date("w", strtotime($data));
                        $teste = (object) array("o$i" => "teste$i");
                        $idlinha = $serv->id;

                        echo "<td id='dia$i' class='editadia' data-idlinha='$idlinha' data-dia='d$i'>";
                        echo $serv->{"d$i"};
                        echo "</td>";
                    }
                    echo "</tr>";
                }

                ?>


            </tbody>
        </table>
        <div id='footer'>
            <div id='legendas'>
                <div><strong>Legendas</strong></div>
                <div>"D" = PLANTÃO DIURNO DE 8H<br>
                    "F¹" = FERIADO<br>
                    "F²" = FACULTADO<br>

                    CARGA HORÁRIA DE NÍVEL MÉDIO: 144 HORAS/MÊS<br>

                </div>

                <div><strong>Férias</strong></div>
                <div>"D" = PLANTÃO DIURNO | "N" = PLANTÃO NOTURNO <br>
                    "P" = PLANTÃO 24h | "N¹" = ATESTADO | "N²" = ACIONAMENTO <br>
                    CARGA HORÁRIA : 96 HORAS/MÊS
                </div>
            </div>

            <div id='assinatura'>
                <div class='atualizado'>Atualizado em: 22/10/2021</div>
                <div>_____________________________<br>Assinatura Responsável</div>
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