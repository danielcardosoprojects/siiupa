<?php
header('Content-type: text/html; charset=utf-8');

include_once('../../bd/conectabd.php');
$busca = new BD;

$id = $_GET['id'];
$campo = $_GET['campo'];
$valor = $_GET['valor'];

if ($campo == 'vinculo') {


    $vinculos = array(
        'TEMPORÁRIO',
        'EFETIVO',
        'PRESTADOR',
        'TERCEIRIZADO',
        'INTERMITENTE',
        'CEDIDO',
        'COMISSIONADO-TEMP',
        'COMISSIONADO-EFET',
        'INDEFINIDO'
    );
    echo "
    <select name='edit$campo' id='edit$campo'>";

    foreach ($vinculos as $vinculo) {
        if ($valor == $vinculo) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        echo "<option value='$vinculo' $selected>$vinculo</option>";
    }




    echo "</select>
    <button value='Alterar' id='btn$campo'>Alterar</button>
    ";
} elseif ($campo == 'CNES') {
    echo "
    <select name='edit$campo' id='edit$campo'>
        <option value='$valor'>$valor</option>
        <option value='SOLICITADO'>SOLICITADO</option>
        <option value='INCLUIDO'>INCLUIDO</option>
        
    </select>
    <button value='Alterar' id='btn$campo'>Alterar</button>
    ";
} elseif ($campo == 'conselho_tipo') {

    $conselhos = array(
        'COREN-PA',
        'CRM-PA',
        'CRTR-PA',
        'CRF-PA',
        'CRESS-PA',
        'CRO-PA'
    );
    echo "<select name='edit$campo' id='edit$campo'>";
    $selecinou;
    foreach ($conselhos as $conselho) {
        if ($valor == $conselho) {
            $selected = "selected";
            $selecinou = $selecinou+1;
        } else {
            $selected = "";
        }
        echo "<option value='$conselho' $selected>$conselho</option>";
    }
    if($selecinou==0){$selected='selected';}

    echo "<option value='' $selected>NENHUM</option>
        
    </select>
    <button value='Alterar' id='btn$campo'>Alterar</button>
    ";
} elseif ($campo == 'fk_cargo') {

    echo "
    <select name='edit$campo' id='edit$campo' class='form-control'>";
    $sqlcargos = "SELECT  * FROM tb_cargo order by descricao ASC";
    $resultcargos = mysqli_query($conn, $sqlcargos);
    if (mysqli_num_rows($resultcargos) > 0) {


        while ($rowcargo = mysqli_fetch_assoc($resultcargos)) {

            if (isset($valor)) {
                if ($valor == $rowcargo['descricao']) {


                    $selected = "selected";
                } else {

                    $selected = "";
                }
            } else {
                $selected = "";
            }

?>
            <option value="<?php echo $rowcargo['id']; ?>" <?php echo $selected; ?>> <?php echo $rowcargo['descricao']; ?></option>



        <?php
        }
    }



    echo "</select>
    <button value='Alterar' id='btn$campo'>Alterar</button>
    ";
} elseif ($campo == 'fk_setor') {

    echo "
    <select name='edit$campo' id='edit$campo' class='form-control'>";
    $sqlsetor = "SELECT  * FROM tb_setor order by setor ASC";
    $resultsetor = mysqli_query($conn, $sqlsetor);
    if (mysqli_num_rows($resultsetor) > 0) {


        while ($setor = mysqli_fetch_assoc($resultsetor)) {

            if (isset($valor)) {
                if ($valor == $setor['setor']) {


                    $selected = "selected";
                } else {

                    $selected = "";
                }
            } else {
                $selected = "";
            }

        ?>
            <option value="<?php echo $setor['id']; ?>" <?php echo $selected; ?>> <?php echo $setor['setor'] . ' - ' . $setor['categoria']; ?></option>



<?php
        }
    }



    echo "</select>
    <button value='Alterar' id='btn$campo'>Alterar</button>
    ";
} elseif ($campo == 'sexo') {
    if ($valor == 'F') {
        $selectedfem = 'selected';
        $selectedmasc = '';
    } elseif ($valor == 'M') {
        $selectedfem = '';
        $selectedmasc = 'selected';
    } else {
        $selectedfem = '';
        $selectedmasc = '';
    }
    echo "
    <select id='edit$campo' name='edit$campo'>
    <option value='F' $selectedfem>Feminino</option>
    <option value='M' $selectedmasc>Masculino</option>
    </select>
    
    
   
    <button value='Alterar' id='btn$campo'>Alterar</button>
    ";
}
