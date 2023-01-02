<pre>
<?php

$objs[202101]["Daniel Cardoso de Oliveira"] = Array("nome"=>"Daniel Cardoso de Oliveira","mes"=>"Janeiro");
$objs[202105][7] = "Douglas";
$objs[202105][2] = "Daniel Cardoso de Oliveira";
$objs[202103][13] = "aff";




//print_r($objs);
uksort($objs, 'strnatcmp');
//print_r($objs);



foreach ($objs as $obj){
    uksort($obj, 'strnatcmp');
  print_r($obj);
}


?>