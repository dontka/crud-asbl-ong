<?php
require_once 'config.php';
require_once 'models/Database.php';

// Start session to check current user
session_start();

echo "<h1>Diagnostic du problème de redirection HR</h1>";

echo "<h2>1. État de la session</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>2. Utilisateur authentifié?</h2>";
if (isset($_SESSION['user_id'])) {
    echo "<p>✓ Oui, user_id: " . $_SESSION['user_id'] . "</p>";
} else {
    echo "<p>✗ Non, pas d'utilisateur connecté</p>";
}

echo "<h2>3. Données utilisateur</h2>";
if (isset($_SESSION['user'])) {
    echo "<pre>";
    print_r($_SESSION['user']);
    echo "</pre>";
} else {
    echo "<p>✗ $_SESSION['user'] n'existe pas</p>";
}

echo "<h2>4. Rôle utilisateur</h2>";
$userRole = $_SESSION['user']['role'] ?? 'UNDEFINED';
echo "<p>Rôle: <strong>$userRole</strong></p>";

$allowedRoles = ['admin', 'moderator', 'hr_manager', 'supervisor'];
echo "<h2>5. Rôles autorisés pour HR</h2>";
echo "<ul>";
foreach ($allowedRoles as $role) {
    $check = in_array($role, $allowedRoles) ? '✓' : '✗';
    echo "<li>$check $role</li>";
}
echo "</ul>";

echo "<h2>6. Vérification de l'accès</h2>";
if (in_array($userRole, $allowedRoles)) {
    echo "<p style='color: green;'>✓ L'utilisateur DEVRAIT avoir accès au module HR</p>";
} else {
    echo "<p style='color: red;'>✗ L'utilisateur N'A PAS accès au module HR</p>";
    echo "<p>Raison: Le rôle '<strong>$userRole</strong>' n'est pas dans la liste des rôles autorisés</p>";
}

echo "<h2>7. Récupérer les utilisateurs et mettre à jour un test</h2>";
try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT id, username, role FROM users LIMIT 5");
    $users = $stmt->fetchAll();
    
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr><td>{$user['id']}</td><td>{$user['username']}</td><td>{$user['role']}</td></tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur DB: " . $e->getMessage() . "</p>";
}

?>
