<?php

include("../../bd/conectabd.php");

?>
<style>
    @import url('css/font_MontSerrat.css');

    .bg-grey {
        background-color: lightgrey !important;
    }

    table p {
        font-weight: bold;

    }

    table {
           font-family: 'Montserrat', sans-serif;
        border-collapse: separate;
        border-radius: 10px;
        border-spacing: 8px 8px;
    }

    table td {
        background-color: white;
        border-radius: 10px;
    }

    .box_cima_branco {
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        margin-top:10px;
    }
    .box_cima_preto {
        color: #000;
        font-family: 'Montserrat', sans-serif;
        margin-top:10px;
    }


    

    #chart0 .ct-chart-line .ct-series-a .ct-line {
        /* Set the colour of this series line */
        stroke: #312782;
        /* Control the thikness of your lines */
        stroke-width: 5px;
        /* Create a dashed line with a pattern */

    }

    #chart0 .ct-chart-line .ct-series-a .ct-point {
        /* Set the colour of this series line */
        stroke: #ED1C24;
        /* Control the thikness of your lines */

        /* Create a dashed line with a pattern */

    }

    #chart0 .ct-chart-line .ct-series-a .ct-label {
        /* Set the colour of this series line */
        stroke: black;
        /* Control the thikness of your lines */
        font-size: large;
        /* Create a dashed line with a pattern */

    }

    .ct-series-a .ct-slice-pie {
        /* fill of the pie slieces */
        fill: #049afd;

    }

    .ct-series-b .ct-slice-pie {
        /* fill of the pie slieces */
        fill: red;

    }

    .ct-series-c .ct-slice-pie {
        /* fill of the pie slieces */
        fill: yellow;

    }

    .ct-series-d .ct-slice-pie {
        /* fill of the pie slieces */
        fill: green;

    }
</style>
<?php
$query = "SELECT mes_abrev, `TOTAL.ATEND_GERAL`, urgencia, ano, `TOTAL.ACIDTRANSITO.MOTO`, `TOTAL.ACIDTRANSITO`, `CONSULTA_MEDICO`, `IMOBILIZACAO`, `OBSERVACAO`, `COM_CLASSIFICACAO` FROM db_producao.producao_ambulatorial where /*ano in ('2021') OR */ ano in('2022') order by data ASC";




?>
<script>
    var rotulos = [];
    var valores = [];
    var acidTransitoMoto = [];
    var acidTransitoMotoVal = [];
    var consultaMedico = [];
    var consultaMedicoVal = [];
    <?php
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($mes_abrev, $atend_geral, $urgencia, $ano, $acidTransitoMoto, $acidTransitoTotal, $consulta_medico, $imobilizacao, $observacao, $classificacao);
        while ($stmt->fetch()) {
            $atendGeralVal = $atendGeralVal + $atend_geral;
            $urgenciaVal = $urgenciaVal + $urgencia;
            $consultaMedicoTotal += intval($consulta_medico);
            $imobilizacaoTotal += intval($imobilizacao);
            $observacaoTotal += intval($observacao);
            $producaoMedico += intval($consulta_medico) + intval($imobilizacao) + intval($observacao);

            $classificacaoTotal +=intval($classificacao);
            

            echo "rotulos.push('$mes_abrev $ano');";
            echo "valores.push('$atend_geral');";

            //consulta medico
            echo "consultaMedico.push('$mes_abrev $ano');";
            echo "consultaMedicoVal.push('$consulta_medico');";

            //acidentes de transito
            echo "acidTransitoMoto.push('$mes_abrev $ano');";
            echo "acidTransitoMotoVal.push('$acidTransitoMoto');";
            $acidTransitoMotoVal[$mes_abrev . " " . $ano] = $acidTransitoMoto;

            $acidTransitoTotalVal = $acidTransitoTotalVal + $acidTransitoTotal;
        }
        $stmt->close();
    }
    ?>
</script>
<h1>DASHBOARD</h1>

