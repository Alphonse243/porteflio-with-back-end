<?php

namespace Models;

use Core\Model;

// Modèle pour la gestion des projets
class Project extends Model
{
    // Liste des champs modifiables
    protected $fillable = [
        'title',         // Titre du projet
        'description',   // Description détaillée
        'project_url',   // URL du projet
        'image_url',     // URL de l'image du projet
        'is_featured'    // Projet mis en avant ou non
    ];

    // Récupère tous les projets triés
    public static function getAll()
    {
        return self::orderBy('is_featured', 'desc')  // Trie d'abord par mise en avant
                   ->orderBy('created_at', 'desc')   // Puis par date de création
                   ->get();                          // Récupère les résultats
    }
}
