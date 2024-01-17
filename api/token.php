<?php
header("Access-Control-Allow-Origin: *");
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$jwt = $_GET['token'];
$key = 'kljsjdlkajl#KJKL#k3j4lkj4kl2jkl34kJL$#wq423lk4jlk23JKL#@LK$';
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

echo json_encode($decoded);

?>