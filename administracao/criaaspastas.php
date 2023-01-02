<?php

header('Content-type: text/html; charset=utf-8');
include("../bd/conectabd.php");


$nome = $_GET['nome'];

$sqlbusca = "SELECT * FROM db_rh.tb_funcionario where nome LIKE '%$nome%' order by nome ASC";

$resultbusca = mysqli_query($conn, $sqlbusca);
$contalinha = 1;
$array = array();
                if (mysqli_num_rows($resultbusca) > 0) {
                    while ($rownomes = mysqli_fetch_assoc($resultbusca)) {

                        $array[$rownomes['id']] = array('nome'=> $rownomes['nome'], 'sexo' => $rownomes['sexo']);
                       
                       // echo "<br>";
                    }
                } else {
                    echo "0 results";
                }

                
                mysqli_close($conn);

                $jsonded = json_encode($array);
                //print $jsonded;

                $dejson = json_decode($jsonded,true);

                foreach ($dejson as $id) {
                    echo $id['nome'];
                    echo "<br>";
                }
                
                //var_dump(json_decode($jsonded));
                //var_dump(json_decode($jsonded,true));

              

                ?>
