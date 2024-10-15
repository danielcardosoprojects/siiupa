<?php
// Verifica se o ID foi passado via query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']); // Converte o ID para um inteiro

// URL da API com o ID
$apiUrl = "https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/" . $id;

// Função para fazer a requisição à API
function getData($url) {
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Obter dados do equipamento
$equipamento = getData($apiUrl);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Equipamento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Perfil do Equipamento</h2>
    <div class="row">
        <div class="col-md-4">
            <h4>Nome: <?= htmlspecialchars($equipamento['nome']) ?></h4>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($equipamento['tipo']) ?></p>
            <p><strong>Marca:</strong> <?= htmlspecialchars($equipamento['marca']) ?></p>
            <p><strong>Modelo:</strong> <?= htmlspecialchars($equipamento['modelo']) ?></p>
            <p><strong>Número de Série:</strong> <?= htmlspecialchars($equipamento['numero_serie']) ?></p>
            <p><strong>Setor ID:</strong> <?= htmlspecialchars($equipamento['setor_id']) ?></p>
            <p><strong>Data de Cadastro:</strong> <?= htmlspecialchars($equipamento['data_cadastro']) ?></p>
        </div>

        <div class="col-md-4">
            <h4>Foto Principal:</h4>
            <?php if ($equipamento['foto_frente']): ?>
                <img src="uploads/<?= htmlspecialchars($equipamento['foto_frente']) ?>" alt="Foto Frente" style="max-width: 300px; max-height: 300px;">
            <?php else: ?>
                <p>Nenhuma foto cadastrada.</p>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <h4>Foto da Etiqueta:</h4>
            <?php if ($equipamento['foto_etiqueta']): ?>
                <img src="uploads/<?= htmlspecialchars($equipamento['foto_etiqueta']) ?>" alt="Foto Etiqueta" style="max-width: 150px; max-height: 150px;">
            <?php else: ?>
                <p>Nenhuma foto cadastrada.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Botão para Editar -->
    <div class="mt-4">
        <a href="editar_equipamento.php?id=<?= $id ?>" class="btn btn-primary">Editar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
