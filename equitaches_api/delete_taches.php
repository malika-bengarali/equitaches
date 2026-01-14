<?php
session_start();
require "config.php";

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM taches WHERE id=? AND user_id=?");
$stmt->execute([$id, $_SESSION['user']['id']]);

echo json_encode(["success" => true]);
