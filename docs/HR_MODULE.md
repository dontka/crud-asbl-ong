# Module de Gestion des Ressources Humaines (RH) - ASBL-ONG

## 📋 Vue d'ensemble

Le module RH est une solution complète de gestion du personnel et des ressources humaines, intégrée à la plateforme CRUD ASBL-ONG. Il permet la gestion centralisée de tous les aspects RH de l'organisation.

## 🎯 Fonctionnalités Principales

### 1. **Gestion des Dossiers Salariés**
- Création et modification des fiches employés
- Stockage des informations personnelles et professionnelles
- Historique d'emploi et statuts
- Gestion des contrats par employé
- Suivi des compétences et formations

**Routes:**
- `GET /hr` - Liste des employés
- `GET /hr/create` - Formulaire de création
- `POST /hr/store` - Enregistrement d'un nouvel employé
- `GET /hr/{id}` - Détails d'un employé
- `GET /hr/{id}/edit` - Modification d'un employé
- `PUT /hr/{id}` - Mise à jour d'un employé

### 2. **Gestion des Contrats**
- Types de contrats: CDI, CDD, Stage, Alternance, Freelance
- Suivi des dates d'échéance
- Périodes d'essai
- Alertes de renouvellement
- Archivage des contrats

**Accès:** Menu Sidebar > Gestion RH > Gestion Contrats

### 3. **Gestion des Absences et Congés**
- Types d'absence: Congé, Maladie, Absence Justifiée/Non Justifiée, Télétravail, Formations
- Workflow d'approbation des demandes
- Suivi des soldes de congés annuels
- Détection des chevauchements d'absences
- Historique complet avec commentaires

**Routes:**
- `GET /hr/absences` - Liste des absences
- `GET /hr/absences/{id}` - Détails d'une absence
- `POST /hr/absences/{id}/approve` - Approbation d'une absence
- `POST /hr/absences/{id}/reject` - Rejet d'une absence

### 4. **Gestion du Pointage**
- Enregistrement des heures travaillées
- Suivi des heures supplémentaires
- Validation par les managers
- Export pour la paie

### 5. **Gestion des Compétences**
- Catalogue des compétences par catégorie
- Profils de compétences par employé
- Niveaux de maîtrise: Novice, Intermédiaire, Expert, Master
- Dates d'acquisition et d'expiration

### 6. **Gestion des Formations**
- Catalogue des formations internes et externes
- Types: Interne, Externe, Online, Conférence
- Suivi des participations
- Certifications obtenues
- Évaluations post-formation

**Routes:**
- `GET /hr/trainings` - Liste des formations
- Détails et inscription aux formations

### 7. **Évaluations Annuelles**
- Critères d'évaluation: Connaissance, Performance, Travail d'équipe, Communication, Initiative, Ponctualité
- Scores 1-5 avec calcul automatique de la moyenne
- Commentaires: Forces, Points d'amélioration, Objectifs de carrière
- Statuts: Brouillon, Soumis, Examiné, Finalisé

**Routes:**
- `GET /hr/evaluations` - Liste des évaluations
- `GET /hr/evaluations/{id}/create` - Créer une évaluation
- `POST /hr/evaluations` - Enregistrer une évaluation

### 8. **Tableau de Bord RH**
- Statistiques clés: Nombre d'employés, Congés du jour, Approbations en attente
- Activités récentes
- Vue d'ensemble par département
- Actions rapides d'accès

**Route:** `GET /hr/dashboard`

## 🗄️ Structure de la Base de Données

### Tables Principales

```sql
-- Employés
CREATE TABLE employees (
  id, user_id, first_name, last_name, email, phone, birth_date,
  position, department, hire_date, employment_status, employment_type,
  manager_id, salary_gross, ...
)

-- Contrats
CREATE TABLE contracts (
  id, employee_id, contract_type, contract_number, start_date, end_date,
  renewal_date, status, salary, ...
)

-- Absences
CREATE TABLE absences (
  id, employee_id, absence_type, start_date, end_date, duration_days,
  status, reason, manager_id, ...
)

-- Soldes de congés
CREATE TABLE leave_balances (
  id, employee_id, year, annual_leave_days, taken_leave_days,
  remaining_leave_days, ...
)

-- Pointage
CREATE TABLE timekeeping (
  id, employee_id, date, check_in, check_out, worked_hours,
  status, validated, ...
)

-- Compétences
CREATE TABLE skills (
  id, name, category, description
)

CREATE TABLE employee_skills (
  id, employee_id, skill_id, proficiency_level, acquired_date, ...
)

-- Formations
CREATE TABLE trainings (
  id, name, provider, training_type, start_date, end_date,
  duration_hours, cost, status, ...
)

CREATE TABLE employee_trainings (
  id, employee_id, training_id, status, score,
  certification_obtained, certification_date, ...
)

-- Évaluations
CREATE TABLE evaluations (
  id, employee_id, evaluator_id, evaluation_year,
  job_knowledge, performance, teamwork, communication, initiative,
  attendance, overall_score, ...
)

-- Paie
CREATE TABLE payroll (
  id, employee_id, payroll_month, payroll_year, salary_gross,
  bonuses, deductions, taxes, salary_net, ...
)

-- Recrutement
CREATE TABLE recruitment_offers (
  id, title, description, department, contract_type,
  salary_range_min, salary_range_max, posting_date, closing_date, ...
)

CREATE TABLE recruitment_candidates (
  id, offer_id, first_name, last_name, email, phone,
  cv_path, application_date, status, ...
)

CREATE TABLE interviews (
  id, candidate_id, interviewer_id, interview_date,
  interview_type, feedback, rating, ...
)
```

