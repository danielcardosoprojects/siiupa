<?php
header("Access-Control-Allow-Origin: *");
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use UnexpectedValueException;
if(!isset($_POST['token'])){
    http_response_code(403);
    exit;

}
$jwt = $_POST['token'];
$key = 'kljsjdlkajl#KJKL#k3j4lkj4kl2jkl34kJL$#wq423lk4jlk23JKL#@LK$';
try {
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
} catch (LogicException $e) {
    // errors having to do with environmental setup or malformed JWT Keys
} catch (UnexpectedValueException $e) {
    // errors having to do with JWT signature and claims
}
echo json_encode($decoded);

?>