<?php
// Remove tudo que não for número do CPF
$cpf = preg_replace('/\D/', '', $_GET['cpf'] ?? '');

// Se tiver 11 dígitos, aplica a máscara 000.000.000-00
if (strlen($cpf) === 11) {
    $cpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

// Escapa os demais dados para evitar injeção de HTML (XSS)
$nome  = htmlspecialchars($_GET['nome']  ?? '', ENT_QUOTES, 'UTF-8');
$cargo = htmlspecialchars($_GET['cargo'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Declaração de Plantão</title>
</head>
<body>
<div style="text-align:center;width:100%">
<img src="../imagens/documentos/cabecalho_2026.PNG">
<br>
<br>
<br>
<br>
<br>
<h1>D E C L A R A Ç Ã O</h1>
<br>
<br>

<p style="text-indent: 10em;text-align:justify;font-size:20px; margin:0 50px;">Declaro, respeitosamente, à essa seção eleitoral que o(a) servidor(a) <strong><?php echo $nome . ", " . $cargo . ", CPF: " . $cpf; ?></strong>,  encontra-se em <strong>plantão de 12 horas diurno</strong> nesta Unidade de Pronto Atendimento, na área de urgência/emergência, necessitando de atendimento agilizado para retornar ao seu posto de trabalho, nesta data de 04 de outubro de 2026.</p>
<br>
<br>
<p style="text-align:right; font-size:20px; margin-right:50px;">Castanhal(PA), 04 de outubro de 2026.</p>

<br>
<br><br>
<br>

<p>____________________________________</br>
Assinatura Responsável - UPA</p>

<p style="width:100%;bottom:0px;position:fixed;background-color:#fff;border-top: solid 2px #ccc;color:dimgray"></hr>UPA 3 24HS: BR 316, KM 65, S/N, Esquina Com Rua Raimundo Nonato Vasconcelos 
Castanhal-PA
</p>

</div>
<script>
    window.addEventListener('load', function () {
        var img = document.querySelector('img');

        function imprimir() {
            setTimeout(function () {
                window.print();
            }, 800);
        }

        if (img && img.decode) {
            img.decode().then(imprimir).catch(imprimir);
        } else {
            imprimir();
        }
    });
</script>
</body>
</html>