<?php
header('Content-type: text/html; charset=utf-8');
include_once('../../bd/conectabd.php');

$buscanome = 'bruno'; //preg_replace('/[^[:alnum:]_]/', '',$nome);
$bdaddservidor = new BD;
$sqladdservidor = "SELECT c.titulo, f.* FROM db_rh.tb_funcionario as f INNER JOIN db_rh.tb_cargo as c ON (f.fk_cargo = c.id) WHERE f.fk_cargo = '20' and status='ATIVO' ORDER BY f.nome ASC";
$resultadoaddservidor = $bdaddservidor->consulta($sqladdservidor);



?>
<!DOCTYPE html>

<?php
foreach ($resultadoaddservidor as $addservidor) {
    //echo "$addservidor->nome $addservidor->titulo $addservidor->conselho_n $addservidor->sexo<br>";
    $nome = $addservidor->nome;
    $cargo = $addservidor->titulo;
    $conselho_n = $addservidor->conselho_n;
    if ($addservidor->sexo == 'F') {
        $genero = "a";
        $gerundio = "a";
    } else {
        $genero = "o";
        $gerundio = "";
    }
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Declaração de Prestador de Serviço</title>
        <style>
            body {
                font-family: 'Times New Roman', Times, serif;
                font-size: 18px;
            }

            .titulo {
                width: 100%;
                font-weight: bold;
                text-align: center;

            }

            .corpo {
                padding: 50px;
            }

            .texto {
                text-indent: 100px;
                text-align: justify;
            }

            .data {
                text-align: right;
            }

            .assinatura {
                text-align: center;
            }

            .nome {
                text-transform: uppercase;
            }

            @media print {
                .pagebreak {
                    page-break-before: always;
                }

                /* page-break-after works, as well */
            }
        </style>
    </head>

    <body>
        <div><img src="/siiupa/imagens/documentos/cabeçalho_2022.fw.png"></div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="corpo">
            <div class="titulo">DECLARAÇÃO</div><br>

            <div class="texto">
                <?php
                echo "Declaro para os devidos fins que $genero servidor$gerundio da Secretaria de Saúde <strong class='nome'>$nome</strong>, CRM-PA Nº $conselho_n, é prestador$gerundio de serviço como médic$genero de Urgência e Emergência nesta Unidade de Pronto Atendimento.";
                ?>
                <br>
                <br>
                <br>
                Sem mais no momento.
            </div>
            <br><br><br>
            <div class="data">Castanhal-PA, 10 de março de 2022.</div>




            <br><br><br>
            <div class="assinatura">
                ____________________________________<BR>
                Responsável
            </div>

        </div>
    </body>

    </html>
<?php

    echo '<div class="pagebreak"> </div>';
}
?>