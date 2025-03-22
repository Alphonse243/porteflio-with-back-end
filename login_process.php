<?php
session_start();
require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/functions.php';

$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $response['error'] = 'Veuillez remplir tous les champs';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        try {
            $hashedPassword = sha1($password);
            
            $stmt = $db->prepare('SELECT id, username, password FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $user['password'] === $hashedPassword) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                $response['success'] = true;
                $response['redirect'] = $_GET['redirect'] ?? 'index.php';
            } else {
                $response['error'] = 'Email ou mot de passe incorrect';
            }
        } catch (PDOException $e) {
            $response['error'] = isDebugMode() ? 
                'Erreur de base de données : ' . $e->getMessage() : 
                'Une erreur est survenue';
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
