# 🎯 Système de Données Fictives avec Faker

## 📋 Résumé

J'ai intégré la bibliothèque **Faker** pour générer automatiquement des données fictives réalistes. Cela permet de tester rapidement l'application sans saisir manuellement des données.

## 📦 Qu'a été installé ?

### 1. Dépendances
```bash
✅ fakerphp/faker v1.24.1 - Générateur de données fictives
✅ symfony/deprecation-contracts v3.6.0
✅ psr/container v2.0.2
```

### 2. Fichiers Créés

| Fichier | Description |
|---------|-------------|
| `database/seeds/FakerSeeder.php` | Classe principale de seeding |
| `controllers/SeedController.php` | Contrôleur pour l'interface web |
| `views/admin/seeding.php` | Interface web de seeding |
| `seed.php` | Script CLI pour exécution en ligne de commande |
| `docs/FAKER_SEEDING.md` | Documentation complète |

### 3. Routes Ajoutées

| Route | Méthode | Description |
|-------|---------|-------------|
| `/seed` | GET | Page d'interface de seeding (admin) |
| `/seed/generate` | POST | Générer les données fictives |

## 🚀 Utilisation Rapide

### Option 1️⃣ : Interface Web
```
URL: http://crud-asbl-ong.test/seed
1. Cochez la confirmation
2. Cliquez sur "Générer les Données Fictives"
3. Attendez la completion
```

### Option 2️⃣ : Ligne de Commande
```bash
cd c:\laragon\www\crud-asbl-ong
php seed.php seed
```

### Option 3️⃣ : API REST
```bash
curl -X POST http://crud-asbl-ong.test/seed/generate \
  -d "confirm=yes"
```

## 📊 Données Générées

### Volume Total: 227+ enregistrements

```
✓ 15 Utilisateurs    - Rôles variés (admin, manager, employee, member)
✓ 25 Employés        - Positions, salaires, dates réalistes
✓ 30 Contrats        - Types variés (CDI, CDD, Stage, etc.)
✓ 40 Absences        - Types et statuts variés
✓ 50 Membres         - Donateurs, bénévoles, partenaires
✓ 12 Projets         - Budgets, statuts, progression
✓ 15 Événements      - Types et dates variés
✓ 60 Donations       - Montants et statuts variés
```

## 🎨 Caractéristiques Principales

### ✨ Points Forts
- **Données Réalistes** : Noms, adresses, emails en français
- **Relations Correctes** : Les clés étrangères sont respectées
- **Données Uniques** : Pas de doublons pour les champs uniques
- **Multi-Accès** : Web, CLI, ou API REST
- **Sécurité** : Accès admin uniquement
- **Idempotent** : Peut être lancé plusieurs fois sans erreur

### ⚙️ Localisation
- 🇫🇷 Locale française (fr_FR)
- 👤 Noms français réalistes
- 📍 Villes et adresses belges
- 🏢 Contexte ASBL-ONG

## 📝 Exemples de Données

### Utilisateurs
```
Email: jean.dupont@asbl-ong.test
Mot de passe: password123
Rôle: manager
Statut: active
```

### Employés
```
Nom: Marie Martin
Position: Developer
Salaire: 52,000€
Type d'emploi: full-time
Embauché: 2022-05-15
```

### Contrats
```
Employé: Marie Martin
Type: CDI
Début: 2022-05-15
Salaire: 52,000€
Heures: 35h/semaine
Essai: 90 jours
```

### Absences
```
Employé: Jean Dupont
Type: vacation
Début: 2026-06-15
Fin: 2026-06-29
Statut: approved
```

### Donations
```
Montant: €750
Devise: EUR
Date: 2025-11-20
Statut: received
```

## 🔧 Configuration

### Modifier les Quantités

Éditez `database/seeds/FakerSeeder.php` :

```php
private function seedUsers() {
    $count = 15;  // ← Changez ce nombre
    // ...
}
```

### Ajouter de Nouvelles Entités

Créez une nouvelle méthode :

```php
private function seedTrainings() {
    echo "📚 Génération des formations fictives...\n";
    
    $count = 20;
    
    for ($i = 1; $i <= $count; $i++) {
        $stmt = $this->pdo->prepare("
            INSERT INTO trainings (title, description, start_date, end_date, status) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $this->faker->jobTitle(),
            $this->faker->paragraph(),
            $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            $this->faker->randomElement(['planned', 'in_progress', 'completed'])
        ]);
    }
    
    echo "   ✓ $count formations créées\n";
}
```

Puis appelez-la dans `seed()` :
```php
$this->seedTrainings();
```

## 🛡️ Sécurité

### Restrictions
- ❌ Accès admin uniquement (interface web)
- ❌ Confirmation requise
- ❌ Pas d'exécution automatique
- ✅ Audit trail des générations

### Données Sensibles
- Mots de passe hashés (bcrypt)
- Pas d'informations réelles sensibles
- Destiné à un environnement de développement

## 🗑️ Suppression des Données

### Option 1: Via SQL
```sql
TRUNCATE TABLE users;
TRUNCATE TABLE employees;
TRUNCATE TABLE contracts;
-- etc.
```

### Option 2: Réinstaller la Base
```bash
php install.php
```

### Option 3: Suppression Sélective
```sql
DELETE FROM employees WHERE employee_number LIKE 'EMP-%';
```

## 📚 Documentation Complète

Pour plus de détails, consultez : `docs/FAKER_SEEDING.md`

## 🔗 Ressources

- **Faker Documentation** : https://fakerphp.github.io/
- **GitHub** : https://github.com/fakerphp/faker
- **Locales** : 50+ langues supportées

## ✅ Validation

Tous les fichiers ont été validés :
```
✓ database/seeds/FakerSeeder.php - Pas d'erreur
✓ controllers/SeedController.php - Pas d'erreur
✓ views/admin/seeding.php - Pas d'erreur
✓ seed.php - Pas d'erreur
✓ core/router.php - Pas d'erreur
```

## 🎓 Cas d'Usage

### 1. Développement Frontend
```bash
php seed.php seed
# Puis tester les pages avec des vraies données
```

### 2. Tests de Performance
```bash
# Générer les données
php seed.php seed
# Tester les requêtes et les performances
```

### 3. Démonstration Client
```bash
# Générer des données impressionnantes
php seed.php seed
# Montrer l'application avec des données réalistes
```

### 4. Tests d'Intégration
```bash
# Générer des données pour les tests
php seed.php seed
# Lancer les tests
```

## 📞 Support

Pour des questions sur le système de seeding :

1. Consultez `docs/FAKER_SEEDING.md`
2. Vérifiez les logs d'erreur
3. Testez via la ligne de commande d'abord

---

**Installé** : Février 2026  
**Statut** : ✅ Prêt à l'emploi  
**Version** : 1.0
