"use strict";

// Initialisation des tooltips Bootstrap
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

/* Vanilla RSS - https://github.com/sdepold/vanilla-rss */
const rssContainer = document.querySelector("#rss-feeds");
if (rssContainer) {
    try {
        const rss = new RSS(
            rssContainer,
            // Changez ceci par vos propres flux RSS
            "https://feeds.feedburner.com/TechCrunch/startups",
            {
                // Combien d'entrées voulez-vous ?
                // défaut: 4
                // valeurs valides: tout nombre entier
                limit: 3,
                
                // Utiliser HTTPS pour les requêtes API
                // défaut: false
                // valeurs valides: false, true
                ssl: true,
              
                // Template externe pour la transformation HTML
                // défaut: "<ul>{entries}</ul>"
                // valeurs valides: toute chaîne de caractères
                layoutTemplate: "<div class='items'>{entries}</div>",
            
                // Template interne pour chaque entrée
                // défaut: '<li><a href="{url}">[{author}@{date}] {title}</a><br/>{shortBodyPlain}</li>'
                // valeurs valides: toute chaîne de caractères
                entryTemplate: '<div class="item"><h3 class="title"><a href="{url}" target="_blank">{title}</a></h3><div><p>{shortBodyPlain}</p><a class="more-link" href="{url}" target="_blank"><i class="fas fa-external-link-alt"></i>Lire plus</a></div></div>',
            }
        );
        rss.render().catch(error => {
            console.log("Erreur du flux RSS:", error);
            rssContainer.innerHTML = "Flux RSS temporairement indisponible.";
        });
    } catch (error) {
        console.log("Erreur d'initialisation RSS:", error);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Récupération du switch de mode sombre
    const darkSwitch = document.getElementById('darkSwitch');
    if (darkSwitch) {
        // Vérifier si un mode sombre est déjà enregistré dans le localStorage
        const darkMode = localStorage.getItem('darkMode');
        if (darkMode === 'enabled') {
            document.body.classList.add('dark-mode');
            darkSwitch.checked = true;
        }

        // Écouter les changements du switch
        darkSwitch.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', null);
            }
        });
    }

    // Initialisation des tooltips Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Animation des barres de compétences
    const skillBars = document.querySelectorAll('.level-bar-inner');
    const animateSkills = () => {
        skillBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    };

    // Observer pour déclencher l'animation des compétences
    const skillsSection = document.querySelector('.skills');
    if (skillsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateSkills();
                    observer.unobserve(entry.target);
                }
            });
        });
        observer.observe(skillsSection);
    }

    // Gestion du scroll fluide pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Gestion des fonctionnalités GitHub
    const githubEnabled = document.body.getAttribute('data-github-enabled') === 'true';
    
    if (githubEnabled) {
        /* Calendrier GitHub - initialiser uniquement si l'élément existe */
        const githubCalendar = document.querySelector('.github-graph');
        if (githubCalendar) {
            try {
                // Vérifier si GitHubCalendar existe avant de l'utiliser
                if (typeof GitHubCalendar !== 'undefined' && document.querySelector("#github-graph")) {
                    GitHubCalendar("#github-graph", "votre-username", {
                        responsive: true,
                        tooltips: true
                    });
                }
            } catch (e) {
                console.log("Erreur du calendrier GitHub:", e);
                githubCalendar.innerHTML = "Calendrier GitHub temporairement indisponible.";
            }
        }
        
        /* Flux d'activité GitHub - initialiser uniquement si l'élément existe */
        const ghFeedTarget = document.querySelector("#ghfeed");
        if (ghFeedTarget) {
            try {
                GitHubActivity.feed({ 
                    username: "your-username", 
                    selector: "#ghfeed",
                    limit: 5 // Limiter le nombre d'activités pour éviter les erreurs
                });
            } catch (e) {
                console.log("Erreur du flux d'activité GitHub:", e);
                ghFeedTarget.innerHTML = "Flux d'activité GitHub temporairement indisponible.";
            }
        }
    }
});