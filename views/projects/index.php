<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Helper\OutputHelper;
?>
<!DOCTYPE html>
<html lang="<?php echo substr($locale, 0, 2); ?>">
<head>
    <title><?php echo $debugMode ? '[DEBUG] ' : ''; ?>Projets - Portfolio</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projets du portfolio">
    <meta name="author" content="<?php echo OutputHelper::sanitize($profile['name'] ?? ''); ?>">    
    <link rel="shortcut icon" href="favicon.ico">  
    
    <?php require_once 'views/partials/header_resources.php'; ?>
</head> 

<body>
    <?php require_once 'views/partials/navigation.php'; ?>

    <div class="container sections-wrapper py-5">
        <div class="row">
            <div class="col-12">
                <section class="projects section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading">Tous les projets</h2>
                        <div class="content">
                            <div id="projects-container" class="row">
                                <!-- Les projets seront chargés ici via Ajax -->
                            </div>
                            <div class="pagination-container text-center mt-4">
                                <button id="load-more" class="btn btn-primary">Charger plus</button>
                                <p id="loading" style="display: none;">Chargement...</p>
                                <div id="error-message" class="alert alert-danger mt-3" style="display: none;">
                                    Une erreur est survenue lors du chargement des projets.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php require_once 'views/partials/footer.php'; ?>
    <?php require_once 'views/partials/footer_scripts.php'; ?>
    <script src="assets/js/projects.js"></script>
</body>
</html>
