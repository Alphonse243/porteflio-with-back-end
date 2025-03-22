<?php

namespace Controllers;

// Importation des dépendances nécessaires
use Core\Controller;
use Models\Profile;
use Models\Project;
use Models\Skill;
use Models\Experience;

// Contrôleur principal de la page d'accueil
class HomeController extends Controller 
{
    // Action pour la page d'accueil
    public function index() 
    {
        // Préparation des données pour la vue
        $data = [
            'profile' => Profile::getProfileData(),      // Données du profil
            'projects' => Project::latest()->get(),      // Liste des projets
            'skills' => Skill::orderBy('level', 'desc')->get(), // Compétences
            'experience' => Experience::latest('start_date')->get(), // Expériences
            'debugMode' => $this->isDebugMode(),         // Mode debug
            'systemUrl' => $this->getSystemUrl(),        // URL du système
            'locale' => $this->getDefaultLocale()        // Langue par défaut
        ];

        // Affichage de la vue avec les données
        $this->view('home/index', $data);
    }

    // Vérifie si le mode debug est activé
    private function isDebugMode() {
        return defined('DEBUG_MODE') && DEBUG_MODE === true;
    }

    // Récupère l'URL de base du système
    private function getSystemUrl() {
        return BASE_URL . '/';
    }

    // Définit la langue par défaut
    private function getDefaultLocale() {
        return 'fr_FR';
    }
}
