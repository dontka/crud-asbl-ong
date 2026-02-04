<?php
require_once 'config.php';
require_once 'models/Database.php';

try {
    echo "[MIGRATION] Démarrage de la migration des rôles utilisateur...\n";
    
    $db = Database::getInstance()->getConnection();
    
    // Étape 1: Exécuter l'ALTER TABLE
    $sql = "ALTER TABLE users MODIFY role ENUM(
        'admin',
        'moderator',
        'visitor',
        'hr_manager',
        'accountant',
        'project_manager',
        'crm_officer',
        'member',
        'volunteer',
        'guest',
        'supervisor',
        'auditor',
        'security_officer',
        'it_officer',
        'communication_officer',
        'compliance_officer',
        'marketplace_officer',
        'support_officer',
        'training_officer',
        'quality_officer'
    ) DEFAULT 'visitor'";
    
    $db->exec($sql);
    echo "[✓] ALTER TABLE users exécuté\n";
    
    // Étape 2: Créer l'index
    $sql2 = "CREATE INDEX idx_users_role ON users(role)";
    try {
        $db->exec($sql2);
        echo "[✓] Index idx_users_role créé\n";
    } catch (Exception $e) {
        echo "[!] Index idx_users_role existe probablement déjà\n";
    }
    
    // Étape 3: Vérifier le résultat
    $users = $db->query("SELECT id, username, role FROM users")->fetchAll();
    echo "\n[INFO] Utilisateurs actuels:\n";
    foreach ($users as $user) {
        echo "  - {$user['username']} (rôle: {$user['role']})\n";
    }
    
    echo "\n[✓] Migration terminée avec succès!\n";
    
} catch (Exception $e) {
    echo "[✗] Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
?>
