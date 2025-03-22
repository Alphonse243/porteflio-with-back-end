<?php
require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/functions.php';

// Initialisation de la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupération des données du profil
$profile = getProfileData($db);

// Variables
$message = '';
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $content = $_POST['message'] ?? '';
    
    if (empty($name) || empty($email) || empty($content)) {
        $error = 'Tous les champs sont obligatoires';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalide';
    } else {
        try {
            // On insère d'abord l'utilisateur temporaire
            $stmt = $db->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $tempPassword = sha1(uniqid()); // Mot de passe temporaire
            $stmt->execute([$name, $email, $tempPassword]);
            $userId = $db->lastInsertId();

            // Puis on insère le commentaire
            $stmt = $db->prepare('INSERT INTO comments (project_url, user_id, content) VALUES (?, ?, ?)');
            $stmt->execute(['contact', $userId, $content]);
            
            $message = 'Votre message a été envoyé avec succès';
        } catch (PDOException $e) {
            $error = isDebugMode() ? $e->getMessage() : 'Une erreur est survenue';
        }
    }
}

// Configuration
$debugMode = isDebugMode();
$systemUrl = getSystemUrl();
$locale = getDefaultLocale();
$enableGitHub = isset($profile['github_username']) && !empty($profile['github_username']);

// Inclure la vue
require_once 'views/contact/index.php';
