<?php
namespace Views;
require_once __DIR__ . '/../../config.php';

// Define if GitHub features are enabled
$enableGitHub = false; // Set to true when GitHub username is configured
?>
<!DOCTYPE html>
<html lang="<?php echo substr($locale, 0, 2); ?>">
<head>
    <title><?php echo $debugMode ? '[DEBUG] ' : ''; ?>Portfolio</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo sanitizeOutput($profile['description'] ?? 'Portfolio'); ?>">
    <meta name="author" content="<?php echo sanitizeOutput($profile['name'] ?? ''); ?>">    
    <link rel="shortcut icon" href="favicon.ico">  
    
    <!-- CSS et autres ressources -->
    <?php require_once 'views/partials/header_resources.php'; ?>
</head> 

<body>
    <!-- Navigation -->
    <?php require_once 'views/partials/navigation.php'; ?>

    <!-- Contenu de la page -->
    <?php require_once 'views/partials/header.php'; ?>
    <div class="container sections-wrapper py-5">
        <div class="row">
            <div class="primary col-lg-8 col-12">
                <section class="about section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading">About Me</h2>
                        <div class="content">
                            <p><?php echo nl2br(sanitizeOutput($profile['description'] ?? 'Description par défaut...')); ?></p>
                        </div><!--//content-->
                    </div><!--//section-inner-->                 
                </section><!--//section-->
    
               <section class="latest section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading">Latest Projects</h2>
                        <div class="content">    
                            <?php foreach ($projects as $project): ?>                           

                            <div class="item <?php echo $project['is_featured'] ? 'featured text-center' : 'row'; ?>">
                                <?php if (!empty($project['image_url'])): ?>
                                <div class="<?php echo $project['is_featured'] ? 'featured-image has-ribbon' : 'col-md-4 col-12'; ?>">
                                    <a href="project.php?url=<?php echo urlencode($project['project_url']); ?>">
                                        <?php 
                                        $imageUrl = $project['image_url'] ?? '';
                                        if (empty($imageUrl) || !file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($imageUrl, PHP_URL_PATH))) {
                                            // Si l'image n'existe pas, utiliser une image placeholder
                                            $imageUrl = "https://via.placeholder.com/800x600?text=Project+" . substr($project['title'], 0, 20);
                                        }
                                        ?>
                                        <img class="img-fluid project-image rounded shadow-sm" 
                                             src="<?php echo sanitizeOutput($imageUrl); ?>" 
                                             alt="<?php echo sanitizeOutput($project['title']); ?>" />
                                    </a>
                                    <?php if ($project['is_featured']): ?>
                                    <div class="ribbon">
                                        <div class="text">New</div>
                                    </div>

                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                

                                <div class="<?php echo $project['is_featured'] ? '' : 'desc col-md-8 col-12'; ?>">
                                    <h3 class="title mb-3">
                                        <a href="project.php?url=<?php echo urlencode($project['project_url']); ?>">
                                            <?php echo sanitizeOutput($project['title']); ?>
                                        </a>
                                    </h3>
                                    
                                    <div class="desc text-start">                                    
                                        <p><?php echo nl2br(sanitizeOutput($project['description'])); ?></p>
                                    </div>

                                    <?php if ($project['is_featured']): ?>
                                <a class="btn btn-cta-secondary" href="https://themes.3rdwavemedia.com/bootstrap-templates/startup/launch-bootstrap-4-template-for-saas-businesses/" target="_blank"><i class="fas fa-thumbs-up"></i> Back my project</a>                 

                                <hr class="divider" />
                                <?php else: ?>
                                    <p><a class="more-link" href="https://themes.3rdwavemedia.com/bootstrap-templates/resume/instance-bootstrap-portfolio-theme-for-developers/" target="_blank"><i class="fas fa-external-link-alt"></i>Find out more</a></p>
                                <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php endforeach; ?>
                        </div><!--//content-->  
                    </div><!--//section-inner-->                
                </section><!--//section-->
                
                <section class="experience section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading">Work Experience</h2>
                        <div class="content">
                            <?php foreach ($experience as $exp): ?>
                            <div class="item">
                                <h3 class="title">
                                    <?php echo sanitizeOutput($exp['title']); ?> - 
                                    <span class="place">
                                        <a href="#"><?php echo sanitizeOutput($exp['company']); ?></a>
                                    </span> 
                                    <span class="year">
                                        (<?php echo formatDate($exp['start_date']); ?> - 
                                        <?php echo $exp['end_date'] ? formatDate($exp['end_date']) : 'Present'; ?>)
                                    </span>
                                </h3>
                                <p><?php echo nl2br(sanitizeOutput($exp['description'])); ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div><!--//content-->  
                    </div><!--//section-inner-->                 
                </section><!--//section-->
            </div><!--//primary-->
            <div class="secondary col-lg-4 col-12">
                 <aside class="info aside section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading sr-only">Basic Information</h2>
                        <div class="content">
                            <ul class="list-unstyled">
                                <?php if (!empty($profile['location'])): ?>
                                <li><i class="fas fa-map-marker-alt"></i><span class="sr-only">Location:</span><?php echo sanitizeOutput($profile['location']); ?></li>
                                <?php endif; ?>
                                <?php if (!empty($profile['email'])): ?>
                                <li><i class="fas fa-envelope"></i><span class="sr-only">Email:</span><a href="mailto:<?php echo sanitizeOutput($profile['email']); ?>"><?php echo sanitizeOutput($profile['email']); ?></a></li>
                                <?php endif; ?>
                                <?php if (!empty($profile['website'])): ?>
                                <li><i class="fas fa-link"></i><span class="sr-only">Website:</span><a href="<?php echo sanitizeOutput($profile['website']); ?>"><?php echo sanitizeOutput($profile['website']); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div><!--//content-->  
                    </div><!--//section-inner-->                 
                </aside><!--//aside-->
                
                <aside class="skills aside section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading">Skills</h2>
                        <div class="content">
                            <div class="skillset">
                                <?php foreach ($skills as $skill): ?>
                                <div class="item">
                                    <h3 class="level-title">
                                        <?php echo sanitizeOutput($skill['name']); ?>
                                        <span class="level-label" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?php echo sanitizeOutput($skill['category']); ?>">
                                            <i class="fas fa-info-circle"></i>
                                            <?php echo $skill['level'] >= 90 ? 'Expert' : ($skill['level'] >= 80 ? 'Pro' : 'Intermediate'); ?>
                                        </span>
                                    </h3>
                                    <div class="level-bar progress">
                                        <div class="progress-bar level-bar-inner" role="progressbar" style="width: <?php echo $skill['level']; ?>%" 
                                             aria-valuenow="<?php echo $skill['level']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>              
                        </div><!--//content-->  
                    </div><!--//section-inner-->                 
                </aside><!--//section-->

                <!-- Optionally include GitHub sections -->
                <?php if ($enableGitHub): ?>
                    <div class="github-graph">
                        <div class="loading">Chargement du calendrier GitHub...</div>
                    </div>
                    
                    <div id="ghfeed" class="github-feed">
                        <div class="loading">Chargement des activités GitHub...</div>
                    </div>
                <?php endif; ?>
            </div><!--//secondary-->    
        </div><!--//row-->
    </div><!--//masonry-->
    <!-- Footer -->
    <?php require_once 'views/partials/footer.php'; ?>
    
    <!-- Scripts -->
    <?php require_once 'views/partials/footer_scripts.php'; ?>
</body>
</html>