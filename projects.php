<?php
require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/functions.php';

// Initialisation de la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupération des données
$profile = getProfileData($db);
$projects = getProjects($db);

// Vérification du mode debug
$debugMode = isDebugMode();
$systemUrl = getSystemUrl();
$locale = getDefaultLocale();

// Définir la variable pour les fonctionnalités GitHub
$enableGitHub = isset($profile['github_username']) && !empty($profile['github_username']);

// Inclure la vue
require_once 'views/projects/index.php';
