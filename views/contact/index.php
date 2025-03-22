<!DOCTYPE html>
<html lang="<?php echo substr($locale, 0, 2); ?>">
<head>
    <title><?php echo $debugMode ? '[DEBUG] ' : ''; ?>Contact - Portfolio</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact">
    <meta name="author" content="<?php echo sanitizeOutput($profile['name'] ?? ''); ?>">    
    <link rel="shortcut icon" href="favicon.ico">  
    
    <?php require_once 'views/partials/header_resources.php'; ?>
</head> 

<body>
    <?php require_once 'views/partials/navigation.php'; ?>

    <div class="container sections-wrapper py-5">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <section class="contact section">
                    <div class="section-inner shadow-sm rounded">
                        <h2 class="heading">Contact</h2>
                        <div class="content">
                            <?php if ($error): ?>
                                <div class="alert alert-danger">
                                    <?php echo sanitizeOutput($error); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($message): ?>
                                <div class="alert alert-success">
                                    <?php echo sanitizeOutput($message); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!isUserLoggedIn()): ?>
                                <div class="alert alert-info">
                                    Veuillez vous <a href="login.php">connecter</a> pour envoyer un message.
                                </div>
                            <?php else: ?>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </form>
                            <?php endif; ?>
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
