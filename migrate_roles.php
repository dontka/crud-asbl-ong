<?php
require_once 'config.php';
require_once 'models/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    echo "<h2>Mise à jour du schéma users...</h2>";
    
    // Execute the migration
    $migrationSQL = file_get_contents('database/migrations/003_extend_user_roles.sql');
    $statements = array_filter(array_map('trim', explode(';', $migrationSQL)), function($s) {
        return !empty($s) && strpos($s, '--') !== 0;
    });
    
    foreach ($statements as $statement) {
        if (!empty(trim($statement))) {
            $db->exec($statement);
            echo "<p>✓ Exécuté: " . substr($statement, 0, 50) . "...</p>";
        }
    }
    
    echo "<h2>Utilisateurs actuels:</h2>";
    $stmt = $db->query("SELECT id, username, email, role FROM users");
    $users = $stmt->fetchAll();
    
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr><td>{$user['id']}</td><td>{$user['username']}</td><td>{$user['email']}</td><td>{$user['role']}</td></tr>";
    }
    echo "</table>";
    
    echo "<h2>Vérification de la session actuelle:</h2>";
    session_start();
    if (isset($_SESSION['user'])) {
        echo "<p>Utilisateur connecté: <strong>" . $_SESSION['user']['username'] . "</strong></p>";
        echo "<p>Rôle: <strong>" . $_SESSION['user']['role'] . "</strong></p>";
        echo "<p>ID: " . $_SESSION['user']['id'] . "</p>";
    } else {
        echo "<p style='color: red;'>Aucun utilisateur connecté</p>";
    }
    
    echo "<h2>Accès HR disponible pour les rôles:</h2>";
    $allowedRoles = ['admin', 'moderator', 'hr_manager', 'supervisor'];
    echo "<ul>";
    foreach ($allowedRoles as $role) {
        echo "<li><strong>$role</strong></li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
