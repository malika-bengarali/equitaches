<?php
require 'api.php';


session_destroy();

echo json_encode([
    "success" => true,
    "message" => "Déconnexion réussie"
]);
?>