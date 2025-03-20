# Documentation de l'API

## Authentification

### Connexion
- **URL**: `/login.php`
- **Méthode**: POST
- **Paramètres**:
  - `email`: Email de l'utilisateur
  - `password`: Mot de passe de l'utilisateur
- **Réponse réussie**: Redirection vers la page d'accueil
- **Codes d'erreur**:
  - Champs manquants
  - Email ou mot de passe incorrect
  - Erreur de base de données

### Fonctionnalités de sécurité
- Sessions PHP
- Hachage des mots de passe (SHA1)
- Protection XSS
- Préparation des requêtes SQL

## Points d'attention
- Le système utilise SHA1 pour le hachage des mots de passe
- Les erreurs sont gérées de manière sécurisée en mode production
- Les redirections sont effectuées avec protection contre les redirections non autorisées
