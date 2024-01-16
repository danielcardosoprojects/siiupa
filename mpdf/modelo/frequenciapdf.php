<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência</title>

    <style>
    table,
    th,
    td {
        border: 1px solid black;


    }

    table {
        border-collapse: collapse;
        width: 100%;

    }

    th,
    .linharubrica td {
        text-align: center;

    }

    span {
        width: 103px;
    }
</style>
</head>
<body>
 

<?php
error_reporting(0);
ini_set('display_errors', 0);
//?mes=07&matricula=1777&admissao=11/02/2014&nome=Daniel Cardoso de Oliveira&cargo=Ag. Administrativo&vinculo=efetivo
$mes = $_GET['mes'];
$matricula = $_GET['matricula'];
if ($_GET['admissao'] != null) {
    $admissaoeng = $_GET['admissao'];
    $admissaosep = explode("-", $admissaoeng);
    $admissaobr = $admissaosep[2] . '/' . $admissaosep[1] . '/' . $admissaosep[0];
    $admissao = $admissaobr;
} else {
    $admissao = "";
}
$nomefunc = $_GET['nome'];
$cargo = $_GET['cargo'];
$vinculo = $_GET['vinculo'];

?>

<!-- <div style='background-color:red;position: absolute; top: 60px;  right: 60px;'><barcode code="<?php echo $nomefunc; ?>" type="QR" class="barcode" size="0.8" error="M" disableborder="1" /></div> -->
<div style="text-align:center;">
    <img src="/siiupa/mpdf/modelo/frequencia/logo_horizontal.png" height="60px"><br />
    <strong>PREFEITURA DO MUNICIPIO DE CASTANHAL <br />
        SECRETARIA MUNICIPAL DE SAÚDE<br />
        Folha de registro de comparecimento<br />
    </strong><br />
</div>
<div style='font-size:12px;font-family: "Times New Roman", Times, serif;'>
    Referência: <strong><?php echo GetNomeMes($mes); ?>-2024</strong><br />

    Matricula : <strong><?php //echo $matricula; ?></strong><span style="color:white;">____________________</span>Data de Admissão: <strong><?php //echo $admissao; ?></strong><br />
    Nome: <strong><?php echo strtoupper($nomefunc); ?></strong> <span style="color:white;">______</span>Cargo/Função: <strong><?php echo $cargo; ?></strong><br />
    Lotação : 
    <strong>UPA <?php echo $vinculo; ?></strong>
    <span style="color:white;">_____________</span>Unidade: 
    <strong>UPA</strong>

</div>
<table style="border-color:black;">

    <tbody>
        <tr>
            <th colspan="2"></th>
            <th colspan="4">DIURNO</th>


            <th colspan="4">NOTURNO</th>
        </tr>
        <tr class="linharubrica">

            <td colspan="2">DIA</td>
            <td>Entrada</td>
            <td width="20%">RÚBRICA</td>
            <td>Saída</td>
            <td width="20%">RÚBRICA</td>
            <td>Entrada</td>
            <td width="20%">RÚBRICA</td>
            <td>Saída</td>
            <td width="20%">RÚBRICA</td>



        </tr>


        <?php

        for ($linha = 1; $linha <= GetNumeroDias($mes); $linha++) {
            echo '<tr>
            <td>' . $linha . '</td>
            <td>' . DiaSemana($mes, $linha) . '</td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>';
        }
        ?>
    </tbody>
</table>
<img src="/siiupa/mpdf/modelo/frequencia/rodape.JPG"><br />


<?php
function GetNumeroDias($mes)
{
    $numero_dias = array(
        '01' => 31, '02' => 28, '03' => 31, '04' => 30, '05' => 31, '06' => 30,
        '07' => 31, '08' => 31, '09' => 30, '10' => 31, '11' => 30, '12' => 31, 
        '1' => 31, '2' => 28, '3' => 31, '4' => 30, '5' => 31, '6' => 30,
        '7' => 31, '8' => 31, '9' => 30
    );

    if (((date('Y') % 4) == 0 and (date('Y') % 100) != 0) or (date('Y') % 400) == 0) {
        $numero_dias['02'] = 29;    // altera o numero de dias de fevereiro se o ano for bissexto
        $numero_dias['2'] = 29;
    }

    return $numero_dias[$mes];
}
function GetNomeMes($mes)
{
    $meses = array(
        '01' => "JANEIRO", '02' => "FEVEREIRO", '03' => "MARÇO",
        '04' => "ABRIL",   '05' => "MAIO",      '06' => "JUNHO",
        '07' => "JULHO",   '08' => "AGOSTO",    '09' => "SETEMBRO",
        '10' => "OUTUBRO", '11' => "NOVEMBRO",  '12' => "DEZEMBRO", 
        '1' => "JANEIRO", '2' => "FEVEREIRO", '3' => "MARÇO",
        '4' => "ABRIL",   '5' => "MAIO",      '6' => "JUNHO",
        '7' => "JULHO",   '8' => "AGOSTO",    '9' => "SETEMBRO"
    );


    if ($mes >= 01 && $mes <= 12)
        return $meses[$mes];

    return "Mês deconhecido";
}
function Mostra($mes, $dia)
{

    $numero_dias = GetNumeroDias($mes);    // retorna o número de dias que tem o mês desejado
    $nome_mes = GetNomeMes($mes);
    $diacorrente = 0;

    $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, $dia, 2024), 0);    // função que descobre o dia da semana



}
function DiaSemana($mes, $dia)
{
    if ($dia == "31") {
        $diaa = 4;
    } else {
        $diaa = $dia + 1;
    }
    $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, $diaa, 2024), 0);    // função que descobre o dia da semana
    $nomesemana = array(1 => '<strong>DOMINGO</strong>', 2 => 'SEGUNDA', 3 => 'TERÇA', 4 => 'QUARTA', 5 => 'QUINTA', 6 => 'SEXTA', 0 => '<strong>SÁBADO</strong>');

    return $nomesemana[$diasemana];
}







?>
   
   </body>
</html>