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

## Comment se connecter

1. Ouvrez votre navigateur à l'adresse : `http://crud-asbl-ong.test/login`
2. Entrez le nom d'utilisateur `admin`
3. Entrez le mot de passe `admin123`
4. Cliquez sur "Se connecter"
5. Vous serez automatiquement redirigé vers le dashboard

## Fonctionnalités disponibles

Une fois connecté, vous pouvez :
- Voir le dashboard avec les statistiques
- Gérer les membres, projets, événements et dons
- Créer, modifier et supprimer des enregistrements
- Naviguer entre les différentes sections

## Dépannage

Si la connexion ne fonctionne pas :
1. Vérifiez que les identifiants sont corrects
2. Vérifiez que le serveur Apache et MySQL sont démarrés
3. Consultez les logs PHP dans `C:/laragon/tmp/php_errors.log`

## Sécurité

- Les mots de passe sont hashés avec bcrypt
- Les sessions sont sécurisées
- L'accès est contrôlé par rôles