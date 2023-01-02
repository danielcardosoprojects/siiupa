<?php
function negrita($texto)
{
    echo "<b>" . $texto . "</b>";
}

function pulalinha($qtd)
{
    $i = 1;
    while ($i <= $qtd) {
        $i++;
        echo "</br>";;
    }
}

function vinculo($vinc)
{
    if ($vinc == "E") {
        $vinculoext = "EFETIVO";
        echo $vinculoext;
    } elseif ($vinc == "T") {
        $vinculoext = "TEMPORÁRIO";
        echo $vinculoext;
    } else {
        echo "Não informado.";
    }
}
class Grade
{
    function iniciagrade()
    {
        echo "<div class='container-fluid''>";
    }

    function inicialinha()
    {
        echo "<div class='row'>";
    }

    function iniciacoluna()
    {


        echo "<div class='col-sm px-1 '>";
    }

    function fimcoluna()
    {
        echo "</div>";
    }

    function fimlinha()
    {
        echo "</div>";
    }

    function fimgrade()
    {
        echo "</div>";
    }
}

class Formulario
{
    function novoForm($destino, $metodo)
    {

        echo '<form id="formeditaperfil" action="' . $destino . '" method="' . $metodo . '" enctype="multipart/form-data">';
    }

    function fimForm()
    {

        echo '</form>';
    }

    function input($nome, $dado)
    {
        if ($nome == "cpf") {
            $classeinput = "cpf";
        } else {
            $classeinput = "";
        }
        echo '<input name="' . $nome . '" class="' . $classeinput . ' form-control" type="text" placeholder="Default input" aria-label="default input example" value="' . $dado . '">';
    }

    function inputData($nome, $dado)
    {
        echo '<input type="text" name="' . $nome . '" value="' . $dado . '" class="dataInput">';
    }

    function radio($nome, $valor, $titulo, $ckd)
    {

        if ($ckd == $valor) {
            $dckd = "checked";
        } else {
            $dckd = "";
        }

        echo '<div class="form-check form-check-inline">
        <input value="' . $valor . '" class="form-check-input" type="radio" name="' . $nome . '" id="flexRadioDefault' . $valor . '" ' . $dckd . '>
        <label class="form-check-label" for="flexRadioDefault' . $valor . '">
            ' . $titulo . '
        </label>
    </div>';
    }

    function selectinicia($nome)
    {
        echo '<select class="form-select" aria-label="Default select example" name="' . $nome . '">';
    }

    function selectoption($valor, $titulo, $optatual)
    {

        if ($optatual == $valor) {
            $sckd = "selected";
        } else {
            $sckd = "";
        }
        echo '<option value="' . $valor . '" ' . $sckd . '>' . $titulo . '</option>';
    }

    function selectfim()
    {
        echo '</select>';
    }
}

class dataExibe
{
    function dataBR($dado)
    {
        if ($dado != null) {

            $DataAntiga = new DateTime($dado);


            $DataNova = $DataAntiga->format('d/m/Y');
        } else {
            $DataNova = NULL;
        }
        return $DataNova;
    }

    function dataUS($dado)
    {


       
        if ($dado == "__/__/____") {
            $rdata = new DateTime();
            $rdata = null;
            return $rdata;
        } elseif ($dado == "") {
            $rdata = new DateTime();
            $rdata = null;
            return $rdata;
        }



        $dataeeditUS = new DateTime();
        $dataeeditUS->format('Y-m-d');
        $dataeeditUS = implode('-', array_reverse(explode('/', $dado)));

       



        $dataUS = $dataeeditUS;



        return $dataUS;
    }
}
