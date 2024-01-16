<?php

$servername = "localhost";
$database = "u940659928_siupa";
$username = "u940659928_siupa";
$password = "4jHd@myhRDEBL@7";
// Create connection

global $conn;
$conn = mysqli_connect($servername, $username, $password, $database);
mysqli_set_charset($conn, "utf8");
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
if (!mysqli_set_charset($conn, 'utf8')) {
   printf('Error ao usar utf8: %s', mysqli_error($conexao));
   exit;
}



//alterar aqui
class BD
{
   var $servername = "localhost";
   var $database = "u940659928_siupa";
   var $username = "u940659928_siupa";
   var $password = "4jHd@myhRDEBL@7";
   function conecta()
   {
      $bd = new PDO("mysql:host=$this->servername;dbname=$this->database", "$this->username", "$this->password");
      return $bd;
   }
   function consulta($sql) //consulta e retorna o resultado em objetado para utilizar no foreach
   {

      $bd = new PDO("mysql:host=$this->servername;dbname=$this->database", "$this->username", "$this->password");




      $busca = $bd->prepare($sql);

      $busca->execute();
      $resultado = $busca->fetchAll(PDO::FETCH_OBJ);

      return $resultado;

      //$sql = "SELECT * FROM u940659928_siupa.tb_escalas";
      //$busca = new BD;
      //$resultado = $busca->consulta($sql);
      //echo "<pre>";foreach($resultado as $escala){
      //     echo $escala->mes;
      //   }
   }
   function consultaArray($sql) //consulta e retorna o resultado em objetado para utilizar no foreach
   {

      $bd = new PDO("mysql:host=$this->servername;dbname=$this->database", "$this->username", "$this->password");


      $busca = $bd->prepare($sql);

      $busca->execute();
      $resultado = $busca->fetchAll(PDO::FETCH_ASSOC);

      return $resultado;

      //$sql = "SELECT * FROM u940659928_siupa.tb_escalas";
      //$busca = new BD;
      //$resultado = $busca->consulta($sql);
      //echo "<pre>";foreach($resultado as $escala){
      //     echo $escala->mes;
      //   }
   }
   function consultaJSON($sql) //consulta e retorna o resultado em objetado para utilizar no foreach
   {

      $bd = new PDO("mysql:host=$this->servername;dbname=$this->database", "$this->username", "$this->password");


      

      
      $conJSON = new BD;

      $retornoJSON = "";
      $retornoJSON .= "{";
         foreach ($conJSON->consulta($sql) as $key1 => $teste) {
             
            $retornoJSON .=  "'$key1':{";
             foreach ($teste as $key => $valor) {
               $retornoJSON .=  "'$key':'$valor',";
             }
             $retornoJSON .=  "},";
         }
         $retornoJSON .=  "}";

      //$resultado = $busca->fetchAll(PDO::FETCH_OBJ);
      
      return $retornoJSON;

      //$sql = "SELECT * FROM u940659928_siupa.tb_escalas";
      //$busca = new BD;
      //$resultado = $busca->consulta($sql);
      //echo "<pre>";foreach($resultado as $escala){
      //     echo $escala->mes;
      //   }
   }
   function insere($sql)
   {
      $bd = new PDO("mysql:host=$this->servername;dbname=$this->database", "$this->username", "$this->password");

      $busca = $bd->prepare($sql);

      $busca->execute();
   }
   function deleta($sql)
   {
      $bd = new PDO("mysql:host=$this->servername;dbname=$this->database", "$this->username", "$this->password");

      $busca = $bd->prepare($sql);

      $busca->execute();
   }
   //PARA INSERIR OU UPDATE É
   //$busca = new BD;
   //$sql = "INSERT INTO u940659928_siupa.tb_escalas (fk_setor,ano,mes,status) VALUES (?,?,?,?)";
   //$sql = "UPDATE u940659928_siupa.tb_escalas SET fk_setor=?,ano=?,mes=?,status=? WHERE id=4";

   //$busca = $busca->conecta();
   //$insere = $busca->prepare($sql);
   //$insere->execute(array('4','2021',rand(2,300),'R'));
   //
   //p
   //$busca = $busca->conecta();
   //$insere = $busca->prepare($sql);
   //$insere->execute(array('4','2021','10','R'));
}



//echo "Connected successfully";
//mysqli_close($conn);

/*

$sql = "SELECT * FROM tb_setor";
         $result = mysqli_query($conn, $sql);

         if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               echo "SETOR: " . $row["setor"]. $row["id"]. "<br>";
            }
         } else {
            echo "0 results";
         }
         mysqli_close($conn);
         */
