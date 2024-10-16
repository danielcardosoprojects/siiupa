<?php
// Verifica se o ID foi passado via query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']); // Converte o ID para um inteiro


// URL da API com o ID
$apiUrl = "https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/" . $id."?join=setor_id,tb_setor";

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
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
    <style>
        div {
            border: solid 1px #ccc;
        }
        </style>
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="/siiupa/?setor=adm">
    <img src="/siiupa/imagens/siiupa.png" class="d-inline-block align-top" alt="">
    Administração - Controle de Patrimônio
  </a>
</nav>
<div class="container mt-5">
<div class="mt-4">
        <a href="<?= $id ?>/editar" class="btn btn-primary">Editar</a>
        <a href="./" class="btn btn-primary">Concluído</a>
    </div>
    <h2>Nome: <?= htmlspecialchars($equipamento['nome']) ?></h2>
    <div class="row">
        <div class="col-md-4">
            
            <p><strong>Tipo:</strong> <?= htmlspecialchars($equipamento['tipo']) ?></p>
            <p><strong>Marca:</strong> <?= htmlspecialchars($equipamento['marca']) ?></p>
            <p><strong>Modelo:</strong> <?= htmlspecialchars($equipamento['modelo']) ?></p>
            <p><strong>Número de Série:</strong> <?= htmlspecialchars($equipamento['numero_serie']) ?></p>
            <p><strong>Setor ID:</strong> <?= htmlspecialchars($equipamento['setor_id']['setor']) ?></p>
            <p><strong>Data de Cadastro:</strong> <?= htmlspecialchars($equipamento['data_cadastro']) ?></p>
        </div>


        <div class="col-md-4">
          
            <?php if ($equipamento['foto_frente']): ?>
                <img src="uploads/<?= htmlspecialchars($equipamento['foto_frente']) ?>" alt="Foto Frente" style="max-width: 300px; max-height: 300px;">
            <?php else: ?>
                <p>Nenhuma foto cadastrada.</p>
            <?php endif; ?>

            <a href="/siiupa/administracao/patrimonio/<?=$id?>/foto/principal" type="button" class="btn btn-link">Editar Foto</a>

        </div>

        <div class="col-md-4">
            <h4>Foto da Etiqueta:</h4>
            <?php if ($equipamento['foto_etiqueta']): ?>
                <img src="uploads/<?= htmlspecialchars($equipamento['foto_etiqueta']) ?>" alt="Foto Etiqueta" style="max-width: 150px; max-height: 150px;">
            <?php else: ?>
                <p>Nenhuma foto cadastrada.</p>
            <?php endif; ?>
            <div></div>
            <a href="/siiupa/administracao/patrimonio/<?=$id?>/foto/etiqueta" type="button" class="btn btn-link">Editar Foto</a>
        </div>
    </div>

    <!-- Botão para Editar -->
   
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
