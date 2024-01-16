<!DOCTYPE html>
<?php
header('Content-Type: text/html; charset=UTF-8');
function mesext($entrada)
{
    switch ($entrada) {
        case 1:
            return "Janeiro";
        case 2:
            return "Fevereiro";
        case 3:
            return "MarÇo";
        case 4:
            return "Abril";
        case 5:
            return "Maio";
        case 6:
            return "Junho";
        case 7:
            return "Julho";
        case 8:
            return "Agosto";
        case 9:
            return "Setembro";
        case 10:
            return "Outubro";
        case 11:
            return "Novembro";
        case 12:
            return "Dezembro";
    }
    return $entrada;
}
?>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="/siiupa/js/jquery-3.6.0.js"></script>
    <!-- <link rel="stylesheet" href="/siiupa/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css"> -->
    <style>
        @media print {
            @page {
                size: landscape
            }

            .break {
                display: block;
                page-break-before: always;
                page-break-inside: avoid;
            }

            .noprint {
                visibility: hidden;
            }
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 14px;


        }




        .table {
            width: 100%;
        }

        .table td {
            font-size: 14px;
            text-align: center;
        }

        .caption {
            font-size: 22px;
            font-family: calibri;
            border: 1px solid #000;
            width: 100%;
        }

        #tabelaCabecalho {
            border: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }


        #tabelaCabecalho th {
            width: 33%;
            padding: 0;
        }

        .editafuncionario {
            text-align: left;
            min-width: 100px;
            padding: 0;


        }

        #assinatura {
            text-align: center;
            width: 100%;
        }

        #footer {
            margin-top: 5px;
            text-align: center;
            font-size: 10px;
        }

        #legendas {

            text-align: left;
            width: 33%;
            border: 1px solid #000;
            float: left;
            font-size: 10px;
            overflow: hidden;
            padding-left: 5px;
        }

        .link-oculto {
            color: #000;
            text-decoration: none;
        }

        #ferias {

            text-align: left;


            float: left;
        }

        #assinatura {
            margin-left: 5px;
            text-align: center;
            width: 33%;

            border: 0;
            float: left;
            right: 0px;
            display: table-cell;
            width: 65%;
        }

        #assinatura div {
            height: 50px;
            width: 100%;
        }

        .atualizado {
            text-align: right;
            width: 100%;

        }

        #contentescala {
            overflow: hidden;
            font-family: calibri;

        }

        .cargo_servidor {
            background-color: #DCE1E2;
            padding: .1rem .2rem;
            font-size: .5rem;
            border-radius: .2rem;
            color: #5f5f5f;
            cursor: default;
            border-color: #0d6efd;
        }

        @keyframes changeBackgroundColor {
            0% {
                background-color: #FFF;
            }

            20% {
                background-color: lightgreen;
            }

            100% {
                background-color: #FFF;
            }
        }

        #diasdasemana {
            text-align: center;
        }

        #menu_setores {
            display: flex;
            flex-direction: row;
            gap: 5px;
            align-items: center;
            justify-content: center;
            clear: both;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            flex-wrap: wrap;
        }

        #imprimir {
            background-color:skyblue;
            text-align:center;
            cursor: pointer;
            position: fixed;
            top: 0;
            right: 0;
            width: 100px;
        }

        .btn {
            background-color: #2596be;
            padding: 10px;
            color: #000;
            text-decoration: none;
        }

        .btn2 {
            background-color: chartreuse;
            padding: 10px;
            color: #000;
            text-decoration: none;
        }
    </style>
</head>

<body style="font-family: calibri;margin-top:0;">
    <div id="imprimir" class="noprint">Imprimir</div>
    <div id="menu_setores" class="noprint">


        <?php
        @include_once('../bd/conectabd.php');
        $mes = $_GET['mes'];
        $mesext = mesext($mes);
        $ano = $_GET['ano'];

        $escalas = new BD;
        $sqlmes =  "SELECT s.setor, e.* FROM u940659928_siupa.tb_escalas AS e INNER JOIN u940659928_siupa.tb_setor as s ON(e.fk_setor = s.id) WHERE e.mes=$mes AND e.ano=$ano ORDER BY s.setor ASC";
        $resultadomes = $escalas->consulta($sqlmes);

        foreach ($resultadomes as $escalasmes) {
            // var_dump($escalasmes);
            echo "<a href='#' class='add btn' data-id='$escalasmes->id' data-setor='$escalasmes->setor' data-mesext='$mesext' data-ano='$ano'>$escalasmes->setor</a>";
        }

        ?>

    </div>


    <script>
        lista = [];
        $(".add").click((e) => {
            e.preventDefault();
            let esc = $(e.target);
            let id = esc.data('id');
            let setor = esc.data('setor');
            let mesext = esc.data('mesext');
            let ano = esc.data('ano');
            if (!lista[id]) {
                let link_escala = `/siiupa/administracao/pagina_escala_esqueleto_varias.php?id=${id}&setorExt=${setor}&mesExt=${mesext}&anoExt=${ano}`;
                $.get(link_escala, (data) => {
                    
                    $("body").append(data);
                    // if(lista.length > 0){
                    $("body").append(`<div class='break' id='break_${id}'></div>`);
                    // }

                    $("html, body").animate({
                        scrollTop: $('html, body').get(0).scrollHeight
                    }, 2000);

                    esc.removeClass('btn');
                    esc.addClass('btn2');
                    esc.removeClass('add');
                    esc.addClass(`remove`);
                    lista[id] = true;

                });
            } else {
                let cel = $(`#contentescala_${id}`);
                //Remove a quebra de pagina também
                let break_cel = $(`#break_${id}`);
                cel.remove();
                break_cel.remove();
                lista.splice(id);
                esc.removeClass('btn2');
                esc.addClass('btn');
            }


        });
        $("#imprimir").click((e)=>{
            e.preventDefault();
            window.print();
        });
    </script>
</body>

</html>