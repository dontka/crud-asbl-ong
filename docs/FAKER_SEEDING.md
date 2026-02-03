# 🌱 Système de Données Fictives (Faker Seeding)

## Description

Le système de seeding utilise la bibliothèque **Faker** pour générer automatiquement des données fictives réalistes pour le développement et les tests. Cela permet de tester rapidement l'application sans saisir manuellement des données.

## Installation

### Prérequis
- PHP 7.4+
- Composer
- MySQL/MariaDB

### Installation de Faker

```bash
cd c:\laragon\www\crud-asbl-ong
composer require fakerphp/faker
```

L'installation a déjà été effectuée lors de la mise en place du système.

## Utilisation

### 1️⃣ Via l'Interface Web (Interface Admin)

Accédez à la page de seeding pour les administrateurs :

```
URL: http://crud-asbl-ong.test/seed
Accès: Admin uniquement
```

**Étapes:**
1. Naviguez vers `/seed` depuis le menu admin
2. Lisez les avertissements
3. Cochez la case de confirmation
4. Cliquez sur "Générer les Données Fictives"
5. Attendez la completion et vérifiez le résultat

### 2️⃣ Via la Ligne de Commande

```bash
# Générer les données fictives
php seed.php seed

# Afficher l'aide
php seed.php --help
```

### 3️⃣ Via API REST

```bash
curl -X POST http://crud-asbl-ong.test/seed/generate \
  -d "confirm=yes" \
  -H "Content-Type: application/x-www-form-urlencoded"
```

## Données Générées

### 📊 Volume Total

**227+ enregistrements** générés automatiquement :

| Entité | Quantité | Description |
|--------|----------|-------------|
| 👤 Utilisateurs | 15 | Roles: admin, manager, employee, member |
| 👥 Employés | 25 | Positions variées, salaires, dates d'embauche |
| 📋 Contrats | 30 | CDI, CDD, Stage, Temporaire, Freelance |
| 🚫 Absences | 40 | Congés, maladie, formation, personnels |
| 👫 Membres | 50 | Donateurs, bénévoles, partenaires, bénéficiaires |
| 📊 Projets | 12 | Budgets, statuts, progression |
| 🎉 Événements | 15 | Conférences, workshops, meetings, etc. |
| 💰 Donations | 60 | Montants variés, statuts, devises |

### 🔍 Détails des Données

#### Utilisateurs
- Noms aléatoires en français
- Emails uniques générés
- Rôles variés (admin: 1, manager: 4, employee: 5, member: 5 environ)
- Mots de passe hashés: `password123`
- Statut: actif

#### Employés
- Prénom et nom en français
- Dates d'embauche entre -5 ans et aujourd'hui
- Dates de naissance entre -60 et -20 ans
- Positions: Developer, Designer, Manager, Coordinator, Analyst, Consultant, Director
- Types d'emploi: full-time, part-time, contract, intern
- Salaires entre 28,000€ et 85,000€
- Adresses complètes (rue, ville, code postal)
- Genre aléatoire
- Numéro d'employé unique

#### Contrats
- Types: CDI, CDD, Stage, Temporaire, Freelance
- Dates de début entre -3 ans et aujourd'hui
- Périodes d'essai: 30, 60, ou 90 jours
- Dates de fin (sauf CDI)
- Postes et salaires
- Heures de travail: 35, 37.5, ou 40h/semaine
- Statuts: active, inactive, ended

#### Absences
- Types: vacation, sick_leave, personal, unpaid_leave, training
- Durées: 1 à 15 jours
- Statuts: approved, rejected, pending
- Raisons générées automatiquement
- Approbateurs attribués (facultatif)

#### Membres
- Noms aléatoires en français
- Types: donor, volunteer, partner, beneficiary
- Dates d'adhésion entre -3 ans et aujourd'hui
- Statuts: active, inactive
- Téléphones (70% des cas)

#### Projets
- Noms de projets générés
- Descriptions complètes
- Dates de début/fin réalistes
- Budgets entre 10,000€ et 500,000€
- Progression: 0-100%
- Statuts variés

