<?php


include_once('bd/conectabd.php');


?>

<script>
    $(function() {
        $('#submit').click(function() {
            $('#form_cria_perfil').submit();
        });

        $('#form_cria_perfil').on('submit', function(e) { //use on if jQuery 1.7+
            e.preventDefault(); //prevent form from submitting
            var data = $("#form_cria_perfil").serializeArray();
            var link_string = '';
            function teste(item){
                
                link_string = link_string + '&' + item.name + '=' + item.value;
            }
            data.forEach(teste);
            


            console.log(data[0].value); //use the console for debugging, F12 in Chrome, not alerts
            link_criar_perfil = 'administracao/perfil/cria_perfil.php?v=1' + link_string;
         
            //id = ' + idfunc + ' & campo = ' + campo + ' & valor = ' + valorinput;
            $.get(link_criar_perfil, function(data) {

                id_criado = data.toString();
                link_perfil_criado = '?setor=adm&sub=rh&subsub=perfil&id='+id_criado;
                window.location.href =link_perfil_criado;
                
                

            });
        });
    });
</script>
<?php
echo "<div id='area_criar'>";
echo "<form class='form-control required' id='form_cria_perfil'>";
echo "Nome:<input type='text' name='nome' class='form-control required'><br><br>";

$sqlcargos = "SELECT  * FROM u940659928_siupa.tb_cargo order by descricao ASC";
$resultcargos = mysqli_query($conn, $sqlcargos);
if (mysqli_num_rows($resultcargos) > 0) {
    echo "<label class=''>Cargo/Função:<select id='buscafunc' name='fk_cargo' class='buscafunc form-control floatleft' required>
                        <option value='undefined'>TODOS</option>";
    while ($rowcargo = mysqli_fetch_assoc($resultcargos)) {

        if (isset($_GET["func"])) {
            if ($_GET["func"] == $rowcargo['id']) {


                $selected = "selected";
            } else {

                $selected = "";
            }
        } else {
            $selected = "";
        }




        //echo $row['descricao'];
?>
        <option value="<?php echo $rowcargo['id']; ?>" <?php echo $selected; ?>> <?php echo $rowcargo['descricao']; ?></option>



<?php

    }
    echo "</select></label><br><br>";
}
$bdsetores = new BD;
$sqlsetores  = "SELECT  * FROM u940659928_siupa.tb_setor GROUP BY setor ASC";
$resultadosetores  = $bdsetores->consulta($sqlsetores);
echo "<label>Setor:<select id='setorbusca' name='fk_setor' class='setorbusca form-control'>
        <option value='undefined'>TODOS</option>";
foreach ($resultadosetores as $setores) {
    if (isset($_GET["buscasetor"])) {
        if ($_GET["buscasetor"] == $setores->setor) {


            $selected = "selected";
        } else {

            $selected = "";
        }
    } else {
        $selected = "";
    }
    echo "<option value='$setores->id' $selected>$setores->setor </option>";
}
echo "</select></label><br><br>";



echo "Vinculo:<select name='vinculo' class='form-control'>";
echo "<option value='TEMPORARIO'>TEMPORARIO</option>";
echo "<option value='EFETIVO'>EFETIVO</option>";
echo "<option value='PRESTADOR'>PRESTADOR</option>";
echo "<option value='INTERMITENTE'>INTERMITENTE</option>";
echo "<option value='TERCEIRIZADO'>TERCEIRIZADO</option>";
echo "<option value='COMISSIONADO-TEMP'>COMISSIONADO-TEMP</option>";
echo "<option value='COMISSIONADO-EFET'>COMISSIONADO-EFET</option>";
echo "</select>";
echo "<br><br>";







echo "Status:<select name='status'  class='form-control'>";
echo "<option value='ATIVO'>ATIVO</option>";
echo "<option value='INATIVO'>INATIVO</option>";
echo "<option value='INTERMITENTE'>INTERMITENTE</option>";
echo "<option value='TERCEIRIZADO'>TERCEIRIZADO</option>";
echo "</select>";
echo "<br><br>";
echo "  <input type='submit' value='Submit' name='submit' class='submit' id='submit' /><br><br>";
echo "</form>";
echo "</div>";

?>