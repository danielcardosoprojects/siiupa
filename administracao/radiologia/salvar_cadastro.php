<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@include_once("../../bd/conectabd.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Requisição inválida.";
    exit;
}

$nome            = trim($_POST['nome'] ?? '');
$cpf             = trim($_POST['cpf'] ?? '');
$data_nascimento = trim($_POST['data_nascimento'] ?? '');
$endereco        = trim($_POST['endereco'] ?? '');
$telefone        = trim($_POST['telefone'] ?? '');
$email           = trim($_POST['email'] ?? '');
$data_criacao    = trim($_POST['data_criacao'] ?? date('Y-m-d H:i:s'));

// Remove tudo que não for número do CPF antes de salvar
$cpf = preg_replace('/\D/', '', $cpf);

if ($nome === '' || $cpf === '' || $data_nascimento === '' || $endereco === '' || $telefone === '' || $email === '') {
    echo "Preencha todos os campos obrigatórios.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail inválido.";
    exit;
}

if (strlen($cpf) !== 11) {
    echo "CPF inválido. Deve conter 11 dígitos.";
    exit;
}

try {
    $bd = new BD;
    $conexao = $bd->conecta();

    $sql = "INSERT INTO u940659928_siupa.tabela_atualizacaocadastral
                (nome, cpf, data_nascimento, endereco, telefone, email, data_criacao)
            VALUES
                (:nome, :cpf, :data_nascimento, :endereco, :telefone, :email, :data_criacao)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_criacao', $data_criacao);

    $stmt->execute();

    echo "Cadastro atualizado com sucesso!";
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo "Este CPF já possui atualização cadastral realizada.";
    } else {
        echo "Erro ao salvar cadastro: " . $e->getMessage();
    }
}