#### Événements
- Titres et descriptions
- Types: conference, workshop, meeting, training, celebration, networking
- Dates futures (jusqu'à +12 mois)
- Heures de début/fin
- Lieux variés
- Nombre de participants: 10-500
- Statuts: planned, in_progress, completed, cancelled

#### Donations
- Montants entre 25€ et 5,000€
- Devises: EUR, USD
- Dates entre -12 mois et aujourd'hui
- Statuts: received, pending, cancelled
- Descriptions (60% des cas)

## Caractéristiques

### ✅ Points Forts

- **Générateur Faker** : Crée des données réalistes en français
- **Relations Respectées** : Les clés étrangères sont correctes
- **Données Uniques** : Les emails et numéros sont uniques
- **Facilité d'Utilisation** : Interface Web, CLI, ou API REST
- **Multi-Exécution** : Peut être lancé plusieurs fois sans erreur
- **Sécurité** : Accès Admin uniquement via l'interface Web
- **Audit Trail** : Enregistre les dates de création

### ⚠️ Limitations

- ❌ **Développement Uniquement** : À ne pas utiliser en production
- ❌ **Pas de Suppression** : Le système ne supprime pas les anciennes données
- ❌ **Pas de Configuration** : Les quantités sont fixes
- ❌ **Performance** : Peut être lent avec de grandes quantités

## Configuration Personnalisée

Pour modifier le nombre de données générées, éditez `database/seeds/FakerSeeder.php` :

```php
// Modifiez les variables $count dans chaque méthode
private function seedUsers() {
    $count = 15;  // ← Changer ce nombre
    // ...
}
```

## Suppression des Données Générées

Les données générées peuvent être supprimées de plusieurs manières :

### 1. Suppression Manuelle via SQL
```sql
-- Supprimer les enregistrements récents
TRUNCATE TABLE users;
TRUNCATE TABLE employees;
TRUNCATE TABLE contracts;
TRUNCATE TABLE absences;
TRUNCATE TABLE members;
TRUNCATE TABLE projects;
TRUNCATE TABLE events;
TRUNCATE TABLE donations;
```

### 2. Réinstallation de la Base de Données
```bash
php install.php
```

### 3. Suppression Sélective
```sql
-- Supprimer les utilisateurs fictifs (emails contenant 'asbl-ong.test')
DELETE FROM users WHERE email LIKE '%@asbl-ong.test';

-- Supprimer les employés fictifs
DELETE FROM employees WHERE employee_number LIKE 'EMP-%';
```

## Cas d'Usage

### 1. Tests de Fonctionnalité
- Tester les workflows RH (demandes de congé, contrats)
- Vérifier les calculs de salaire et de paie
- Tester les rapports et tableaux de bord
- Valider les exports de données

### 2. Tests de Performance
- Charger la base de données avec des données réalistes
- Tester les requêtes SQL
- Vérifier les temps de chargement des pages
- Profiler les performances

### 3. Démonstration
- Montrer l'application à des clients
- Tester les workflows complets
- Générer des rapports d'exemple
- Démontrer les statistiques

### 4. Développement Frontend
- Tester les pages avec de vraies données
- Vérifier la responsivité
- Tester les filtres et recherches
- Valider les formulaires

## Ressources

- **Documentation Faker** : https://fakerphp.github.io/
- **GitHub Faker** : https://github.com/fakerphp/faker
- **Locales Supportées** : Faker supporte 50+ locales (fr_FR, en_US, etc.)

## Troubleshooting

### Erreur: "Class 'Faker\Factory' not found"
```bash
# Réinstallez les dépendances
composer install
```

### Erreur: "SQLSTATE[HY000]: General error: 1 General error"
- Vérifiez que la base de données existe
- Vérifiez les permissions MySQL
- Vérifiez que les tables existent

### Erreur: "Access Denied"
- Seuls les administrateurs peuvent générer les données
- Connectez-vous en tant qu'admin
- Vérifiez le rôle de l'utilisateur

### Les données ne sont pas générées
- Vérifiez la console pour les erreurs
- Vérifiez que Faker est installé
- Assurez-vous que la base de données est accessible

## Contribution

Pour améliorer le système de seeding :

1. Ajoutez de nouvelles méthodes dans `FakerSeeder`
2. Générez d'autres types de données (formations, évaluations, etc.)
3. Testez avec différentes quantités
4. Documentez les modifications

## Licence

Ce système fait partie du projet CRUD ASBL-ONG et suit la même licence.

---

**Dernière mise à jour** : Février 2026
**Version** : 1.0
**Statut** : ✅ Stable
