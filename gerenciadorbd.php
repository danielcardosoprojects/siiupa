<?php

include_once("conectabd.php");
 // extrai os dados do post
$nomecompleto = "lol";
 extract($_POST);
 // imprime os dados do post
   
$camposcadastra = "nomecompleto,nomedamae,idade,datadenascimento,sexo,telefone1,telefone2,telefone3,rg,cpf,cartaosus,responsavel,enderecoRua,enderecoNumero,enderecoPerimetro,enderecoBairro,municipio,tipoacompanhante,veiopor";

$cadastravalores = "'$nomecompleto','$nomedamae','$idade',str_to_date('$datadenascimento', '%d/%m/%Y'),'$sexo','$telefone1','$telefone2','$telefone3','$rg','$cpf','$cartaosus','$responsavel','$enderecoRua','$enderecoNumero','$enderecoPerimetro','$enderecoBairro','$municipio','$tipoacompanhante','$veiopor'";

$sql = "INSERT INTO u940659928_siupa.tb_cadastro ($camposcadastra) VALUES($cadastravalores)"; 
 
 if ($res = mysqlexecuta($conectaobd,$sql)) // testando se o $insert esta verdadeiro = se a inserção aconteceu
 {
  echo "Noticia inserida com sucesso!";
 }
 else
 {
  echo "Erro durante a inserção da notícia. Verifique os dados!" . mysql_error();
 }


 echo "Nome: ".$nomecompleto;
 echo "Nome da mãe".$nomedamae;
?>
 