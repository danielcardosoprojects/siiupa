<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$paginas = 0;
$setor = "";
//?mes=07&matricula=1777&admissao=11/02/2014&nome=Daniel Cardoso de Oliveira&cargo=Ag. Administrativo&vinculo=efetivo

$json = $_POST['dado'];
$array = json_decode($json);




foreach ($array as $nome => $dado) {
    $nomefunc = $nome;
   
     
        $mes = $dado->mes;
        $matricula = $dado->matricula;

        $admissao = $dado->admissao;

        $cargo = $dado->cargo;
        $vinculo = $dado->vinculo;

        $setor = $dado->setor;


    if ($paginas > 0) {
        $mpdf->AddPage();
    }
    $modelo = 'http://' . $_SERVER['SERVER_NAME'] . '/siiupa/mpdf/modelo/frequenciapdf.php?mes=' . urlencode($mes) . '&matricula=' . urlencode($matricula) . '&admissao=' . urlencode($admissao) . '&nome=' . urlencode($nomefunc) . '&cargo=' . urlencode($cargo) . '&vinculo=' . urlencode($vinculo);
    
    $html = file_get_contents($modelo);
    
    $mpdf->WriteHTML($html, 0);
    $paginas++;
}


// if (!is_dir($setor)) {
//   mkdir($setor, 0777, true);
// }
// $mpdf->Output("$setor/Freq $nomefunc $mes .pdf", 'I');

// Pasta a ser verificada
$folder = "freq/2023/$setor";

// Verifica se a pasta existe
if (!is_dir($folder)) {
    // Cria a pasta
    mkdir($folder);
    // echo "A pasta $folder foi criada com sucesso.";
} else {
    // echo "A pasta $folder já existe.";
}

$mpdf->Output("freq/2023/$setor/Freq $setor $mes .pdf", \Mpdf\Output\Destination::FILE);
