<?php
session_start();
require "config.php";

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT * FROM taches WHERE user_id = ?");
$stmt->execute([$user_id]);

echo json_encode($stmt->fetchAll());
