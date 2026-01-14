<?php
session_start();
require "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare(
  "UPDATE taches SET titre=?, description=?, statut=?, priorite=? 
   WHERE id=? AND user_id=?"
);

$stmt->execute([
  $data['titre'],
  $data['description'],
  $data['statut'],
  $data['priorite'],
  $data['id'],
  $_SESSION['user']['id']
]);

echo json_encode(["success" => true]);
