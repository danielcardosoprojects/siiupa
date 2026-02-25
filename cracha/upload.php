<?php

$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$nomeArquivo = time() . "_" . basename($_FILES["foto"]["name"]);
$caminhoArquivo = $uploadDir . $nomeArquivo;

if (move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoArquivo)) {

    $dados = [
        "nome" => $_POST["nome"],
        "cargo" => $_POST["cargo"],
        "setor" => $_POST["setor"],
        "matricula" => $_POST["matricula"],
        "tipo_sanguineo" => $_POST["tipo_sanguineo"],
        "telefone" => $_POST["telefone"],
        "foto" => $caminhoArquivo
    ];

    $apiUrl = "https://siupa.com.br/siiupa/api/api.php/records/tb_cracha";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

    $response = curl_exec($ch);
    curl_close($ch);

    echo "Cadastro enviado com sucesso!";
} else {
    echo "Erro ao fazer upload da imagem.";
}
?>