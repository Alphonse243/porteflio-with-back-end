<header class="header">
    <div class="container">     
        <div class="row align-items-center">
            <div class="col">         
                <img class="profile-image img-fluid float-start rounded-circle" src="<?php echo $systemUrl; ?>assets/images/profile.png" alt="profile image" />
                <div class="profile-content">
                    <h1 class="name"><?php echo sanitizeOutput($profile['name'] ?? 'James Lee'); ?></h1>
                    <h2 class="desc"><?php echo sanitizeOutput($profile['title'] ?? 'Web App Developer'); ?></h2>   
                    <ul class="social list-inline">
                        <?php if (!empty($profile['twitter_url'])): ?>
                        <li class="list-inline-item"><a href="<?php echo sanitizeOutput($profile['twitter_url']); ?>"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($profile['linkedin_url'])): ?>
                        <li class="list-inline-item"><a href="<?php echo sanitizeOutput($profile['linkedin_url']); ?>"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($profile['github_username'])): ?>
                        <li class="list-inline-item"><a href="https://github.com/<?php echo sanitizeOutput($profile['github_username']); ?>"><i class="fa-brands fa-github-alt"></i></a></li>
                        <?php endif; ?>
                    </ul> 
                </div>
            </div>
            <div class="col-12 col-md-auto">
                <div class="dark-mode-switch d-flex">
                    <div class="form-check form-switch mx-auto mx-md-0">
                        <input type="checkbox" class="form-check-input me-2" id="darkSwitch" />
                        <label class="custom-control-label" for="darkSwitch">Dark Mode</label>
                    </div>
                </div>
                <a class="btn btn-cta-primary" href="#contact"><i class="fas fa-paper-plane"></i> Contact Me</a>        
            </div>
        </div>
    </div>
</header>
