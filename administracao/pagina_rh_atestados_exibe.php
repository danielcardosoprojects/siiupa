<?php
include_once('bd/conectabd.php');

include_once('bd/nivel.php');

$idAfastamento = $_GET['idafastamento'];
?>
<div id="box_grande">
    <?php
    $consulta_atestado = new BD;
   

    $sqlConsulta_Atestados = "SELECT afs.afastamento,afs.id as afastamento_id, A.*, f.nome, f.id as idf, c.titulo FROM u940659928_siupa.tb_afastamento as A inner join u940659928_siupa.tb_funcionario as f ON (A.fk_funcionario = f.id) inner join u940659928_siupa.tb_cargo AS c on (f.fk_cargo = c.id) inner join u940659928_siupa.tb_afastamentos as afs on (A.fk_afastamentos = afs.id) WHERE A.id = '$idAfastamento' order by A.id DESC";
    $resultadoConsulta_Atestados = $consulta_atestado->consulta($sqlConsulta_Atestados);

    foreach ($resultadoConsulta_Atestados as $resultado_atestado) {

        $firstDate  = new DateTime($resultado_atestado->data_inicio);
        $secondDate = new DateTime($resultado_atestado->data_fim);
        $intvl = $firstDate->diff($secondDate);
        $totalDias = $intvl->format('%R%a') + 1;
        $dias = $intvl->d;
        $dias = $dias + 1;
        //verifica se está ativo ou nome
        $dt_atual = date("Y-m-d");
        $hoje = new DateTime($dt_atual);

        //compara o formato completo da data se é maior ou igual a hoje
        if ($secondDate->format('c') >= $hoje->format('c')) {
            $classe_css = "ativo";
            $texto_etiqueta = "Ativo";
        } else {
            $classe_css = "inativo";
            $texto_etiqueta = "Inativo";
        }


        $afastamentoUtf8 = utf8_encode($resultado_atestado->afastamento);

        echo "<div class='box_atestados table-hover ' style='width:auto;' name='$resultado_atestado->nome'><span class='$classe_css' > $texto_etiqueta</span> <span class='tipo_afastamento'>  $afastamentoUtf8 </span><span class='nome_funcionario'>";
        echo "<a href='?setor=adm&sub=rh&subsub=perfil&id=$resultado_atestado->idf'> ";

        echo $resultado_atestado->nome . "</a></span> - <span class='nome_cargo'>" . utf8_encode($resultado_atestado->titulo) . "</span> - ";
        echo "De: <input class='data' type='date' value='" . $resultado_atestado->data_inicio . "' readonly> Até: <input class='data'  type='date' value='" . $resultado_atestado->data_fim . "' readonly><br>";

        echo "(" . $totalDias . " dias) | " . $intvl->y . " ano(s), " . $intvl->m . " mes(es) e " . $dias . " dia(s)";
        echo "<br>";
        $afastamentoObs = utf8_decode($resultado_atestado->afastamento_obs);
        echo "📝 $afastamentoObs";
        echo "<br>";


        echo "<button class='bt_editaAtestado form-control' style='width:100px;float:left;margin-right:5px;' data-idatestado='$resultado_atestado->id' data-idfuncionario='$resultado_atestado->fk_funcionario' data-data_inicio='$resultado_atestado->data_inicio' data-data_fim='$resultado_atestado->data_fim' data-afastamento='$resultado_atestado->afastamento' data-afastamentoid='$resultado_atestado->afastamento_id' data-nome='$resultado_atestado->nome' data-cargo='$resultado_atestado->titulo' data-afastamento_obs='$resultado_atestado->afastamento_obs'>Editar</button>";
        echo "<button class='bt_anexaDocumentos form-control' style='width:200px;float:left;' data-idatestado='$resultado_atestado->id' data-idfuncionario='$resultado_atestado->fk_funcionario' data-data_inicio='$resultado_atestado->data_inicio' data-data_fim='$resultado_atestado->data_fim' data-afastamento='$resultado_atestado->afastamento' data-afastamentoid='$resultado_atestado->afastamento_id' data-nome='$resultado_atestado->nome' data-cargo='$resultado_atestado->titulo'>Anexar documento</button>";








        echo "</div>";
        echo "<p class='limpaFloat'></p>";
        //echo "<hr>";
    }
    ?>

</div>
<style>
    #box_grande {
        display: flex;
        flex-direction: row;
        width: 100%;
        background-color: #0d6efd;
        gap: 6px;
        flex-wrap: wrap;

        justify-content: space-around;
        padding: 4px;
    }
    .ativo {
        background-color: green;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .inativo {
        background-color: #ffc133;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #ff6433;
        cursor: default;
        border-color: #0d6efd;
    }

    .tipo_afastamento {
        background-color: #a934ff;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;
        font-weight: bold;
    }

    .nome_funcionario {
        font-size: 18px;
        font-weight: bold;
    }

    .nome_cargo {
        font-size: 18px;
    }

    .data {
        box-shadow: 0 0 0 0;
        border: 0 none;
        outline: 0;
        color: #000;
    }

    .box_atestados {
        border: 1px solid #ccc;
        padding: 2px;
        background-color: #fff;
        overflow: hidden;
        height: auto;
    }

    .box_atestados:hover {
        background-color: #e2e7e8;
    }

    .limpaFloat {
        clear: both;
    }

    #carregaAnexos {
        font-size: 12px;
    }
</style>