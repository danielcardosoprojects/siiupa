<?php


function abreviaNome($nome) {
    $nome_original = $nome;
    $nome_dividido = explode(" ",$nome_original);
    $nomeFinal = "";
    var_dump($nome_dividido);

    if($nome_dividido[0]=="Maria")  {
        $nomeFinal .= "Mª ";
    } else{
        $nomeFinal .= $nome_dividido[0];
    }
    if ($nome_dividido[1] == "do" || $nome_dividido[1] == "de" || $nome_dividido[1] == "da"){
        $nomeFinal .= $nome_dividido[1]." ".$nome_dividido[2];
    } else {
        $nomeFinal .= " ".$nome_dividido[1];
    }
    return $nomeFinal;
}

echo abreviaNome("Maria do sSocorro Pereira Costa");
?>