## 📁 Structure des Fichiers

```
/controllers/
  └── HRController.php

/models/
  ├── Employee.php
  ├── Contract.php
  ├── Absence.php
  ├── Evaluation.php
  ├── Skill.php
  └── Training.php

/views/
  └── /hr/
      ├── dashboard.php
      ├── /employees/
      │   ├── index.php
      │   ├── show.php
      │   ├── create.php
      │   └── edit.php
      ├── /absences/
      │   ├── index.php
      │   └── show.php
      ├── /evaluations/
      │   ├── index.php
      │   └── create.php
      ├── /contracts/
      │   └── index.php
      └── /trainings/
          └── index.php

/database/
  └── /migrations/
      └── 002_create_hr_tables.sql
```

## 🔐 Gestion des Rôles et Permissions

Rôles ayant accès au module RH:
- `admin` - Accès complet
- `moderator` - Accès complet
- `hr_manager` - Gestion complète du module
- `hr_supervisor` - Supervision et approbations

## 🚀 Intégration dans le Sidebar

Le module est accessible via le menu latéral:
- **Menu**: Gestion RH (section Fonctionnalités Avancées)
- **Sous-menus**:
  - Dossiers Salariés
  - Gestion Contrats
  - Absences & Congés
  - Paie
  - Recrutement
  - Compétences & Formations
  - Évaluations
  - Tableau de Bord RH

## 📊 Fonctionnalités Avancées à Implémenter

### Court terme
- [ ] Portail salarié (accès aux bulletins de paie, demandes)
- [ ] Gestion des candidatures de recrutement
- [ ] Paie automatisée (calcul, exports)
- [ ] Pointage électronique
- [ ] Rapports RH avancés

### Moyen terme
- [ ] Intégration avec logiciel paie externe
- [ ] Workflow d'onboarding automatisé
- [ ] Évaluations 360°
- [ ] Planification des carrières
- [ ] Conformité RGPD

### Long terme
- [ ] IA pour prédiction de turnover
- [ ] Analyse prédictive des besoins en recrutement
- [ ] Système de recommandations de formations
- [ ] Analytics RH avancées
- [ ] Intégration calendrier HR (iCal)

## 🔧 Installation et Déploiement

### 1. **Créer les tables**
```bash
mysql -u root < database/migrations/002_create_hr_tables.sql
```

### 2. **Vérifier la configuration**
- Assurer que le BASE_URL est correctement configuré
- Vérifier les permissions d'accès au module

### 3. **Accéder au module**
- URL: `http://crud-asbl-ong.test/hr`
- Ou via le menu Sidebar

## 📝 Cas d'Usage Principaux

### Cas 1: Ajouter un nouvel employé
1. Cliquer sur "Ajouter un Employé" (Dashboard ou Sidebar)
2. Remplir le formulaire avec les informations personnelles et d'emploi
3. Cliquer sur "Créer l'Employé"
4. L'employé apparaît dans la liste

### Cas 2: Traiter une demande de congé
1. Aller dans "Absences & Congés"
2. Consulter les demandes en attente
3. Approuver ou rejeter avec commentaires
4. Le solde de congés est automatiquement mis à jour

### Cas 3: Effectuer une évaluation annuelle
1. Aller dans "Évaluations"
2. Cliquer sur "Créer une Évaluation"
3. Remplir les critères de notation
4. Ajouter les commentaires et objectifs
5. Soumettre et finaliser

## 🐛 Dépannage

**Problème**: Les routes HR ne fonctionnent pas
**Solution**: Vérifier que `BASE_URL` est correctement configuré dans `config.php`

**Problème**: Erreur d'accès au module
**Solution**: Vérifier que l'utilisateur a un rôle autorisé (admin, moderator, hr_manager)

**Problème**: Les tables ne sont pas créées
**Solution**: Exécuter le fichier de migration: `mysql -u root < database/migrations/002_create_hr_tables.sql`

## 📞 Support et Documentation

Pour plus d'informations, consultez:
- STRUCTURE_AVANCEE.md
- PLAN_FONCTIONNALITES_AVANCEES.md
- ROLES.md

---

**Dernière mise à jour**: Février 2026
**Version du Module**: 1.0
**Statut**: Production
