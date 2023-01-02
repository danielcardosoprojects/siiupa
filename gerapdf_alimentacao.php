<?php 

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A4-L']);
$mpdf->margin_header = 100;
//?mes=07&matricula=1777&admissao=11/02/2014&nome=Daniel Cardoso de Oliveira&cargo=Ag. Administrativo&vinculo=efetivo



//$idescala = $_GET['id'];
$modelo =  "http://".$_SERVER['SERVER_ADDR']."/siiupa/administracao/pagina_almoco.php"; 
$html = file_get_contents($modelo);

//$mpdf->default_font = 'calibri';
$mpdf->WriteHTML($html);

$mpdf->Output("Escala.pdf", 'I');

  ?>