<div class="bg-grey" style="border-radius: 10px;">
    <table class="text-center bg-grey ">
        <thead>
            <tr>


            </tr>

        </thead>
        <tbody>
            <tr>
                <td class="bg-success box_cima_branco">
                    <p>ATENDIMENTOS MÉDICOS</p>
                    <h2><strong><?=milhar($producaoMedico);?></strong> <small>(<?=round((intval($producaoMedico)/121500)*100,1);?>%)</small></h2>
                    <h4> Meta: 121.500</h4>
                    
                </td>
                <td class="box_cima_branco" style="background-color:#ff292d">
                    <p>CLASSIFICAÇÃO DE RISCO</p>
                    <h2><strong><?=milhar($classificacaoTotal);?></strong> <small>(<?=round((intval($classificacaoTotal)/121500)*100,1);?>%)</small></h2>
                    <h4>Meta: 121.500</h4>
                    
                </td>
                <td class="bg-warning box_cima_preto">
                    <p>ACIDENTES DE TRÂNSITO</p>
                    <h4><?php echo milhar($acidTransitoTotalVal); ?></h3>
                    <span>MOTO: 6565 | CARRO: 7455 </span>
                </td>

                <td class="bg-info box_cima_preto">
                    <p>ÓBITOS</p>
                    <h4>254</h3>
                </td>


            </tr>
            <tr>
                <td class="" colspan="4">
                    <p>
                    <h4>Consulta - Médicos</h4>
                    </p>
                    <h6 class="card-subtitle mb-2 text-muted">Mensal</h6>
                    <div class="ct-chart" id="chart0"></div>
                </td>
            </tr>
            <tr>
                <td class="">
                    <p>Atendimento mensal</p>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <div class="ct-chart" id="chart1"></div>
                </td>
                <td class="w-50">
                    <p>Atendimento mensal2</p>
                    <div class="ct-chart" id="chart2"></div>
                </td>
                <td class="w-100" colspan="2">
                    <p>Classificação de Risco</p>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <div class="ct-chart " id="chart3"></div>
                    <input type="hidden" value="25" id="class_risco_vermelho">
                    <input type="hidden" value="25" id="class_risco_amarelo">
                    <input type="hidden" value="25" id="class_risco_verde">
                    <input type="hidden" value="25" id="class_risco_azul">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>Atendimento mensal</p>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <div class="ct-chart " id="chart4"></div>
                </td>
                <td colspan="3">
                    <img src="imagens/chart_example3.jpg">
                </td>
            </tr>

        </tbody>
    </table>
</div>

<script>
    var data = {

        // A labels array that can contain any sort of values

        labels: consultaMedico,
        // Our series array that contains series objects or in this case series data arrays
        series: [
            consultaMedicoVal
        ]
    };

    var plugin = {
        //width: 500,
        height: 200,
        plugins: [
            Chartist.plugins.ctPointLabels({
                textAnchor: 'middle'
            })
        ]
    }

    new Chartist.Line('#chart0', data, plugin);
    var data = {

        // A labels array that can contain any sort of values

        labels: [2019, 2020, 2021, 2022],
        series: [
            [5, 2, 8, 3]
        ]
    };

    // As options we currently only set a static size of 300x200 px. We can also omit this and use aspect ratio containers
    // as you saw in the previous example
    var options = {
        width: 300,
        height: 200,

    };




    // Create a new line chart object where as first parameter we pass in a selector
    // that is resolving to our chart container element. The Second parameter
    // is the actual data object. As a third parameter we pass in our custom options.

    new Chartist.Line('#chart1', data, options);


    new Chartist.Bar('#chart2', {
        labels: [2019, 2020, 2021, 2022],
        series: [
            [5, 2, 8, 3]
        ]
    }, plugin);

    //chart 3
    var cRisco = {
        vermelho: parseInt($("#class_risco_vermelho")[0].value),
        amarelo: parseInt($("#class_risco_amarelo")[0].value),
        verde: parseInt($("#class_risco_verde")[0].value),
        azul: parseInt($("#class_risco_azul")[0].value),

    }
    var data = {

        series: [cRisco.azul, cRisco.vermelho, cRisco.amarelo, cRisco.verde]
    };

    var sum = function(a, b) {
        return a + b
    };

    new Chartist.Pie('#chart3', data, {
        labelInterpolationFnc: function(value) {
            return Math.round(value / data.series.reduce(sum) * 100) + '%';
        }
    }, options);


    //chart4

    new Chartist.Bar('#chart4', {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        series: [
            [800000, 1200000, 1400000, 1300000],
            [200000, 400000, 500000, 3000000],
            [100000, 200000, 400000, 600000]
        ]
    }, {

        stackBars: true,
        axisY: {
            labelInterpolationFnc: function(value) {
                return (value / 1000) + 'k';
            }
        }
    }).on('draw', function(data) {
        if (data.type === 'bar') {
            data.element.attr({
                style: 'stroke-width: 30px'
            });
        }
    });
</script>
<?php
function milhar($numero) {
    $nombre_format_francais = number_format($numero, -3,',','.');
                        return $nombre_format_francais;
}
?>