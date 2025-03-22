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
                        <p>Pas encore de compte ? <a href="register.php">Créez-en un</a></p>
                        <a href="index.php" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="spinner-overlay" id="spinner">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        $('.alert').hide();
        $('#spinner').css('display', 'flex');
        
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = 'index.php';
                } else {
                    $('#error-message span').text(response.error || 'Une erreur est survenue');
                    $('#error-message').show();
                }
                $('button[type="submit"]').prop('disabled', false);
            },
            // ...existing code...
        });
    });
});
</script>
