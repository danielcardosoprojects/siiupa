 <?php
 error_reporting(0);
 $hostbd = "localhost";
$dbname="db_pacientes"; 
$usuario="root"; 
$password="";



//1º passo – Conecta ao servidor MySQL 
if(!($conectaobd = mysqli_connect($hostbd,$usuario,$password)))
{
   echo "Não foi possível estabelecer
uma conexão com o gerenciador MySQL. Favor 1Contactar o Administrador. ";
   exit;
} else {

}
//2º passo – Seleciona o Banco de Dados 
if(!($con=mysqli_select_db($conectaobd,$dbname))) { 
   echo "Não foi possível estabelecer
uma conexão com o gerenciador MySQL. Favor 2Contactar o Administrador. ";
   exit; 
} 

/* 
Esta função executa um comando SQL no banco de dados MySQL
$id – Ponteiro da Conexão 
$sql – Cláusula SQL a executar 
$erro – Especifica se a função exibe ou não(0=não, 1=sim)

$res – Resposta 
*/ 
function mysqlexecuta($conectaobd,$sql,$erro = 1) { 
    if(empty($sql) OR !($conectaobd)) 
       return 0; //Erro na conexão ou no comando SQL    
   if (!($res = @mysqli_query($sql,$conectaobd) or die(mysqli_error($sql)))) {

      if($erro) 
        echo "Ocorreu
um erro na execução do Comando SQL no banco de dados. Favor
Contactar o Administrador. ";
      exit;
   } 
    return $res; 
 }
 /* Modo de usar
  $sql = "SELECT * FROM tb_clientes";
  $sql = "INSERT INTO cadastro (nome) VALUES('Gus')"; 
  $res = mysqlexecuta($conectaobd,$sql);

//Exibe as linhas encontradas na consulta 
	while ($row = mysql_fetch_array($res)) {
	echo $row['codigo'];
    echo $row['nome'];
    echo $row['endereco'];
    echo $row['cidade'];
    echo $row['estado'];
	}

 
*/
 
