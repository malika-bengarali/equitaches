<?php
session_start();
require "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare(
  "INSERT INTO taches (titre, description, statut, priorite, user_id)
   VALUES (?,?,?,?,?)"
);

$stmt->execute([
  $data['titre'],
  $data['description'],
  $data['statut'],
  $data['priorite'],
  $_SESSION['user']['id']
]);

echo json_encode(["success" => true]);
