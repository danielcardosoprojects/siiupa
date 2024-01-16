<?php
include('classes\functionsphp.php');
include('classes\bd.class.php');
include('bd\conectabd.php');

use Formulario\Formulario;
use Recebedados\PegaGet;
use Tabela\Tabela;

$arroz = new PegaGet('id');


echo $arroz->get;

$form = new Formulario;
$form->pula(1);
$form->abreForm('formulario', 'GET', '?');
$form->input('Teste: ', 'text', 'teste', $arroz->get);
$form->pula(2);


$form->abreSelect('Cidade');
$form->option('13', 'Castanhal');
$form->option('14', 'Belém');
$form->option('15', 'Inhangapi');
$form->option('16', 'Marituba');
$form->fechaSelect();

$form->pula(4);
$form->input('', 'submit', 'btenvia', 'Enviar');

$form->fechaForm();

$form->pula(4);

$tabela = new Tabela();


$query = "SELECT nome, id  FROM u940659928_siupa.tb_funcionario";

$tabela->abreTabela('tabelafunc', 'table  table-bordered  border-primary');
$tabela->abreThead();
$tabela->tcabecalho('id');
$tabela->tcabecalho('nome');
$tabela->fechaThead();

if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($nome, $id);

    while ($stmt->fetch()) {
        $tabela->tabrelinha();
        $tabela->tpopulalinha($nome);
        $tabela->tfechalinha();
    }
    $stmt->close();
}


$tabela->fechaTabela();
?>