<?php
$server = "mysql-marin.alwaysdata.net";
$nomBD = "marin_studeffi";
$login = base64_decode("bWFyaW4=");
$psw = base64_decode("VlJiQ1VQd3VicEBxUXYy");

try {
    $pdo = new PDO("mysql:host=$server;dbname=$nomBD", $login, $psw);
} catch (Exception $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}
?>
