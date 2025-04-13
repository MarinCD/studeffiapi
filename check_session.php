<?php
session_start();
header('Access-Control-Allow-Origin: http://localhost:3000'); // Autorise uniquement l'origine de votre application Vue.js
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Autorise les méthodes HTTP
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Autorise les en-têtes spécifiques
header('Access-Control-Allow-Credentials: true'); // Si vous utilisez des cookies ou des sessions

if (isset($_SESSION['user_id'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
