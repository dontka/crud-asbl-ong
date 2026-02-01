# Guide de Connexion - CRUD ASBL-ONG

## Identifiants de Test

Le système a été configuré avec des comptes de test :

### Administrateur
- **Username:** `admin`
- **Password:** `admin123`
- **Rôle:** Administrateur (accès complet)

### Modérateur
- **Username:** `moderator1`
- **Password:** `mod123` (à créer si nécessaire)
- **Rôle:** Modérateur (gestion limitée)

### Visiteur
- **Username:** `visitor1`
- **Password:** `visit123` (à créer si nécessaire)
- **Rôle:** Visiteur (lecture seule)

## Premiers Pas

### Connexion au Système

1. **Accès à l'application**
   - Ouvrez votre navigateur web
   - Accédez à l'URL de l'application (ex: `http://localhost/crud-asbl-ong`)

2. **Page de connexion**
   - Cliquez sur "Connexion" ou allez directement sur `/login`
   - Entrez vos identifiants

3. **Connexion réussie**
   - Vous serez redirigé vers le tableau de bord
   - Selon votre rôle, certaines fonctionnalités seront disponibles

## Rôles et Permissions

### Administrateur
- **Accès complet** à toutes les fonctionnalités
- Gestion des utilisateurs
- Configuration du système
- Accès aux rapports avancés
- Modification de tous les enregistrements

### Modérateur
- **Accès limité** aux fonctionnalités principales
- Gestion des membres et événements
- Consultation des projets et dons
- Accès aux rapports de base
- Pas d'accès à la gestion des utilisateurs

### Membre/Visiteur
- **Accès en lecture seule** principalement
- Consultation de son propre profil
- Accès aux informations publiques
- Pas de modification des données

## Sécurité

### Bonnes Pratiques

1. **Changement de mot de passe**
   - Utilisez un mot de passe fort (8+ caractères)
   - Combinez lettres, chiffres et symboles
   - Changez régulièrement votre mot de passe

2. **Session**
   - Déconnectez-vous après utilisation
   - N'utilisez pas de sessions partagées
   - Fermez votre navigateur en cas de doute

3. **Accès sécurisé**
   - Utilisez HTTPS quand disponible
   - Évitez les réseaux WiFi publics
   - Ne partagez jamais vos identifiants

## Dépannage

### Problèmes Courants

#### "Identifiants incorrects"
- Vérifiez que le nom d'utilisateur est correct
- Vérifiez la casse (majuscules/minuscules)
- Réinitialisez votre mot de passe si nécessaire

#### "Accès refusé"
- Vérifiez que votre compte est actif
- Contactez un administrateur si nécessaire
- Vérifiez vos permissions pour l'action demandée

#### "Session expirée"
- Reconnectez-vous
- Actualisez la page
- Videz le cache de votre navigateur

### Support

En cas de problème :
1. Consultez cette documentation
2. Contactez l'administrateur système
3. Vérifiez les logs d'erreur si vous êtes administrateur

## Comptes de Test Supplémentaires

### Membres de Test
```
member1 / member123
member2 / member123
member3 / member123
```

### Modérateurs de Test
```
mod1 / mod123
mod2 / mod123
```

### Visiteurs de Test
```
visitor1 / visit123
visitor2 / visit123
```

## Configuration Initiale

### Après Installation

1. **Connexion administrateur**
   - Utilisez `admin` / `admin123`

2. **Création d'utilisateurs**
   - Allez dans "Gestion des utilisateurs"
   - Créez des comptes pour les vrais utilisateurs
   - Assignez les bons rôles

3. **Configuration système**
   - Vérifiez les paramètres de base de données
   - Configurez les paramètres d'email si nécessaire
   - Testez toutes les fonctionnalités

4. **Sécurité**
   - Changez le mot de passe administrateur par défaut
   - Supprimez les comptes de test en production
   - Activez les logs de sécurité

## Notes Importantes

- **Production** : Supprimez tous les comptes de test avant la mise en production
- **Sauvegarde** : Effectuez des sauvegardes régulières
- **Mises à jour** : Vérifiez les mises à jour de sécurité régulièrement
- **Logs** : Surveillez les logs pour détecter les anomalies

---

*Guide mis à jour le : Février 2026*