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
$nom = trim($data['nom'] ?? '');
$email = trim($data['email'] ?? '');
$mot_de_passe = $data['mot_de_passe'] ?? '';

// Vérifier que tous les champs sont remplis
if (empty($nom) || empty($email) || empty($mot_de_passe)) {
    echo json_encode(["success" => false, "message" => "Tous les champs sont requis"]);
    exit;
}

// Validation du format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Format d'email invalide"]);
    exit;
}

// Validation de la longueur du nom
if (strlen($nom) < 2 || strlen($nom) > 100) {
    echo json_encode(["success" => false, "message" => "Le nom doit contenir entre 2 et 100 caractères"]);
    exit;
}

// Validation de la force du mot de passe
if (strlen($mot_de_passe) < 6) {
    echo json_encode(["success" => false, "message" => "Le mot de passe doit contenir au moins 6 caractères"]);
    exit;
}

try {
    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé"]);
        exit;
    }
    
    // Hasher le mot de passe
    $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    
    // Insérer le nouvel utilisateur
    $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, 'membre')");
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':mot_de_passe', $hash, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        // Récupérer l'ID du nouvel utilisateur
        $userId = $pdo->lastInsertId();
        
        // Créer automatiquement la session pour l'utilisateur
        $_SESSION['user'] = [
            "id" => (int)$userId,
            "nom" => $nom,
            "email" => $email,
            "role" => "membre"
        ];
        
        echo json_encode([
            "success" => true,
            "message" => "Inscription réussie",
            "user" => $_SESSION['user']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription"]);
    }
    
} catch (PDOException $e) {
    // Gérer les erreurs de base de données
    error_log("Erreur d'inscription: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de l'inscription. Veuillez réessayer."
    ]);
    exit;
}
?>