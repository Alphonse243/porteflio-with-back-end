<?php

namespace Core;

// Importation du modèle Eloquent de base
use Illuminate\Database\Eloquent\Model as EloquentModel;

// Classe de base pour tous les modèles de l'application
class Model extends EloquentModel
{
    // Activation des timestamps automatiques (created_at, updated_at)
    public $timestamps = true;
    
    // Format de date par défaut pour tous les modèles
    protected $dateFormat = 'Y-m-d H:i:s';
}
