# Faker Data Seeder - Résumé d'Installation

## ✅ Installation Complète

La bibliothèque **Faker** a été intégrée au système avec succès pour générer des données fictives réalistes destinées au test et au développement.

### Packages Installés

```
fakerphp/faker v1.24.1 - Générateur de données fictives pour PHP
```

Tous les packages ont été installés via `composer install` et sont disponibles dans le dossier `vendor/`.

---

## 📊 Données Générées

### Utilisateurs (15 au total)
- **Colonnes**: username, password (hash), email, rôle, timestamps
- **Rôles aléatoires**: admin, moderator, visitor
- **Mot de passe par défaut**: `password123` (hashé en bcrypt)

### Employés (20 au total)
- **Colonnes**: prénom, nom, email, téléphone, date d'embauche, statut, adresse
- **Statuts aléatoires**: active, inactive, archived
- **Dates d'embauche**: 0-10 ans dans le passé

### Contrats (20 au total)
- **Types de contrats**: CDI, CDD, Stage, Autre
- **Statuts aléatoires**: actif, terminé, suspendu
- **Dates**: dates de début/fin cohérentes avec les employés

---

## 🚀 Utilisation Rapide

### Générer TOUTES les données

```bash
php seed.php --all
```

Cela génère 15 utilisateurs, 20 employés et 20 contrats en une seule commande.

### Générer données individuelles

```bash
php seed.php --users        # 15 utilisateurs uniquement
php seed.php --employees    # 20 employés uniquement
php seed.php --contracts    # 20 contrats uniquement
```

### Menu Interactif (optionnel)

```bash
php seed-menu.php
```

Ouvre un menu interactif avec options:
- Générer utilisateurs/employés/contrats
- Afficher statistiques DB
- Vider toutes les données de test

---

## 📁 Fichiers Créés

| Fichier | Description |
|---------|-------------|
| `composer.json` | Configuration Composer avec Faker |
| `composer.lock` | Versions exactes des dépendances |
| `seed.php` | Script CLI pour générer les données |
| `seed-menu.php` | Menu interactif pour le seeding |
| `FAKER_GUIDE.md` | Documentation détaillée |

---

## 🔧 Configuration

Les scripts utilisent la configuration existante:
- `config.php` - Paramètres DB (HOST, USER, PASS, NAME)
- `models/Database.php` - Singleton pattern pour connexion DB
- `autoloader.php` - Chargement automatique des classes

---

## 📈 Vérification des Données

Après seeding, vérifiez dans une requête SQL:

```sql
SELECT COUNT(*) FROM users;           -- doit afficher 15
SELECT COUNT(*) FROM employes;        -- doit afficher 20
SELECT COUNT(*) FROM contrats;        -- doit afficher 20
```

Ou via le menu:
```bash
php seed-menu.php
# Sélectionner l'option 5 pour voir les statistiques
```

---

## 🎯 Cas d'Utilisation

✅ **Développement**: Testez rapidement vos fonctionnalités sans données manuelles  
✅ **Tests**: Vérifiez la pagination, filtrage, recherche avec vraies données  
✅ **Démo**: Montrez des données réalistes aux stakeholders  
✅ **CI/CD**: Remplissez automatiquement la DB pour les tests d'intégration  

---

## ⚠️ Important

- **Pas pour la production!** Les données générées ne doivent être utilisées que pour le développement/test
- Les données sont générées de manière aléatoire - vous verrez des noms différents à chaque exécution
- **Sauvegardez d'abord** si vous avez d'importantes données existantes

---

## 📚 Ressources

- **Faker Documentation**: https://fakerphp.github.io/
- **Faker GitHub**: https://github.com/FakerPHP/Faker
- **Locales supportées**: fr_FR (français), en_US, de_DE, etc.

---

## 🆘 Dépannage

**Q: "No active employees found"**  
A: Générez d'abord les employés avant les contrats:
```bash
php seed.php --employees
php seed.php --contracts
```

**Q: Erreur de connexion DB**  
A: Vérifiez `config.php` et que MySQL est en cours d'exécution

**Q: Réinstaller Faker?**  
A: 
```bash
composer install --no-cache
php seed.php --all
```

---

**Version**: 1.0  
**Date**: Février 2026  
**Maintenance**: Voir FAKER_GUIDE.md pour plus de détails
