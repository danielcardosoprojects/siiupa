<?php
session_start();

ob_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?PHP
    $arquivo = 'teste.xls';
    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<td colspan="5">Planilha Mensagem de Contatos</tr>';
    $html .= '</tr>';
    $html .= '</table';





    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="myfile.xls"');
    header('Cache-Control: max-age=0');

    echo $html;




    exit;

    ?>

</body>

</html>