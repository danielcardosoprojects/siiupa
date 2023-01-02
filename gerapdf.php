<?php 

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

//?mes=07&matricula=1777&admissao=11/02/2014&nome=Daniel Cardoso de Oliveira&cargo=Ag. Administrativo&vinculo=efetivo
$mes = $_GET['mes'];
$matricula = $_GET['matricula'];

$admissao = $_GET['admissao'];
$nomefunc = $_GET['nome'];
$cargo = $_GET['cargo'];
$vinculo = $_GET['vinculo'];

if(isset($_GET['setor'])) {
  $setor = "freq/".$_GET['setor'];
  $pasta = $GET['setor'];
} else{
  $setor = "freq";
}

if (!is_dir($setor)) {
  mkdir($setor, 0777, true);
}


$modelo = 'http://'.$_SERVER['SERVER_NAME'].'/siiupa/mpdf/modelo/frequenciapdf.php?mes='. urlencode($mes). '&matricula='. urlencode($matricula). '&admissao='. urlencode($admissao). '&nome='. urlencode($nomefunc). '&cargo=' . urlencode($cargo). '&vinculo=' . urlencode($vinculo); 

$html = file_get_contents($modelo);

//$html = "<h1>teste</h1>";

$mpdf->WriteHTML($html,0);

$mpdf->Output("$setor/Freq $nomefunc $mes .pdf", 'I');


  ?>