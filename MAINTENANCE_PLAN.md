# Plan de Maintenance - Système CRUD ASBL-ONG

## Vue d'ensemble

Ce document définit les procédures de maintenance, sauvegarde et mise à jour du système CRUD ASBL-ONG. Il assure la disponibilité, la sécurité et la performance continue de la plateforme.

## Sauvegarde Automatique

### Configuration des sauvegardes

#### Sauvegarde de la base de données

**Fréquence :** Quotidienne à 02:00 AM

**Script de sauvegarde :** `backup_database.sh`

```bash
#!/bin/bash

# Configuration
DB_HOST="localhost"
DB_NAME="crud_asbl_ong"
DB_USER="backup_user"
DB_PASS="backup_password"
BACKUP_DIR="/var/backups/crud-asbl-ong"
DATE=$(date +%Y%m%d_%H%M%S)

# Création du répertoire de sauvegarde
mkdir -p $BACKUP_DIR

# Sauvegarde de la base de données
mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Compression
gzip $BACKUP_DIR/db_backup_$DATE.sql

# Nettoyage des anciennes sauvegardes (garde 30 jours)
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +30 -delete

echo "Sauvegarde terminée: $BACKUP_DIR/db_backup_$DATE.sql.gz"
```

#### Sauvegarde des fichiers

**Fréquence :** Hebdomadaire le dimanche à 03:00 AM

**Script de sauvegarde :** `backup_files.sh`

```bash
#!/bin/bash

# Configuration
SOURCE_DIR="/var/www/crud-asbl-ong"
BACKUP_DIR="/var/backups/crud-asbl-ong/files"
DATE=$(date +%Y%m%d)

# Création du répertoire de sauvegarde
mkdir -p $BACKUP_DIR

# Sauvegarde des fichiers (excluant les dossiers temporaires)
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz \
    --exclude='cache/*' \
    --exclude='logs/*' \
    --exclude='*.log' \
    $SOURCE_DIR

# Nettoyage des anciennes sauvegardes (garde 4 semaines)
find $BACKUP_DIR -name "files_backup_*.tar.gz" -mtime +28 -delete

echo "Sauvegarde fichiers terminée: $BACKUP_DIR/files_backup_$DATE.tar.gz"
```

### Vérification des sauvegardes

**Script de vérification :** `verify_backups.sh`

```bash
#!/bin/bash

BACKUP_DIR="/var/backups/crud-asbl-ong"
LOG_FILE="/var/log/backup_verification.log"

echo "$(date): Vérification des sauvegardes" >> $LOG_FILE

# Vérification des sauvegardes de base de données
DB_BACKUPS=$(find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime -1 | wc -l)
if [ $DB_BACKUPS -eq 0 ]; then
    echo "$(date): ERREUR - Aucune sauvegarde de base de données récente" >> $LOG_FILE
    # Envoi d'alerte
    mail -s "ALERTE: Sauvegarde DB manquante" admin@asbl-ong.local < /dev/null
fi

# Vérification des sauvegardes de fichiers
FILE_BACKUPS=$(find $BACKUP_DIR/files -name "files_backup_*.tar.gz" -mtime -7 | wc -l)
if [ $FILE_BACKUPS -eq 0 ]; then
    echo "$(date): ERREUR - Aucune sauvegarde de fichiers récente" >> $LOG_FILE
    # Envoi d'alerte
    mail -s "ALERTE: Sauvegarde fichiers manquante" admin@asbl-ong.local < /dev/null
fi

echo "$(date): Vérification terminée" >> $LOG_FILE
```

## Maintenance Préventive

### Mises à Jour Système

#### PHP et Extensions
- **Fréquence :** Mensuelle
- **Procédure :**
  1. Vérification des versions disponibles
  2. Test en environnement de développement
  3. Mise à jour en production pendant les heures creuses
  4. Vérification du fonctionnement post-mise à jour

#### MySQL/MariaDB
- **Fréquence :** Trimestrielle
- **Procédure :**
  1. Sauvegarde complète avant mise à jour
  2. Mise à jour mineure en priorité
  3. Test des performances après mise à jour
  4. Optimisation des requêtes si nécessaire

### Optimisation des Performances

#### Base de Données
- **Analyse des requêtes lentes :**
  ```sql
  SELECT * FROM information_schema.processlist
  WHERE time > 60 ORDER BY time DESC;
  ```

- **Optimisation des index :**
  ```sql
  ANALYZE TABLE table_name;
  OPTIMIZE TABLE table_name;
  ```

- **Nettoyage des données :**
  ```sql
  DELETE FROM audit_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 YEAR);
  DELETE FROM temp_sessions WHERE expires_at < NOW();
  ```

#### Cache et Sessions
- **Nettoyage du cache :** Quotidien
- **Nettoyage des sessions expirées :** Horaire
- **Optimisation des fichiers temporaires :** Quotidien

### Monitoring Système

#### Métriques à Surveiller

1. **Performance**
   - Temps de réponse des pages (< 2 secondes)
   - Utilisation CPU (< 70%)
   - Utilisation mémoire (< 80%)
   - Utilisation disque (< 85%)

