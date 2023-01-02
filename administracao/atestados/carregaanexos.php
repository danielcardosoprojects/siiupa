<?php


$perfil_id = $_GET['perfilid'];
$path = "../rh/" . $perfil_id . "/";
$pasta = "../rh/" . $perfil_id . "/";


if (!file_exists($pasta)) {
    mkdir($path, 0700);
}

$diretorio = dir($path);

echo "<hr>Lista de Arquivos Anexados no diretório  '<strong>" . $path . "</strong>':<br />";
/*
 while ($arquivo = $diretorio->read()) {
    echo "<a target='_blank' href='administracao/rh/$perfil_id/$arquivo' class='link-primary'>" . $arquivo . "</a><br />";
}$diretorio->close();
*/
if(is_dir($path))
{
$diretorio = dir($path);

while($arquivo = $diretorio->read())
{
if($arquivo != '..' && $arquivo != '.')
{
// Cria um Arrquivo com todos os Arquivos encontrados
$arrayArquivos[date('YmdHis', filemtime($path.$arquivo))] = $path.$arquivo;

}
}

$diretorio->close();
}


// Classificar os arquivos para a Ordem Crescente
if(isset($arrayArquivos)){
krsort($arrayArquivos, SORT_STRING  );


// Mostra a listagem dos Arquivos
foreach($arrayArquivos as $valorArquivos)
{
echo "<a target='_blank' href='administracao\/$valorArquivos'>$valorArquivos</a><br />";
}
}
