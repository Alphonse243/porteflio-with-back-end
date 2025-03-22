<!DOCTYPE html>
<html lang="<?php echo substr($locale, 0, 2); ?>">
<head>
    <title><?php echo $debugMode ? '[DEBUG] ' : ''; ?>Projets - Portfolio</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projets du portfolio">
    <meta name="author" content="<?php echo sanitizeOutput($profile['name'] ?? ''); ?>">    
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
                            <div class="row">
                            <?php foreach ($projects as $project): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <?php 
                                        $imageUrl = $project['image_url'] ?? '';
                                        if (empty($imageUrl) || !file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($imageUrl, PHP_URL_PATH))) {
                                            // Image par défaut si l'image n'existe pas
                                            $imageUrl = "https://via.placeholder.com/800x600?text=" . urlencode($project['title']);
                                        }
                                        ?>
                                        <img class="card-img-top" 
                                             src="<?php echo sanitizeOutput($imageUrl); ?>" 
                                             alt="<?php echo sanitizeOutput($project['title']); ?>"
                                             onerror="this.src='https://via.placeholder.com/800x600?text=No+Image'">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo sanitizeOutput($project['title']); ?></h5>
                                            <p class="card-text"><?php echo nl2br(sanitizeOutput($project['description'])); ?></p>
                                            <a href="project.php?url=<?php echo urlencode($project['project_url']); ?>" 
                                               class="btn btn-primary">Voir plus</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php require_once 'views/partials/footer.php'; ?>
    <?php require_once 'views/partials/footer_scripts.php'; ?>
</body>
</html>
