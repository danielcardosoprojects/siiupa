<?php
require '../../vendor/autoload.php'; // Carregar a biblioteca PDFParser

use Smalot\PdfParser\Parser;

function extract_patient_data($pdf_path) {
    $parser = new Parser();
    $pdf = $parser->parseFile($pdf_path);
    $text = $pdf->getText();

    // Converter o texto para UTF-8 para evitar problemas com caracteres especiais
    $text = mb_convert_encoding($text, 'UTF-8', 'auto');

    // Extração dos dados (ajuste a lógica de acordo com o formato do PDF)
    $nome = find_between($text, 'Paciente:', 'Nasc.');
    $nascimento = find_between($text, 'Nasc.:', 'Origem');
    $sexo = find_between($text, 'Sexo:', 'Solicitante');
    $data_atendimento = find_between($text, 'Data Atend.:', 'Pág');
    $numero_pedido = find_between($text, 'Pedido:', 'Sexo');
    $solicitante = find_between($text, 'Solicitante:', 'Data Atend.');

    return [
        'Nome' => trim($nome),
        'Data de Nascimento' => trim($nascimento),
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
