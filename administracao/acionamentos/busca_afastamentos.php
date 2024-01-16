<?php
header("Content-type: text/html; charset=utf-8");
?>
<div>
    <button class="form-control btn btn-outline-primary selecionado" data-idatestado="" data-idfuncionario="" data-data_inicio="" data-data_fim="" data-afastamento="" data-afastamentoid="nenhum" data-nome="Selecionar afastamento" data-cargo="" data-dias="">NENHUM</button>
    <hr>
    <?php
    include_once('../../bd/conectabd.php');
    $consulta_atestado = new BD;
    $sqlConsulta_Atestados = "SELECT afs.afastamento,afs.id as afastamento_id, A.*, f.nome, f.id as idf, c.titulo FROM u940659928_siupa.tb_afastamento as A inner join u940659928_siupa.tb_funcionario as f ON (A.fk_funcionario = f.id) inner join u940659928_siupa.tb_cargo as c on (f.fk_cargo = c.id) inner join u940659928_siupa.tb_afastamentos as afs on (A.fk_afastamentos = afs.id) order by A.id DESC";
    $resultadoConsulta_Atestados = $consulta_atestado->consulta($sqlConsulta_Atestados);

    foreach ($resultadoConsulta_Atestados as $resultado_atestado) {


        $firstDate  = new DateTime($resultado_atestado->data_inicio);
        $secondDate = new DateTime($resultado_atestado->data_fim);
        $data_inicio  = $firstDate->format('d/m/Y');
        $data_fim = $secondDate->format('d/m/Y');
        $intvl = $firstDate->diff($secondDate);
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


        echo "<div class='box_atestados table-hover ' style='width:auto;background-color:#fff;border: 1px solid #004080;'><span class='tipo_afastamento'>  $resultado_atestado->afastamento</span><span class='nome_funcionario'>";
        echo "";

        echo "<span class='nome_seleciona'>".$resultado_atestado->nome . "</span></span> - <span class='nome_cargo'>" . $resultado_atestado->titulo . "</span> - ";
        echo "<br>";
        echo "De: $data_inicio Até: $data_fim<br>";

        echo $intvl->y . " ano(s), " . $intvl->m . " mes(es) e " . $dias . " dia(s)";
        echo "<br>";

        echo "<button class='form-control btn btn-outline-primary selecionado' data-idatestado='$resultado_atestado->id' data-idfuncionario='$resultado_atestado->fk_funcionario' data-data_inicio='$data_inicio' data-data_fim='$data_fim' data-afastamento='$resultado_atestado->afastamento' data-afastamentoid='$resultado_atestado->id' data-nome='$resultado_atestado->nome' data-cargo='$resultado_atestado->titulo' data-dias='$dias'>Selecionar</button>";









        echo "</div>";
        echo "<p class='limpaFloat'></p>";
        echo "<hr>";
    }
    ?>
    <style>
        .box_atestados:hover {
            background-color: #def2ff;
        }

        .limpaFloat {
            clear: both;
        }

        .nome_seleciona {
            background-color: #def2ff;
            font-weight: bold;
        }
    </style>
    <script>
        $("#fecharModal").click(function(e) {
            $("#exampleModalCenter").modal('hide');
        });
    </script>
</div>