<?php
session_start();

session_destroy();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

echo json_encode(['success' => true, 'message' => 'Déconnecté']);
