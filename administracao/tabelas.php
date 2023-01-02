<?php





    class Tabela
    {
        public function abreTabela($nomeid, $class)
        {
            echo "<table name='$nomeid' id='$nomeid' class='$class'>";
        }
        public function fechaTabela()
        {
            echo "</tbody>";
            echo "</table>";
        }

        public function abreThead()
        {
            echo "<thead><tr>";
        }
        public function tcabecalho($entrada)
        {
            echo "<th scope='col'>$entrada</th>";
        }

        public function fechaThead()
        {
            echo "</tr></thead><tbody>";
        }

        public function tabrelinha()
        {

            echo "<tr>";
        }

        public function tpopulalinha($entrada)
        {
            echo "<td>$entrada</td>";
        }

        public function tfechalinha()
        {

            echo "</tr>";
        }
    }

?>