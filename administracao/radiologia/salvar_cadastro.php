<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@include_once("../../bd/conectabd.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Requisição inválida.";
    exit;
}

// Recebendo e validando os dados
$nome            = trim($_POST['nome'] ?? '');
$cpf             = trim($_POST['cpf'] ?? '');
$data_nascimento = trim($_POST['data_nascimento'] ?? '');
$endereco        = trim($_POST['endereco'] ?? '');
$telefone        = trim($_POST['telefone'] ?? '');
$email           = trim($_POST['email'] ?? '');
$data_criacao    = trim($_POST['data_criacao'] ?? date('Y-m-d H:i:s'));

if ($nome === '' || $cpf === '' || $data_nascimento === '' || $endereco === '' || $telefone === '' || $email === '') {
    echo "Preencha todos os campos obrigatórios.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail inválido.";
    exit;
}

try {
    $bd = new BD;
    $conexao = $bd->conecta(); // deve retornar um objeto PDO

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
    echo "Erro ao salvar cadastro: " . $e->getMessage();
}