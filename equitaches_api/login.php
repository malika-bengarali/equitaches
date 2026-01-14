<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclure les fichiers nécessaires
require_once 'api.php';
require_once 'config.php';

// Vérifier que la connexion PDO existe
if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Erreur de configuration de la base de données"]);
    exit;
}

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);

// Validation des données d'entrée
$email = trim($data["email"] ?? "");
$mot_de_passe = $data["mot_de_passe"] ?? "";

if (empty($email) || empty($mot_de_passe)) {
    echo json_encode(["success" => false, "message" => "Email et mot de passe requis"]);
    exit;
}

// Validation du format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Format d'email invalide"]);
    exit;
}

try {
    // Préparer la requête avec PDO
    $stmt = $pdo->prepare("SELECT id, nom, email, mot_de_passe, role FROM utilisateur WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    // Récupérer l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si l'utilisateur existe
    if (!$user) {
        echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect"]);
        exit;
    }
    
    // Vérifier le mot de passe
    if (!password_verify($mot_de_passe, $user["mot_de_passe"])) {
        echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect"]);
        exit;
    }
    
    // Stocker les informations utilisateur en session (sans le mot de passe)
    $_SESSION['user'] = [
        "id" => (int)$user["id"],
        "nom" => $user["nom"],
        "email" => $user["email"],
        "role" => strtolower($user["role"])
    ];
    
    // Retourner la réponse de succès
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussie",
        "user" => $_SESSION['user']
    ]);
    
} catch (PDOException $e) {
    // Gérer les erreurs de base de données
    error_log("Erreur de connexion: " . $e->getMessage());
    echo json_encode([
        "success" => false, 
        "message" => "Erreur lors de la connexion. Veuillez réessayer."
    ]);
    exit;
}
?>