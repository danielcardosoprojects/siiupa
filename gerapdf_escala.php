<?php 

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A4-L', 'setAutoTopMargin' => false,'margin_top' => 5]);
$mpdf->margin_header = 100;
//?mes=07&matricula=1777&admissao=11/02/2014&nome=Daniel Cardoso de Oliveira&cargo=Ag. Administrativo&vinculo=efetivo



$idescala = $_GET['id'];
$modelo = 'http://'.$_SERVER['SERVER_ADDR'].'/siiupa/administracao/pagina_escala_esqueleto.php?id='.$idescala; 
$html = file_get_contents($modelo);
$mpdf->default_font = 'calibri';
$mpdf->WriteHTML($html);

function pega($entrada)
    {
        if (isset($_GET[$entrada])) {
            return $_GET[$entrada];
        }
        return null;
    }
    $setorExt = pega('setorExt');
    $mesExt= pega('mesExt');
    $anoExt= pega('anoExt');

$mpdf->Output("$setorExt Escala.pdf", 'I');

  ?>