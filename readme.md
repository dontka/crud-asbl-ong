# 🚀 CRUD ASBL-ONG - Système de Gestion

[![PHP Version](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL Version](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-98C511?style=for-the-badge)](LICENSE)
[![Version](https://img.shields.io/badge/Version-1.0-FF6B35?style=for-the-badge)](https://github.com/your-org/crud-asbl-ong)

> **Un système de gestion complet et sécurisé pour associations à but non lucratif (ASBL) et organisations non gouvernementales (ONG)**

---

## 📋 Table des Matières

- [✨ Vue d'ensemble](#-vue-densemble)
- [🎯 Fonctionnalités](#-fonctionnalités)
- [🛠️ Technologies](#️-technologies)
- [📦 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [🚀 Utilisation](#-utilisation)
- [🏗️ Architecture](#️-architecture)
- [📊 Scripts et Outils](#-scripts-et-outils)
- [🔧 Développement](#-développement)
- [🌐 Déploiement](#-déploiement)
- [🤝 Contribution](#-contribution)
- [📞 Support](#-support)
- [📄 Licence](#-licence)

---

## ✨ Vue d'ensemble

CRUD ASBL-ONG est une plateforme web complète développée en **PHP pur** (sans framework) pour la gestion efficace des organisations à but non lucratif. Le système offre une interface intuitive pour gérer les membres, événements, projets et dons avec un focus sur la sécurité, la performance et l'évolutivité.

### 🎯 Cas d'usage
- **Associations caritatives** : Gestion des bénévoles et dons
- **Clubs sportifs** : Organisation d'événements et suivi des membres
- **Organisations environnementales** : Gestion de projets et campagnes
- **Groupes communautaires** : Coordination d'activités et communication

---

## 🎯 Fonctionnalités

### 👥 Gestion des Membres
- ✅ Inscription et gestion des profils
- ✅ Suivi des adhésions et statuts
- ✅ Historique des participations
- ✅ Export des données membres

### 📅 Gestion des Événements
- ✅ Création et organisation d'événements
- ✅ Gestion des inscriptions et présences
- ✅ Notifications automatiques
- ✅ Calendrier intégré

### 🎯 Gestion des Projets
- ✅ Planification et suivi d'avancement
- ✅ Gestion budgétaire
- ✅ Assignation des responsables
- ✅ Rapports de progression

### 💰 Gestion des Dons
- ✅ Suivi des contributions financières
- ✅ Génération de reçus fiscaux
- ✅ Rapports financiers
- ✅ Intégration paiements multiples

### 🔐 Sécurité et Authentification
- ✅ Système de rôles (Admin, Modérateur, Membre)
- ✅ Authentification sécurisée (bcrypt)
- ✅ Protection CSRF et XSS
- ✅ Logs d'audit complets

### 📊 Rapports et Analytics
- ✅ Tableaux de bord personnalisés
- ✅ Exports CSV/PDF/Excel
- ✅ Statistiques en temps réel
- ✅ Rapports automatisés

---

## 🛠️ Technologies

### Backend
```php
🐘 PHP 8.3+          # Langage principal
🗄️  MySQL 8.0+       # Base de données
🔒 PDO               # Accès sécurisé DB
🛡️  OpenSSL          # Chiffrement
```

### Frontend
```html
🌐 HTML5             # Structure
🎨 CSS3              # Styles
⚡ JavaScript ES6+   # Interactivité
🎯 Font Awesome      # Icônes
```

### Outils et Sécurité
```bash
🔧 Composer          # Gestion dépendances
🐙 Git              # Contrôle version
🛡️  CSRF Protection # Sécurité formulaires
🔐 bcrypt           # Hashage mots de passe
📊 phpMyAdmin       # Gestion DB
```

### Environnements Supportés
- ✅ **Développement** : XAMPP, Laragon, WAMP
- ✅ **Production** : Apache/Nginx + MySQL
- ✅ **Cloud** : Compatible AWS, DigitalOcean, etc.

---

## 📦 Installation

### Prérequis Système
- **PHP** : 8.3 ou supérieur
- **MySQL** : 8.0 ou supérieur
- **Serveur Web** : Apache/Nginx
- **Extensions PHP** : `pdo`, `pdo_mysql`, `mbstring`, `session`, `json`, `openssl`

### Installation Automatisée (Recommandée)

```bash
# 1. Cloner le repository
git clone https://github.com/your-org/crud-asbl-ong.git
cd crud-asbl-ong

# 2. Installer les dépendances (si applicable)
composer install

# 3. Configurer l'environnement
cp config.php.example config.php
# Éditer config.php avec vos paramètres

# 4. Initialiser la base de données
php migrate.php migrate

# 5. Charger les données de test
mysql -u username -p database_name < database/test_data.sql

# 6. Vérifier l'installation
php tests/validate_environment.php

# 7. Accéder au système
# http://localhost/crud-asbl-ong/
```

### Installation Manuelle

```bash
# Télécharger et extraire l'archive
wget https://github.com/your-org/crud-asbl-ong/archive/main.zip
unzip main.zip
cd crud-asbl-ong-main

# Configuration manuelle...
```

### Vérification Post-Installation

Visitez `http://localhost/crud-asbl-ong/tests/validate_environment.php` pour vérifier :
- ✅ Connexion base de données
- ✅ Permissions fichiers
- ✅ Extensions PHP
- ✅ Configuration système

---

## ⚙️ Configuration

### Fichier Principal (`config.php`)

```php
<?php
// Configuration de base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_asbl_ong');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_secure_password');

// Configuration application
define('APP_NAME', 'CRUD ASBL-ONG');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // development | staging | production

// Sécurité
define('SECRET_KEY', 'your-secret-key-here');
define('SESSION_LIFETIME', 3600); // 1 heure

// Chemins
define('BASE_URL', 'http://localhost/crud-asbl-ong');
define('UPLOAD_PATH', __DIR__ . '/uploads/');
```

### Variables d'Environnement (`.env`)

```bash
# Base de données
DB_HOST=localhost
DB_NAME=crud_asbl_ong
DB_USER=db_user
DB_PASS=secure_password

# Application
APP_ENV=production
DEBUG_MODE=false
LOG_LEVEL=warning

# Sécurité
SECRET_KEY=your-super-secret-key
CSRF_TOKEN_LIFETIME=3600

# Email (optionnel)
SMTP_HOST=smtp.gmail.com
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password
```

### Permissions Fichiers

```bash
# Permissions sécurisées
chmod 755 .htaccess
chmod 644 *.php
chmod 644 assets/css/*.css
chmod 644 assets/js/*.js
chmod 755 uploads/
chmod 755 logs/
```

---

## 🚀 Utilisation

### Premiers Pas

1. **Accès initial** : `http://localhost/crud-asbl-ong/`
2. **Connexion admin** : `admin` / `admin123`
3. **Documentation** : `/documentation`

### Interface Utilisateur

#### Tableau de Bord
- 📊 Vue d'ensemble des activités
- 👥 Statistiques des membres
- 📅 Événements à venir
- 💰 État des dons

#### Navigation
- **Membres** : Gestion complète des adhérents
- **Événements** : Organisation et suivi
- **Projets** : Planification et monitoring
- **Dons** : Suivi financier
- **Utilisateurs** : Administration (admin uniquement)

### Raccourcis Clavier
- `Ctrl + S` : Sauvegarder (formulaires)
- `Ctrl + F` : Recherche
- `Échap` : Annuler/Fermer
- `F5` : Actualiser

### API REST (Optionnel)

```bash
# Exemples d'endpoints
GET  /api/members     # Liste membres
POST /api/members     # Créer membre
GET  /api/events      # Liste événements
POST /api/donations   # Enregistrer don
```

---

## 🏗️ Architecture

### Pattern MVC (Modèle-Vue-Contrôleur)

```
📁 controllers/          # Logique métier
├── Controller.php      # Classe de base
├── UserController.php  # Gestion utilisateurs
├── MemberController.php
├── EventController.php
├── ProjectController.php
└── DonationController.php

📁 models/              # Accès données
├── Model.php          # Classe de base
├── Database.php       # Connexion DB
├── User.php
├── Member.php
├── Event.php
├── Project.php
└── Donation.php

📁 views/               # Interface utilisateur
├── header.php
├── footer.php
├── auth/login.php
├── dashboard/index.php
├── members/
├── events/
├── projects/
└── donations/
```

### Structure Complète

```
crud-asbl-ong/
├── 📄 index.php              # Point d'entrée
├── ⚙️  config.php            # Configuration
├── 🔄 autoloader.php         # Chargement classes
├── 📚 config/                # Configs spécifiques
├── 🎮 controllers/           # Contrôleurs
├── 🗄️  models/               # Modèles
├── 🎨 views/                 # Templates
├── 💾 database/              # Schéma & données
├── 🎯 assets/                # CSS, JS, images
├── 🛠️  includes/             # Utilitaires
├── 📋 docs/                  # Documentation
├── 🧪 tests/                 # Tests
└── 📝 *.md                   # Documentation
```

### Flux de Données

```mermaid
graph TD
    A[Utilisateur] --> B[index.php]
    B --> C[Routeur]
    C --> D[Contrôleur]
    D --> E[Modèle]
    E --> F[Base de Données]
    F --> E
    E --> D
    D --> G[Vue]
    G --> H[Template HTML]
    H --> A
```

---

## 📊 Scripts et Outils

### Gestion Base de Données

```bash
# Migrations
php migrate.php migrate           # Appliquer toutes les migrations
php migrate.php rollback 001      # Annuler migration spécifique
php migrate.php status            # État des migrations
php migrate.php create new_table  # Créer nouvelle migration

# Sauvegardes
php scripts/backup_database.php   # Sauvegarde DB
php scripts/backup_files.php      # Sauvegarde fichiers
php scripts/verify_backups.php    # Vérification sauvegardes
```

### Monitoring et Maintenance

```bash
# Système
php monitor.php check             # Vérification complète
php monitor.php info              # Informations système
php monitor.php performance       # Métriques performance

# Maintenance
php scripts/update_system.php     # Mise à jour système
php scripts/cleanup.php           # Nettoyage fichiers temporaires
```

### Développement

```bash
# Tests
php tests/validate_environment.php  # Validation environnement
php tests/run_unit_tests.php        # Tests unitaires

# Outils
php scripts/generate_model.php User  # Générer modèle
php scripts/generate_controller.php User  # Générer contrôleur
```

---

## 🔧 Développement

### Ajouter une Nouvelle Entité

#### 1. Migration Base de Données

```php
// database/migrations.php
'010_add_documents' => [
    'description' => 'Add documents table',
    'up_callback' => function($db) {
        $db->exec("
            CREATE TABLE documents (
                id INT PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                file_path VARCHAR(500),
                uploaded_by INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (uploaded_by) REFERENCES users(id)
            )
        ");
    }
]
```

#### 2. Créer le Modèle

```php
<?php
// models/Document.php
class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = ['title', 'file_path', 'uploaded_by'];

    public function uploader()
    {
        return $this->belongsTo('User', 'uploaded_by');
    }
}
```

#### 3. Créer le Contrôleur

```php
<?php
// controllers/DocumentController.php
class DocumentController extends Controller
{
    public function index()
    {
        $documents = $this->model->all();
        $this->render('documents/index', [
            'documents' => $documents,
            'title' => 'Gestion des Documents'
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation et sauvegarde
            $this->model->create($_POST);
            redirect('/documents');
        }

        $this->render('documents/create', [
            'title' => 'Nouveau Document'
        ]);
    }
}
```

#### 4. Créer les Vues

```php
<!-- views/documents/index.php -->
<div class="container">
    <h1><?php echo $title; ?></h1>
    <a href="/documents/create" class="btn btn-primary">Nouveau Document</a>

    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Uploadé par</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $doc): ?>
            <tr>
                <td><?php echo htmlspecialchars($doc['title']); ?></td>
                <td><?php echo htmlspecialchars($doc['uploader_name']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($doc['created_at'])); ?></td>
                <td>
                    <a href="/documents/download/<?php echo $doc['id']; ?>" class="btn btn-sm btn-info">Télécharger</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
```

#### 5. Ajouter les Routes

```php
// index.php - Ajouter dans le switch
case 'documents':
    handleDocuments();
    break;

// Fonction de gestion
function handleDocuments()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $controller = new DocumentController();
    $action = $_GET['action'] ?? 'index';

    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit($_GET['id'] ?? null);
            break;
        default:
            $controller->index();
            break;
    }
}
```

### Tests et Validation

```php
// tests/DocumentTest.php
class DocumentTest
{
    public function testDocumentCreation()
    {
        $document = new Document();
        $data = [
            'title' => 'Test Document',
            'file_path' => '/uploads/test.pdf',
            'uploaded_by' => 1
        ];

        $result = $document->create($data);
        assert($result > 0, 'Document should be created');
    }
}
```

---

## 🌐 Déploiement

### Environnements

#### Développement
```bash
# Configuration locale
APP_ENV=development
DEBUG_MODE=true
LOG_LEVEL=debug
```

#### Production
```bash
# Configuration production
APP_ENV=production
DEBUG_MODE=false
LOG_LEVEL=warning
```

### Serveur Web - Apache

```apache
# .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Sécurité
<Files "config.php">
    Order Allow,Deny
    Deny from all
</Files>
```

### Serveur Web - Nginx

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/crud-asbl-ong;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Sécurité - Bloquer l'accès aux fichiers sensibles
    location ~ /(config|logs|tests)/ {
        deny all;
        return 404;
    }
}
```

### SSL/TLS (Recommandé)

```bash
# Let's Encrypt (gratuit)
certbot --nginx -d your-domain.com

# Ou certificat payant
# Configuration manuelle dans nginx/apache
```

### Optimisation Performance

```bash
# Cache opcode PHP
php -r "echo 'OPcache enabled: ' . (extension_loaded('opcache') ? 'Yes' : 'No') . PHP_EOL;"

# Compression GZIP
# Configuration dans nginx/apache

# CDN pour les assets statiques
# Cloudflare, AWS CloudFront, etc.
```

### Monitoring Production

```bash
# Logs à surveiller
tail -f logs/error.log
tail -f logs/access.log

# Métriques système
htop
df -h
free -h

# Monitoring applicatif
php monitor.php check
```

---

## 🤝 Contribution

### Processus de Contribution

1. **Fork** le projet
2. **Clone** votre fork : `git clone https://github.com/your-username/crud-asbl-ong.git`
3. **Créez** une branche : `git checkout -b feature/nouvelle-fonctionnalite`
4. **Commitez** vos changements : `git commit -m "Ajout: Nouvelle fonctionnalité"`
5. **Poussez** : `git push origin feature/nouvelle-fonctionnalite`
6. **Créez** une Pull Request

### Standards de Code

#### PHP
```php
<?php
// Utiliser des namespaces
namespace App\Controllers;

// Nommage des classes (PascalCase)
class UserController extends Controller
{
    // Nommage des méthodes (camelCase)
    public function getUserById($id)
    {
        // Utiliser des types de retour
        return $this->model->find($id);
    }
}
```

#### JavaScript
```javascript
// Utiliser ES6+
const userController = {
    // Fonctions fléchées
    getUsers: async () => {
        try {
            const response = await fetch('/api/users');
            return await response.json();
        } catch (error) {
            console.error('Erreur:', error);
        }
    }
};
```

#### CSS
```css
/* BEM Methodology */
.user-card {
    border: 1px solid #ddd;
}

.user-card__title {
    font-size: 1.2rem;
    font-weight: bold;
}

.user-card--featured {
    border-color: #007bff;
}
```

### Tests

```bash
# Avant de commiter
php tests/validate_environment.php
php tests/run_unit_tests.php

# Tests de performance
php tests/performance_test.php

# Tests de sécurité
php tests/security_test.php
```

---

## 📞 Support

### 📚 Documentation

- **[Guide Utilisateur](USER_GUIDE.md)** - Utilisation quotidienne
- **[Documentation Technique](TECHNICAL_DOC.md)** - Architecture et développement
- **[Plan de Maintenance](MAINTENANCE_PLAN.md)** - Administration système
- **[Guide de Connexion](LOGIN_GUIDE.md)** - Identifiants et accès

### 🐛 Signaler un Bug

1. **Vérifiez** la documentation
2. **Recherchez** dans les issues existantes
3. **Créez** une nouvelle issue avec :
   - Description détaillée
   - Étapes de reproduction
   - Environnement (PHP, MySQL, OS)
   - Logs d'erreur

### 💬 Questions

- **Forum** : [GitHub Discussions](https://github.com/your-org/crud-asbl-ong/discussions)
- **Email** : schor@alwaysdata.net
- **Chat** : Discord/Slack (lien à venir)

### 🚨 Urgences

Pour les problèmes critiques :
- **Sécurité** : schor@alwaysdata.net
- **Disponibilité** : schor.alwaysdata.net
- **Téléphone** : +243 973 768 153 (heures ouvrables)

---

## 📄 Licence

```text
MIT License

Copyright (c) 2026 CRUD ASBL-ONG Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 🙏 Remerciements

### Contributeurs
- **Équipe de développement** : Merci pour le code de qualité
- **Testeurs** : Pour les retours précieux
- **Communauté** : Pour le support et les suggestions

### Technologies Open Source
- **PHP** : Pour le langage robuste
- **MySQL** : Pour la base de données fiable
- **Font Awesome** : Pour les icônes élégantes
- **Composer** : Pour la gestion des dépendances

### Inspirations
- **Symfony/Laravel** : Pour les patterns MVC
- **Bootstrap** : Pour l'inspiration UI/UX
- **WordPress** : Pour la simplicité d'utilisation

---

## 📈 Roadmap

### Version 1.1 (Q2 2026)
- [ ] API REST complète
- [ ] Interface mobile responsive
- [ ] Notifications email automatiques
- [ ] Intégration paiements en ligne

### Version 1.2 (Q3 2026)
- [ ] Module de communication interne
- [ ] Système de tâches et workflow
- [ ] Analytics avancés
- [ ] Support multi-langues

### Version 2.0 (Q4 2026)
- [ ] Migration vers framework moderne
- [ ] Microservices architecture
- [ ] Intelligence artificielle
- [ ] Applications mobiles natives

---

<div align="center">

**Développé avec ❤️ pour les associations et ONG du monde entier**

---

[![GitHub stars](https://img.shields.io/github/stars/your-org/crud-asbl-ong?style=social)](https://github.com/your-org/crud-asbl-ong/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/your-org/crud-asbl-ong?style=social)](https://github.com/your-org/crud-asbl-ong/network/members)
[![GitHub issues](https://img.shields.io/github/issues/your-org/crud-asbl-ong?style=social)](https://github.com/your-org/crud-asbl-ong/issues)

**⭐ Si ce projet vous aide, n'hésitez pas à lui donner une étoile !**

</div>
