<?php
require '../../vendor/autoload.php'; // Carregar a biblioteca PDFParser

use Smalot\PdfParser\Parser;

function extract_patient_data($pdf_path) {
    $parser = new Parser();
    $pdf = $parser->parseFile($pdf_path);
    $text = $pdf->getText();

    // Extração dos dados (ajuste a lógica de acordo com o formato do PDF)
    $nome = find_between($text, 'Paciente:', 'Nasc.');
    $nascimento = find_between($text, 'Nasc.:', 'Origem');
    $cpf = find_between($text, 'CPF:','Idade');
    $sexo = find_between($text, 'Sexo:', 'Solicitante');
    $data_atendimento = find_between($text, 'Data Atend.:', 'Pág');
    $numero_pedido = find_between($text, 'Pedido:', 'Sexo');
    $solicitante = find_between($text, 'Solicitante:', 'Data Atend.');
    var_dump($cpf);
    return [
        'Nome' => trim($nome),
        'Data de Nascimento' => trim($nascimento),
        'CPF' => trim($cpf),
        'Sexo' => trim($sexo),
        'Data de Atendimento' => trim($data_atendimento),
        'Número do Pedido' => trim($numero_pedido),
        'Solicitante' => trim($solicitante),
    ];
}

function find_between($text, $start, $end) {
    $str = explode($start, $text);
    if (isset($str[1])) {
        $str = explode($end, $str[1]);
        return $str[0];
    }
    return '';
}

function process_pdfs($pdf_files) {
    $data = [];
    foreach ($pdf_files['tmp_name'] as $index => $tmp_name) {
        $patient_data = extract_patient_data($tmp_name);
        $data[] = $patient_data;
    }
    return $data;
}

function save_to_csv($data, $csv_file) {
    var_dump($data);
    $file = fopen($csv_file, 'w');
    fputcsv($file, array_keys($data[0]));

    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    fclose($file);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf_files = $_FILES['pdf_files'];
    $data = process_pdfs($pdf_files);

    // Salva os dados em um arquivo CSV
    $csv_file = 'dados_pacientes.csv';
    save_to_csv($data, $csv_file);

    echo 'Dados extraídos e salvos em ' . $csv_file;
}
?>

<!-- HTML para upload de múltiplos PDFs -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de PDFs</title>
</head>
<body>
    <h1>Upload de PDFs</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="pdf_files[]" multiple>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
