<!-- Javascript -->          
<script type="text/javascript" src="<?php echo $systemUrl; ?>assets/plugins/popper.min.js"></script> 
<script type="text/javascript" src="<?php echo $systemUrl; ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>    
<script type="text/javascript" src="<?php echo $systemUrl; ?>assets/plugins/vanilla-rss/dist/rss.global.min.js"></script> 
<script type="text/javascript" src="<?php echo $systemUrl; ?>assets/plugins/dark-mode-switch/dark-mode-switch.min.js"></script> 

<?php if (isset($enableGitHub) && $enableGitHub && !empty($profile['github_username'])): ?>
    <!-- GitHub Integration Scripts -->
    <script type="text/javascript" src="<?php echo $systemUrl; ?>assets/plugins/github-calendar/dist/github-calendar.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js"></script>
    <script type="text/javascript" src="<?php echo $systemUrl; ?>assets/plugins/github-activity/src/github-activity.js"></script>
    <script>
        GitHubCalendar("#github-graph", "<?php echo sanitizeOutput($profile['github_username']); ?>", { responsive: true });
        GitHubActivity.feed({
            username: "<?php echo sanitizeOutput($profile['github_username']); ?>",
            selector: "#ghfeed",
            limit: 5
        });
    </script>
<?php endif; ?>

<!-- Custom JS -->
<script type="text/javascript" src="<?php echo $systemUrl; ?>assets/js/main.js"></script>
