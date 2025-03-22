<?php
require_once 'config/config.php';  // Load config first
require_once 'config/autoload.php';

use Controllers\AuthController;

$auth = new AuthController();
$auth->login();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - <?php echo sanitizeOutput($profile['name']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .card-header {
            background: transparent;
            border-bottom: none;
            padding: 25px 0 0;
        }
        .card-header h3 {
            color: #2d3748;
            font-weight: 600;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
        }
        .btn-primary {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }
        .input-group-text {
            background: transparent;
            border: 2px solid #e2e8f0;
            border-right: none;
        }
        .spinner-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: white;
        }
        .alert {
            display: none;
            margin-bottom: 1rem;
        }
    </style>
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
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center mb-4">Bienvenue</h3>
                    </div>
                    <div class="card-body px-4">
                        <div class="alert alert-danger" id="error-message">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span></span>
                        </div>
                        <div class="alert alert-success" id="success-message">
                            <i class="fas fa-check-circle me-2"></i>
                            <span></span>
                        </div>
                        <form id="login-form" method="POST" action="">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input value="patrick.hebert@colin.com" type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input value="password123" type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-4">
                            <a href="index.php" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Spinner overlay -->
    <div class="spinner-overlay" id="spinner">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
    <!-- Spinner overlay -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                // Cacher les messages précédents
                $('.alert').hide();
                // Afficher le spinner
                $('#spinner').css('display', 'flex');
                
                // Désactiver le bouton de soumission
                $('button[type="submit"]').prop('disabled', true);
                
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#success-message span').text('Connexion réussie ! Redirection...');
                            $('#success-message').show();
                            
                            setTimeout(function() {
                                window.location.href = response.redirect || 'index.php';
                            }, 1000);
                        } else {
                            $('#error-message span').text(response.error || 'Une erreur est survenue');
                            $('#error-message').show();
                            $('button[type="submit"]').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur AJAX:', status, error);
                        $('#error-message span').text('Une erreur de communication est survenue');
                        $('#error-message').show();
                        $('button[type="submit"]').prop('disabled', false);
                    },
                    complete: function() {
                        // Cacher le spinner
                        $('#spinner').hide();
                    }
                });
            });
        });
    </script>
</body>
</html>