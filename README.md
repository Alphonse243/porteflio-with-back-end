# Portfolio avec Backend PHP

Un portfolio professionnel dynamique avec backend PHP et base de données MySQL.

## 🚀 Fonctionnalités

- Design responsive et moderne
- Mode sombre/clair
- Sections personnalisables :
  - Profil
  - Projets
  - Compétences
  - Expérience professionnelle
- Intégration GitHub (calendrier et flux d'activité)
- Animations fluides
- Gestion multilingue
- Mode debug
- Système de commentaires authentifié

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)
- Composer (optionnel)
- Extension PHP GD

## 🛠️ Installation

1. Cloner le projet
```bash
git clone <votre-repo>
cd porteflio-with-back-end
```

2. Installer les dépendances via Composer
```bash
composer install
```

3. Configurer la base de données
- Créer une base de données MySQL nommée `tutolabpro`
- Importer le fichier `database.sql`
```bash
mysql -u root -p tutolabpro < database.sql
```

4. Configurer l'application
- Copier le fichier `config.example.php` vers `config.php`
- Modifier les paramètres de connexion dans `config.php`

5. Créer les dossiers nécessaires et définir les permissions
```bash
mkdir -p assets/images/projects
chmod 777 assets/images
```

6. Générer l'image par défaut
```bash
php create_default_image.php
```

7. Remplir la base de données avec des données de test
```bash
php database_seeder.php
```

## 📁 Structure du Projet

```
tutolabpro/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── includes/
│   ├── Database.php
│   ├── functions.php
│   └── handle_comment.php
├── vendor/           # Dépendances Composer
├── composer.json
├── composer.lock
├── config.php
├── database.sql
├── index.php
├── project.php
├── login.php
└── logout.php
```

## ⚙️ Configuration

Le fichier `config.php` contient les paramètres suivants :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'votre_base_de_donnees');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
define('DEBUGGING', false);
define('SYS_URL', 'http://votre-domaine.com/');
define('DEFAULT_LOCALE', 'fr');
```

## 🎨 Personnalisation

### Thème
- Modifiez les couleurs dans `assets/css/styles.css`
- Personnalisez les polices dans `index.php`

### Contenu
- Ajoutez/modifiez les données dans la base de données
- Personnalisez les sections dans `index.php`

## 🔒 Sécurité

- Protection contre les injections SQL via PDO
- Échappement des données affichées
- Gestion sécurisée des mots de passe
- Protection XSS

## 🌐 Support Multilingue

Le projet supporte le multilingue via la constante `DEFAULT_LOCALE`. Pour ajouter une nouvelle langue :

1. Créez un fichier de traduction dans `assets/locales/`
2. Modifiez `DEFAULT_LOCALE` dans `config.php`

## 🐛 Mode Debug

Activez le mode debug dans `config.php` pour afficher les erreurs :

```php
define('DEBUGGING', true);
```

## 🖼️ Gestion des Images

1. Créer le dossier des images de projets :
```bash
mkdir -p assets/images/projects
```

2. Générer l'image par défaut :
```bash
php create_default_image.php
```

3. Générer les images de démonstration des projets :
```bash
php create_project_images.php
```

Les images générées seront :
- Une image par défaut pour les projets sans image
- 10 images de démonstration pour les projets avec des couleurs différentes
- Les dimensions des images sont 800x600 pixels

## 📝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👥 Auteurs

- Votre Nom - [@votre_twitter](https://twitter.com/votre_twitter)

## 🙏 Remerciements

- [Bootstrap](https://getbootstrap.com/)
- [Font Awesome](https://fontawesome.com/)
- [GitHub Calendar](https://github.com/IonicaBizau/github-calendar)
- [GitHub Activity Feed](https://github.com/caseyscarborough/github-activity)
- [jQuery](https://jquery.com/)

## 📄 Système de commentaires

Le système de commentaires permet aux utilisateurs connectés de commenter les projets :

### 🚀 Fonctionnalités
- Authentification requise pour commenter
- Commentaires en temps réel avec AJAX
- Affichage du nom d'utilisateur et de la date
- Protection contre les injections SQL et XSS
- Gestion des sessions sécurisée

### 📋 Utilisation
1. Créez un compte utilisateur dans la base de données :
```sql
INSERT INTO users (username, email, password) 
VALUES ('votre_username', 'votre@email.com', '$2y$10$votre_hash_password');
```

2. Connectez-vous avec vos identifiants
3. Accédez à un projet pour voir et ajouter des commentaires

### 🔒 Sécurité
- Protection contre les injections SQL avec PDO
- Protection XSS avec htmlspecialchars()
- Mots de passe hashés avec password_hash()
- Sessions sécurisées
- Validation des données côté serveur