<?php

namespace Models;

// Utilisation du modèle de base
use Core\Model;

// Modèle pour la gestion du profil utilisateur
class Profile extends Model
{
    // Définition des champs modifiables en masse
    protected $fillable = [
        'name',          // Nom de l'utilisateur
        'title',         // Titre professionnel
        'description',   // Description du profil
        'location',      // Localisation
        'email',         // Adresse email
        'website',       // Site web personnel
        'twitter_url',   // Lien Twitter
        'linkedin_url',  // Lien LinkedIn
        'github_username'// Nom d'utilisateur GitHub
    ];
    
    // Méthode pour récupérer les données du profil
    public static function getProfileData()
    {
        // Retourne le premier profil trouvé
        return self::first();
    }
}
