# Faker Data Seeder

Ce script génère des données fictives réalistes pour faciliter les tests et le développement du système CRUD ASBL/ONG.

## Installation

La bibliothèque Faker a déjà été installée via Composer :

```bash
composer install
```

## Utilisation

### Générer toutes les données fictives

```bash
php seed.php --all
```

### Générer uniquement certains types de données

```bash
# Générer des utilisateurs fictifs
php seed.php --users

# Générer des employés fictifs
php seed.php --employees

# Générer des contrats fictifs
php seed.php --contracts
```

### Combiner plusieurs types

```bash
php seed.php --users --employees --contracts
```

## Données Générées

### Utilisateurs (--users)
- **Quantité**: 15 utilisateurs
- **Champs**: prénom, nom, email, mot de passe (password123), téléphone, rôle, statut
- **Rôles aléatoires**: admin, moderator, hr_manager, user, volunteer
- **Statut**: active ou inactive

### Employés (--employees)
- **Quantité**: 20 employés
- **Champs**: informations personnelles, date d'embauche, département, position, salaire
- **Départements**: HR, Finance, IT, Operations, Management, Marketing, Support, Development
- **Salaire**: entre €25,000 et €80,000
- **Statut d'emploi**: active, inactive, on_leave

### Contrats (--contracts)
- **Quantité**: jusqu'à 25 contrats
- **Types de contrats**: CDI, CDD, Stage, Temporaire, Freelance
- **Informations**: dates de début/fin, période d'essai, numéro de contrat unique
- **Salaire**: entre €28,000 et €75,000
- **Heures de travail**: 35h, 37.5h ou 40h par semaine

## Caractéristiques

✅ **Données réalistes** - Utilise Faker pour générer des données authentiques  
✅ **Locale française** - Noms, villes et formats en français  
✅ **Relations d'entités** - Les contrats sont liés à des employés existants  
✅ **Gestion d'erreurs** - Avertissements si certaines données ne peuvent pas être générées  
✅ **Flexible** - Générer tout ou sélectionner des types spécifiques  

## Exemples

### Première utilisation (développement initial)
```bash
php seed.php --all
```
Cela génère 15 utilisateurs, 20 employés et 25 contrats.

### Après une suppression accidentelle
```bash
php seed.php --employees --contracts
```
Cela régénère les employés et contrats manquants.

### Tester un formulaire utilisateur
```bash
php seed.php --users
```
Cela ajoute 15 nouveaux utilisateurs de test.

## Notes Importantes

⚠️ **Sauvegardes** - Assurez-vous d'avoir une sauvegarde avant de générer des données en masse  
⚠️ **Doublons** - Il est possible que des emails générer aléatoirement existent déjà  
⚠️ **Performance** - Générer beaucoup de données peut prendre du temps  

## Dépannage

### "No active employees found"
Solution : Générez d'abord les employés avant les contrats
```bash
php seed.php --employees
php seed.php --contracts
```

### Erreurs de connexion à la base de données
Vérifiez que:
- MySQL/MariaDB est en cours d'exécution
- Les paramètres de connexion dans `config.php` sont corrects
- La base de données existe

### Vérifier les données générées
```sql
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM employees;
SELECT COUNT(*) FROM contracts;
```

## Fichiers de Configuration

Le seeder utilise les fichiers suivants :
- `vendor/autoload.php` - Autoload Composer
- `autoloader.php` - Autoload des classes personnalisées
- `config.php` - Configuration de la base de données

## Besoin d'aide?

Pour plus d'informations sur Faker:
- Documentation officielle: https://fakerphp.github.io/
- GitHub: https://github.com/FakerPHP/Faker
