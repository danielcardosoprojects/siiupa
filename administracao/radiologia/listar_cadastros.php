<?php
header('Content-Type: application/json; charset=utf-8');
@include_once("../../bd/conectabd.php");
session_start();

@include_once('../../bd/nivel.php');

try {
    $bd = new BD;
    $conexao = $bd->conecta();

    $sql = "SELECT id, nome, cpf, data_nascimento, endereco, telefone, email, data_criacao
            FROM u940659928_siupa.tabela_atualizacaocadastral
            ORDER BY data_criacao DESC";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $dados]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}