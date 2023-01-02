<?php

namespace Recebedados {


    //essa função verifica se exisite o GET e se existir ele o retorna, se não existir ele retorna null
    class PegaGet
    {
        public function __construct($entrada)
        {

            if (isset($_GET[$entrada])) {
                $exibe = $_GET[$entrada];
                $this->get = $exibe;
            } else {
                $exibe = null;
                $this->get = $exibe;
            }
        }
    }
}

namespace Formulario {



    class Formulario
    {
      function abreForm($nomeid, $method, $action)
      {
        echo "<form name='$nomeid' id='$nomeid' method='$method' action='$action'>";
      }
      function fechaForm()
      {
        echo "</form>";
      }
    
      function input($label, $tipo, $nomeid, $valor)
      {
    
        echo "<label>$label <input type='$tipo' name='$nomeid' id='$nomeid' value='$valor'></label>";
      }
    
      function abreSelect($nomeid, $class = "")
      {
       
        echo "<select name='$nomeid' id='$nomeid' class='$class'>";
      }
      function option($valor, $texto)
      {
        echo "<option value='$valor'>$texto</option>";
      }
      function fechaSelect()
      {
        echo "</select>";
      }
    
    
    
    
      function pula($entrada)
      {
        for ($i = 1; $i <= $entrada; $i++) {
          echo "</br>";
        }
      }
    }
}

namespace Tabela {



    class Tabela
    {
        public function abreTabela($nomeid, $class = "")
        {
            echo "<table name='$nomeid' id='$nomeid' class='$class'>";
        }
        public function fechaTabela()
        {
            echo "</tbody>";
            echo "</table>";
        }

        public function abreThead(){
            echo "<thead><tr>";
            
        }
        public function tcabecalho($entrada){
            echo "<th scope='col'>$entrada</th>";
        }

        public function fechaThead(){
            echo "</tr></thead><tbody>";
            
        }

        public function tabrelinha (){

            echo "<tr>";
        }
        
        public function tpopulalinha($entrada){
            echo "<td>$entrada</td>";
        }

        public function tfechalinha (){

            echo "</tr>";
        }


        
    }
}
