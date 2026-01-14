<?php
// api.php
header("Content-Type: application/json");

// Autorise toutes les origines localhost dynamiquement
if (isset($_SERVER['HTTP_ORIGIN']) && str_contains($_SERVER['HTTP_ORIGIN'], "localhost")) {
    $origin = $_SERVER['HTTP_ORIGIN'];
    header("Access-Control-Allow-Origin: $origin"); // Important : valeur exacte de l'Origin
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

// OPTIONS préflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Démarrage session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
