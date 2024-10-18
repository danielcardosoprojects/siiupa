<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Chave secreta para assinar o token (não compartilhe publicamente)
$chaveSecreta = 'sua_chave_secreta_aqui';

// Dados que serão incluídos no token (payload)
$dados = [
    'iss' => 'https://www.siupa.com.br', // Emissor do token
    'aud' => 'https://www.siupa.com.br', // Público do token
    'iat' => time(), // Hora de criação do token
    'nbf' => time(), // Token não será aceito antes desta hora
    'exp' => time() + 3600, // Expiração do token (ex: 1 hora a partir de agora)
    'data' => [
        'id_usuario' => 123, // ID do usuário
        'nome' => 'João da Silva', // Nome do usuário
        'email' => 'joao@example.com' // Email do usuário
    ]
];

// Gera o token JWT
$jwt = JWT::encode($dados, $chaveSecreta, 'HS256');

echo "Token JWT: " . $jwt;
?>
