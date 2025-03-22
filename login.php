<?php
session_start();
require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/functions.php';

// Si l'utilisateur est déjà connecté, rediriger vers la page d'accueil
if (isUserLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        try {
            // Hacher le mot de passe avec SHA1
            $hashedPassword = sha1($password);
            
            $stmt = $db->prepare('SELECT id, username, password FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $user['password'] === $hashedPassword) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Rediriger vers la page précédente ou l'accueil
                $redirect = $_GET['redirect'] ?? 'index.php';
                header('Location: ' . $redirect);
                exit;
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        } catch (PDOException $e) {
            if (isDebugMode()) {
                $error = 'Erreur de base de données : ' . $e->getMessage();
            } else {
                $error = 'Une erreur est survenue';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - <?php echo sanitizeOutput($profile['name']); ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Portfolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projects.php">Projets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isUserLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="login.php">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Carte principale du formulaire de connexion -->
                <div class="card">
                    <!-- En-tête du formulaire -->
                    <div class="card-header">
                        <h3 class="text-center">Connexion</h3>
                    </div>
                    <!-- Corps du formulaire -->
                    <div class="card-body">
                        <!-- Affichage des messages d'erreur -->
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulaire de connexion -->
                        <form method="POST" action="">
                            <!-- Champ email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <!-- Champ mot de passe -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- Bouton de soumission -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>
                        
                        <!-- Lien de retour -->
                        <div class="text-center mt-3">
                            <a href="index.php">Retour à l'accueil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>