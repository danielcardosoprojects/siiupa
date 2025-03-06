<?php
include_once('../../bd/conectabd.php');
function abreviaNome($nome)
{
    $nome_original = $nome;
    $nome_dividido = explode(" ", $nome_original);
    $nomeFinal = "";


    if ($nome_dividido[0] == "Maria") {
        $nomeFinal .= "Mª";
    } else {
        $nomeFinal .= $nome_dividido[0];
    }
    if ($nome_dividido[1] == "do" || $nome_dividido[1] == "de" || $nome_dividido[1] == "da" || $nome_dividido[1] == "dos" || $nome_dividido[1] == "das") {
        $nomeFinal .= " " . $nome_dividido[1] . " " . $nome_dividido[2];
    } else {
        $nomeFinal .= " " . $nome_dividido[1];
    }
    return $nomeFinal;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotos Aniversariantes UPA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cherry+Swash:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+IT+Moderna:wght@100..400&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cherry+Swash:wght@700&display=swap');

        body {
            background-color: #000;
            background-image: url('fundopagina.jpg');
        }
        .star {
            margin: 100px;
            position: relative;
            display: block;
            width: 0px;
            height: 0px;
            border-right: 100px solid transparent;
            border-bottom: 70px solid #000;
            border-left: 100px solid transparent;
            transform: rotate(35deg);
        }

        .star:before {
            border-bottom: 80px solid #000;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            position: absolute;
            height: 0;
            width: 0;
            top: -45px;
            left: -65px;
            display: block;
            content: '';
            transform: rotate(-35deg);
        }

        .star:after {
            position: absolute;
            display: block;
            top: 3px;
            left: -105px;
            width: 0px;
            height: 0px;
            border-right: 100px solid transparent;
            border-bottom: 70px solid #000;
            border-left: 100px solid transparent;
            transform: rotate(-70deg);
            content: '';
        }


        .fundo_na_foto {
            width: 110;
            height: 110px;

            border-radius: 100%;
            /* background-image: url("/siiupa/administracao/fotos_aniversario/fundo.JPG"); */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;
            margin-top: 10px;
        }

        .nome {
            margin-top: 20px;
            /* background-color: #8080c0; */



        }

        .nome,
        .nome a {

            color: #fff;

            text-decoration: none;
            font-size: 20px;
            font-family: "Playwrite IT Moderna", cursive;
            font-optical-sizing: auto;

            font-style: normal;

        }
        h1 {
            color: #fff;

            text-decoration: none;
            font-size: 20px;
            font-family: "Playwrite IT Moderna", cursive;
            font-optical-sizing: auto;

            font-style: normal;
        }

        .flexbox {
            display: flex;
            flex-direction: row;
            gap: 2px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
            align-items: center;
            border-bottom: solid 2px #fff;
        }

        @media print {
            .pagebreak {
                clear: both;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>

<h1>Aniversariantes</h1>
    <div class="flexbox">
        
        <?php
        $mes = $_GET['mes'];
        $nomeBd = new BD;
        $sqlNome = "SELECT id, nome, data_nasc, sexo FROM u940659928_siupa.tb_funcionario WHERE status='ATIVO' and fk_cargo NOT IN ('20') and month(data_nasc) = '$mes' order by month(data_nasc), day(data_nasc) ASC;";
        $nomes = $nomeBd->consulta($sqlNome);
        //var_dump($nomes);
        $i = 0;
        foreach ($nomes as $nome) {
            if ($nome->data_nasc != "") {
                $data_nasc = explode("-", $nome->data_nasc, 3);
                $data_nascExec = $data_nasc[2] . "/" . $data_nasc[1];
            } else {
                $data_nascExec = "Sem data;";
            }


            $nome_func = abreviaNome(utf8_encode($nome->nome));
            if (file_exists("../rh/$nome->id/foto_perfil.jpg")) {
                //$foto = "../rh/$nome->id/foto_perfil.jpg";
                $foto = "semfoto.png";
            } elseif (file_exists("../rh/$nome->id/foto_perfil")) {
                $foto = "../rh/$nome->id/foto_perfil";
            } elseif (file_exists("../rh/$nome->id/foto_perfil.png")) {
                $foto = "../rh/$nome->id/foto_perfil.png";
            } else {
                $foto = "semfoto.png";
            }
            $fundoConteudo = "fundos4.jpg";
            if ($nome->sexo == 'M') {
                $fundoConteudo = "fundos4.jpg";
            } elseif ($nome->sexo == "F") {

                $fundoConteudo = "fundos4rosa2.jpg";
            }

        ?>
            <style>
                .foto_<?= $nome->id; ?> {
                    width: 110px;
                    height: 110px;
                    background-color: transparent;
                    border-radius: 100%;
                    background-image: url("<?= $foto; ?>")
                        /*, url("/siiupa/administracao/fotos_aniversario/fundos1.png")*/
                    ;
                    background-position: bottom;
                    /* Center the image */
                    background-repeat: no-repeat;
                    /* Do not repeat the image */
                    background-size: auto 125px;
                }

                #conteudo_<?= $nome->id; ?> {
                    background-color: #034f1b;
                    display: flex;
                    width: 250px;
                    height: 205px;
                    justify-content: center;
                    text-align: center;
                    align-items: center;

                    flex-direction: column;
                    background-image: url("/siiupa/administracao/fotos_aniversario/<?= $fundoConteudo ?>");
                    background-position: top;
                    /* Center the image */
                    background-repeat: no-repeat;
                    /* Do not repeat the image */
                    background-size: cover;
                }
            </style>
            <div id="conteudo_<?= $nome->id; ?>">
                <div class="fundo_na_foto">
                    <div class="foto_<?= $nome->id; ?>">

                    </div>
                </div>

                <span class="nome"><a href="/siiupa/?setor=adm&sub=rh&subsub=perfil&id=<?= $nome->id; ?>" target="_blank"><?= $nome_func; ?></a><br><a href="#" onclick="teste(<?= $nome->id ?>)"><?= $data_nascExec ?></a></span>



            </div>

        <?php
            $i++;
            if ($i == '10000') {
                echo "</div>";
                echo '<div class="pagebreak"></div>';
                echo '<div class="flexbox">';
                $i = 0;
            }
        }
        ?>
    </div>
    <script src="html2canvas.min.js"></script>
    <script>
        function teste(id) {
            html2canvas(document.querySelector(`#conteudo_${id}`)).then(canvas => {
                flexbox = document.getElementsByClassName("flexbox")
                flexbox[0].prepend(canvas)
            });
        }
    </script>
</body>

</html>