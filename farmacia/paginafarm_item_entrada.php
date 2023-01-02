
<?php

function pegaGet($get)
{
    if (isset($_GET[$get])) {
        return $_GET[$get];
    } else {
        return false;
    }
}
var_dump($_GET);
?>
<?php
var_dump(pegaGet('acao'));
switch (pegaGet('acao')) {
    case false:
        
        
        break;
    case 'novo':
        echo "kkk";
        break;
}

?>
<div id="subsubconteudo"></div>
<?php
$bd = new BD;
$sql = "SELECT id, nome FROM db_farmacia.tb_farmitem";
$bdResult = $bd->consulta($sql);
?>

<select id="myselect" class="js-example-basic-single" name="state">
<option title="selecione" value="selecione">Selecione</option>

<?php

foreach($bdResult as $result){
    $nomeItem = utf8_encode($result->nome);
    ?>
    
    <option value="<?=$result->id?>" data-nome="<?=$nomeItem?>"><?=$nomeItem?></option>

    <?php
}?>
  
    ...
  
</select>

<script src="/siiupa/farmacia/paginafarm_item_entrada.js"></script>