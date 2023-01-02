<?php

@include_once("../bd/conectabd.php");





?>






<a class="navbar-brand" href="#">Produção e Estatística</a>
<a id="abreAtendimentos" href="?setor=adm&sub=producao&subsub=atendimentos" class="btn btn-outline-primary">Atendimentos</a>
<a id="abreobito" href="?setor=adm&sub=producao&subsub=obitos" class="btn btn-outline-info">Óbitos</a>
<a id="abreDiaria" href="?setor=adm&sub=producao&subsub=diaria" class="btn btn-outline-danger">Produção Diaria</a>


<div id="subsubconteudo">
    <?php
    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }


    $myvar = array(1, 2, 3);



    function pega($entrada)
    {
        if (isset($_GET[$entrada])) {
            return $_GET[$entrada];
        }
        return null;
    }



    $subsub = pega('subsub');
    console_log($subsub); // [1,2,3]


    if ($subsub == 'obitos') {
        
        @include_once('pagina_producao_obitos.php');
    }
    elseif($subsub == 'atendimentos' || $subsub ==  '') {
        
        @include_once('producao/pagina_producao_atendimentos.php');
    }
    elseif($subsub == 'diaria') {
        
        @include_once('producao/pagina_producao_diaria.php');
    }
    elseif($subsub == 'diaria_editar') {
        
        @include_once('producao/pagina_producao_diaria_editar.php');
    }
    ?>
</div>

</div>