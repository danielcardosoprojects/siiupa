<?php

include("../bd/conectabd.php");

if (!isset($_GET['acao'])) {


?>


    <a href="/siiupa/farmacia/item/novo" onclick='itemCarrega(this, event)' id="cadastrarItem" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px">Cadastrar novo item</a>

    <?php

} 