2. **Base de Données**
   - Connexions actives (< 100)
   - Requêtes lentes (> 5 secondes)
   - Taille des tables (croissance normale)
   - Locks et deadlocks

3. **Sécurité**
   - Tentatives de connexion échouées
   - Accès aux pages sensibles
   - Injection SQL détectée
   - XSS et CSRF attempts

#### Outils de Monitoring

- **Nagios/Icinga** : Monitoring infrastructure
- **Munin** : Graphiques de performance
- **Logwatch** : Analyse des logs
- **Custom scripts** : Vérifications métier

## Maintenance Corrective

### Procédures d'Urgence

#### Incident Critique
1. **Évaluation** : Déterminer la criticité
2. **Communication** : Informer les parties prenantes
3. **Containment** : Isoler le problème
4. **Résolution** : Appliquer le correctif
5. **Récupération** : Restaurer le service
6. **Post-mortem** : Analyser et documenter

#### Restauration de Données
1. **Identifier la perte** : Quelles données sont affectées
2. **Choisir la sauvegarde** : Dernière sauvegarde cohérente
3. **Test de restauration** : En environnement de test
4. **Restauration** : Appliquer en production
5. **Vérification** : Contrôler l'intégrité des données

### Gestion des Bugs

#### Classification
- **Critique** : Bloque l'utilisation du système
- **Majeur** : Impacte une fonctionnalité importante
- **Mineur** : Problème mineur ou cosmétique
- **Amélioration** : Nouvelle fonctionnalité souhaitée

#### Processus de Résolution
1. **Signalement** : Création d'un ticket
2. **Reproduction** : Recréer le problème
3. **Diagnostic** : Identifier la cause racine
4. **Développement** : Créer le correctif
5. **Test** : Validation du correctif
6. **Déploiement** : Mise en production

## Plan de Continuité

### Haute Disponibilité

#### Architecture Redondante
- **Serveur web** : Load balancer + 2 serveurs web
- **Base de données** : Master-Slave replication
- **Stockage** : RAID 1 ou 5 pour la redondance
- **Réseau** : Redondance des connexions

#### Temps d'Indisponibilité Acceptable
- **Objectif** : 99.9% de disponibilité (8.76h/an)
- **Maintenance planifiée** : Fenêtres de 2h pendant les weekends
- **Maintenance d'urgence** : Intervention sous 4h

### Plan de Reprise d'Activité

#### Site de Reprise
- **Localisation** : Centre de données secondaire
- **Synchronisation** : Réplication temps réel
- **Test** : Test trimestriel du basculement
- **Procédure** : Documentée et testée

#### Données Critiques
- **Sauvegarde hors site** : Quotidienne
- **Archivage** : 7 ans pour les données légales
- **Chiffrement** : Toutes les sauvegardes chiffrées
- **Test de restauration** : Mensuel

## Sécurité

### Mises à Jour de Sécurité
- **Fréquence** : Dès publication des correctifs
- **Priorité** : Critique et Haute en urgence
- **Test** : Environnement de développement d'abord
- **Rollback** : Plan de retour arrière disponible

### Audit de Sécurité
- **Fréquence** : Trimestrielle
- **Portée** : Application et infrastructure
- **Outils** : Scanner de vulnérabilités
- **Rapport** : Documenté avec plan d'action

### Gestion des Accès
- **Principe du moindre privilège**
- **Révision des accès** : Annuelle
- **Logs d'accès** : Conservés 1 an
- **Authentification forte** : 2FA pour les admins

## Formation et Documentation

### Formation des Administrateurs
- **Fréquence** : Annuelle + lors de changements majeurs
- **Contenu** : Procédures, dépannage, sécurité
- **Support** : Documentation en ligne + sessions pratiques

### Documentation
- **Mise à jour** : À chaque changement
- **Accessibilité** : Disponible 24/7
- **Revue** : Annuelle de complétude
- **Archivage** : Historique des versions

## Budget et Ressources

### Coûts de Maintenance
- **Personnel** : 1 ETP administrateur système
- **Logiciels** : Licences monitoring et sauvegarde
- **Infrastructure** : Serveurs de secours et stockage
- **Formation** : Budget annuel pour les mises à niveau

### Indicateurs de Performance
- **Disponibilité** : > 99.5%
- **Temps de résolution** : < 4h pour critiques
- **Temps de restauration** : < 8h pour les données
- **Satisfaction utilisateur** : > 85%

## Contacts d'Urgence

### Équipe Technique
- **Administrateur Principal** : admin@asbl-ong.local
- **Développeur Lead** : dev@asbl-ong.local
- **Support Infrastructure** : infra@asbl-ong.local

### Prestataires Externes
- **Hébergement** : provider@hosting.com
- **Base de Données** : dba@database-provider.com
- **Sécurité** : security@security-firm.com

### Numéros d'Urgence
- **Support Technique** : +32 2 123 45 67
- **Hébergement** : +32 2 987 65 43
- **Sécurité** : +32 2 555 12 34

---

*Plan de maintenance établi le : Février 2026*
*Révision annuelle recommandée*