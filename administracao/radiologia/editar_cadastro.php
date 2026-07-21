<?php
header('Content-Type: application/json; charset=utf-8');
@include_once("../../bd/conectabd.php");
session_start();

@include_once('../../bd/nivel.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
    exit;
}

$id              = $_POST['id'] ?? '';
$nome            = trim($_POST['nome'] ?? '');
$cpf             = preg_replace('/\D/', '', trim($_POST['cpf'] ?? ''));
$data_nascimento = trim($_POST['data_nascimento'] ?? '');
$endereco        = trim($_POST['endereco'] ?? '');
$telefone        = trim($_POST['telefone'] ?? '');
$email           = trim($_POST['email'] ?? '');

if ($id === '' || $nome === '' || $cpf === '' || $data_nascimento === '' || $endereco === '' || $telefone === '' || $email === '') {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'E-mail inválido.']);
    exit;
}

if (strlen($cpf) !== 11) {
    echo json_encode(['success' => false, 'message' => 'CPF inválido. Deve conter 11 dígitos.']);
    exit;
}

try {
    $bd = new BD;
    $conexao = $bd->conecta();

    $sql = "UPDATE u940659928_siupa.tabela_atualizacaocadastral
            SET nome = :nome,
                cpf = :cpf,
                data_nascimento = :data_nascimento,
                endereco = :endereco,
                telefone = :telefone,
                email = :email
            WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Cadastro atualizado com sucesso!']);
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo json_encode(['success' => false, 'message' => 'Já existe outro cadastro com este CPF.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar: ' . $e->getMessage()]);
    }
}