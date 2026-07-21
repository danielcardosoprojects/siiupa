<?php
header('Content-Type: application/json; charset=utf-8');
@include_once("../../bd/conectabd.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
    exit;
}

$id = $_POST['id'] ?? '';

if ($id === '') {
    echo json_encode(['success' => false, 'message' => 'ID não informado.']);
    exit;
}

try {
    $bd = new BD;
    $conexao = $bd->conecta();

    $sql = "DELETE FROM u940659928_siupa.tabela_atualizacaocadastral WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Cadastro excluído com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir: ' . $e->getMessage()]);
}