# Documentation Technique - Système CRUD ASBL-ONG

## Architecture du Système

### Vue d'ensemble


Le système CRUD ASBL-ONG est développé en PHP pur (sans framework) avec une architecture MVC-like (Modèle-Vue-Contrôleur) pour assurer la séparation des préoccupations et la maintenabilité.

### Structure des dossiers

```
crud-asbl-ong/
├── config.php                 # Configuration de base de données et constantes
├── autoloader.php            # Chargeur automatique de classes
├── index.php                 # Point d'entrée principal
├── migrate.php               # Script de migration de base de données
├── prepare_deployment.php    # Script de préparation au déploiement
├── monitor.php               # Script de monitoring système
├── env.php                   # Gestionnaire d'environnement
├── config/
│   ├── architecture.php      # Définition de l'architecture
│   ├── conceptual_model.php  # Modèle conceptuel
│   └── entities.php          # Définition des entités
├── controllers/              # Contrôleurs MVC
│   ├── Controller.php        # Classe de base contrôleur
│   ├── DashboardController.php
│   ├── UserController.php
│   ├── MemberController.php
│   ├── EventController.php
│   ├── ProjectController.php
│   └── DonationController.php
├── models/                   # Modèles de données
│   ├── Model.php            # Classe de base modèle
│   ├── Database.php         # Gestionnaire de base de données
│   ├── User.php
│   ├── Member.php
│   ├── Event.php
│   ├── Project.php
│   └── Donation.php
├── views/                    # Vues/templates
│   ├── header.php
│   ├── footer.php
│   ├── auth/
│   │   └── login.php
│   ├── dashboard/
│   │   └── index.php
│   ├── users/
│   ├── members/
│   ├── events/
│   ├── projects/
│   └── donations/
├── assets/                   # Ressources statiques
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
├── database/                 # Scripts base de données
│   ├── schema.sql           # Schéma de base de données
│   └── test_data.sql        # Données de test
├── includes/                 # Utilitaires
│   ├── security_headers.php # En-têtes de sécurité
│   ├── csrf.php            # Protection CSRF
│   ├── sanitize.php        # Sanitisation des données
│   └── cache.php           # Système de cache
└── tests/                   # Tests
    └── validate_environment.php
```

## Technologies Utilisées

### Backend
- **PHP 8.1+** : Langage de programmation principal
- **MySQL 8.0+** : Système de gestion de base de données
- **PDO** : Extension PHP pour l'accès aux bases de données

### Frontend
- **HTML5** : Structure des pages
- **CSS3** : Styles et mise en page
- **JavaScript** : Interactivité côté client
- **Font Awesome** : Icônes

### Sécurité
- **bcrypt** : Hachage des mots de passe
- **CSRF Protection** : Protection contre les attaques CSRF
- **Input Sanitization** : Nettoyage des données utilisateur
- **Prepared Statements** : Protection contre les injections SQL

## Architecture MVC

### Modèle (Model)
- Gère l'accès aux données
- Contient la logique métier
- Interagit avec la base de données via PDO

### Vue (View)
- Gère l'affichage des données
- Templates PHP pour la présentation
- Séparation claire entre logique et présentation

### Contrôleur (Controller)
- Gère la logique de l'application
- Traite les requêtes utilisateur
- Coordonne les interactions Modèle-Vue

## Base de Données

### Schéma Principal

```sql
-- Utilisateurs
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'moderator', 'member') DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Membres
CREATE TABLE members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    membership_date DATE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Événements
CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(200),
    max_participants INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Projets
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    budget DECIMAL(10,2),
    status ENUM('planning', 'active', 'completed', 'cancelled') DEFAULT 'planning',
    manager_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (manager_id) REFERENCES users(id)
);

-- Dons
CREATE TABLE donations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    donor_name VARCHAR(100),
    donor_email VARCHAR(100),
    amount DECIMAL(10,2) NOT NULL,
    donation_date DATE DEFAULT CURRENT_DATE,
    project_id INT,
    payment_method ENUM('cash', 'bank_transfer', 'online') DEFAULT 'cash',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL
);
```

## Sécurité

### Mesures Implémentées

1. **Authentification**
   - Hachage des mots de passe avec bcrypt
   - Sessions sécurisées
   - Protection contre les attaques par force brute

2. **Autorisation**
   - Système de rôles (admin, moderator, member)
   - Contrôle d'accès basé sur les rôles
   - Vérification des permissions

3. **Protection des Données**
   - Sanitisation de toutes les entrées utilisateur
   - Utilisation de prepared statements
   - Protection CSRF sur tous les formulaires

4. **Sécurité Infrastructure**
   - En-têtes de sécurité HTTP
   - Protection contre le clickjacking
   - Configuration sécurisée des sessions

## API REST

### Endpoints Disponibles

```
GET    /api/members          # Liste des membres
POST   /api/members          # Créer un membre
GET    /api/members/{id}     # Détails d'un membre
PUT    /api/members/{id}     # Modifier un membre
DELETE /api/members/{id}     # Supprimer un membre

GET    /api/events           # Liste des événements
POST   /api/events           # Créer un événement
GET    /api/events/{id}      # Détails d'un événement
PUT    /api/events/{id}      # Modifier un événement
DELETE /api/events/{id}      # Supprimer un événement

GET    /api/projects         # Liste des projets
POST   /api/projects         # Créer un projet
GET    /api/projects/{id}    # Détails d'un projet
PUT    /api/projects/{id}    # Modifier un projet
DELETE /api/projects/{id}    # Supprimer un projet

GET    /api/donations        # Liste des dons
POST   /api/donations        # Créer un don
GET    /api/donations/{id}   # Détails d'un don
PUT    /api/donations/{id}   # Modifier un don
DELETE /api/donations/{id}   # Supprimer un don
```

### Format de Réponse

```json
{
    "success": true,
    "data": {
        // Données de l'entité
    },
    "message": "Opération réussie"
}
```

## Déploiement

### Prérequis
- PHP 8.1 ou supérieur
- MySQL 8.0 ou supérieur
- Serveur web (Apache/Nginx)
- Composer (optionnel)

### Étapes de Déploiement

1. **Configuration de l'environnement**
   ```bash
   # Cloner le repository
   git clone <repository-url>
   cd crud-asbl-ong

   # Configurer la base de données
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/test_data.sql
   ```

2. **Configuration de l'application**
   ```php
   // config.php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'crud_asbl_ong');
   define('DB_USER', 'your_db_user');
   define('DB_PASS', 'your_db_password');
   ```

3. **Configuration du serveur web**
   ```
   # Apache .htaccess
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php [QSA,L]
   ```

4. **Permissions**
   ```bash
   chmod 755 .
   chmod 644 *.php
   chmod 644 assets/css/*.css
   chmod 644 assets/js/*.js
   ```

## Maintenance

### Sauvegarde
- Sauvegarde automatique quotidienne de la base de données
- Sauvegarde des fichiers de configuration
- Rétention des sauvegardes : 30 jours

### Monitoring
- Surveillance des performances
- Logs d'erreurs et d'accès
- Alertes automatiques

### Mises à Jour
- Migration automatique des données
- Rollback en cas d'échec
- Documentation des changements

## Support et Contact

Pour toute question technique ou support :
- Email : support@asbl-ong.local
- Documentation : /documentation
- Issues : GitHub Issues

---

*Dernière mise à jour : Février 2026*