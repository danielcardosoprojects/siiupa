<?php
include_once('../../bd/conectabd.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotos Arvore de Natal UPA 2022</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cherry+Swash:wght@700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cherry+Swash:wght@700&display=swap');

        .conteudo {
            background-color: #034f1b;
            display: flex;
            width: 200px;
            height: 200px;
            justify-content: center;
            text-align: center;
            align-items: center;

            flex-direction: column;
            background-image: url("/siiupa/administracao/fotos_natal/fundo4.fw.png");
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;
        }

        .fundo_na_foto {
            width: 120px;
            height: 120px;
            background-color: #7e121d;
            border-radius: 100%;
            /* background-image: url("/siiupa/administracao/fotos_natal/fundo.JPG"); */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;
        }


        .nome,
        .nome a {
            margin-top: 10px;
            color: #fff;
            font-family: 'Cherry Swash', cursive;
            text-decoration: none;
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
    <div class="flexbox">
        <?php
        $nomeBd = new BD;
        $sqlNome = "SELECT id, nome FROM db_rh.tb_funcionario WHERE status='ATIVO' order by nome ASC;";
        $nomes = $nomeBd->consulta($sqlNome);
        //var_dump($nomes);
        $i = 0;
        foreach ($nomes as $nome) {

            $nome_func = utf8_encode($nome->nome);
            if (file_exists("../rh/$nome->id/foto_perfil.jpg")) {
                //$foto = "../rh/$nome->id/foto_perfil.jpg";
                $foto = "papai_noel.png";
            }elseif (file_exists("../rh/$nome->id/foto_perfil")) {
                $foto = "../rh/$nome->id/foto_perfil";
            }elseif (file_exists("../rh/$nome->id/foto_perfil.png")) {
                $foto = "../rh/$nome->id/foto_perfil.png";
            } else {
                $foto = "papai_noel.png";
            }

        ?>
            <style>
                .foto_<?= $nome->id; ?> {
                    width: 125px;
                    height: 125px;
                    background-color: transparent;
                    border-radius: 100%;
                    background-image: url("<?= $foto; ?>"), url("/siiupa/administracao/fotos_natal/fundo.JPG");
                    background-position: bottom;
                    /* Center the image */
                    background-repeat: no-repeat;
                    /* Do not repeat the image */
                    background-size: auto 125px;
                }
            </style>
            <div class="conteudo">
                <div class="fundo_na_foto">
                    <div class="foto_<?= $nome->id; ?>">

                    </div>
                </div>

                <span class="nome"><a href="http://siupa.online/siiupa/?setor=adm&sub=rh&subsub=perfil&id=<?= $nome->id; ?>" target="_blank"><?= $nome_func; ?></a></span>

            </div>

        <?php
            $i++;
            if ($i == '15') {
                echo "</div>";
                echo '<div class="pagebreak"></div>';
                echo '<div class="flexbox">';
                $i = 0;
            }
        }
        ?>
    </div>

</body>

</html>