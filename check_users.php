<?php
require_once 'config.php';
require_once 'models/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT id, username, email, role FROM users LIMIT 10");
    $users = $stmt->fetchAll();
    
    echo "<pre>";
    echo "=== UTILISATEURS ACTUELS ===\n";
    print_r($users);
    echo "\n=== SESSION INFO ===\n";
    session_start();
    print_r($_SESSION);
    echo "</pre>";
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
