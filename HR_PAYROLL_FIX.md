# Résolution du problème de redirection /hr/payroll vers /dashboard

## Cause du problème

Le système avait deux problèmes:

1. **Rôles insuffisants dans la base de données**: La table `users` ne supportait que 3 rôles ('admin', 'moderator', 'visitor'), mais le HRController cherchait des rôles comme 'hr_manager', 'hr_supervisor' qui n'existaient pas.

2. **Utilisateurs avec des mots de passe invalides**: Les données de test contenaient des hashes de mots de passe d'exemple qui n'étaient pas valides, rendant impossible la connexion avec un utilisateur valide.

## Solutions apportées

### 1. Extension du schéma des rôles
- **Fichier modifié**: `database/schema.sql`
- **Fichier créé**: `database/migrations/003_extend_user_roles.sql`
- Ajout de 18 nouveaux rôles pour supporter la structure RBAC complète définie dans ROLES.md

### 2. Mise à jour du HRController
- **Fichier modifié**: `controllers/HRController.php`
- Modification de la méthode `hasHRAccess()` pour accepter les rôles:
  - `admin`
  - `moderator`
  - `hr_manager`
  - `supervisor`

### 3. Scripts d'aide créés

#### `setup_users.php`
Crée ou met à jour les utilisateurs de test:
- **admin** / **admin123** (rôle: admin)
- **hr_manager** / **hr123** (rôle: hr_manager)

#### `debug_hr_access.php`
Diagnostique l'accès HR en affichant:
- État de la session actuelle
- Rôle de l'utilisateur connecté
- Rôles autorisés pour HR
- Liste des utilisateurs existants

#### `migrate_roles.php`
Exécute la migration des rôles et affiche le résultat.

## Étapes pour résoudre le problème

### 1. Exécuter la migration des rôles
Accédez à: `http://crud-asbl-ong.test/migrate_roles.php`

### 2. Créer les utilisateurs valides
Accédez à: `http://crud-asbl-ong.test/setup_users.php`

### 3. Tester
- Connectez-vous avec **admin** / **admin123**
- Accédez à `http://crud-asbl-ong.test/hr/payroll`
- Vous devriez voir la page de gestion de la paie

### 4. Déboguer si le problème persiste
Accédez à: `http://crud-asbl-ong.test/debug_hr_access.php`

Cela affichera:
- L'utilisateur actuellement connecté
- Son rôle
- Si cet utilisateur a accès au module HR

## Nouveaux rôles disponibles

Basés sur ROLES.md, les rôles disponibles sont:

1. `admin` - Accès complet
2. `moderator` - Modération de contenu
3. `hr_manager` - Gestion RH
4. `accountant` - Gestion financière
5. `project_manager` - Gestion de projets
6. `crm_officer` - Gestion CRM
7. `member` - Membre standard
8. `volunteer` - Bénévole
9. `guest` - Invité
10. `supervisor` - Supervision
11. `auditor` - Audit
12. `security_officer` - Sécurité
13. `it_officer` - IT/Infrastructure
14. `communication_officer` - Communication
15. `compliance_officer` - Conformité/RGPD
16. `marketplace_officer` - Marketplace
17. `support_officer` - Support
18. `training_officer` - Formation
19. `quality_officer` - Qualité

## Prochaines étapes recommandées

1. Exécuter les scripts de setup dans l'ordre indiqué
2. Tester l'accès avec les différents rôles
3. Mettre à jour les autres contrôleurs pour utiliser les nouveaux rôles si nécessaire
