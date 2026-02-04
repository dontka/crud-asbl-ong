<?php
require_once 'config.php';
require_once 'models/Database.php';

try {
    echo "[SETUP] Création/mise à jour des utilisateurs de test...\n";
    
    $db = Database::getInstance()->getConnection();
    
    // Utilisateur admin
    echo "\n[1] Traitement de l'utilisateur 'admin':\n";
    
    $stmt = $db->prepare("SELECT id FROM users WHERE username = 'admin'");
    $stmt->execute();
    $adminUser = $stmt->fetch();
    
    if ($adminUser) {
        echo "  - Utilisateur 'admin' trouvé (ID: {$adminUser['id']})\n";
        echo "  - Mise à jour du mot de passe et rôle...\n";
        
        $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE users SET password = ?, role = 'admin' WHERE username = 'admin'");
        $stmt->execute([$hashedPassword]);
        
        echo "  [✓] Utilisateur 'admin' mis à jour\n";
    } else {
        echo "  - Utilisateur 'admin' non trouvé\n";
        echo "  - Création du nouvel utilisateur...\n";
        
        $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@asbl-ong.org', $hashedPassword, 'admin']);
        
        echo "  [✓] Utilisateur 'admin' créé\n";
    }
    
    // Utilisateur hr_manager
    echo "\n[2] Traitement de l'utilisateur 'hr_manager':\n";
    
    $stmt = $db->prepare("SELECT id FROM users WHERE username = 'hr_manager'");
    $stmt->execute();
    $hrUser = $stmt->fetch();
    
    if ($hrUser) {
        echo "  - Utilisateur 'hr_manager' trouvé (ID: {$hrUser['id']})\n";
        echo "  - Mise à jour du mot de passe et rôle...\n";
        
        $hashedPassword = password_hash('hr123', PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE users SET password = ?, role = 'hr_manager' WHERE username = 'hr_manager'");
        $stmt->execute([$hashedPassword]);
        
        echo "  [✓] Utilisateur 'hr_manager' mis à jour\n";
    } else {
        echo "  - Utilisateur 'hr_manager' non trouvé\n";
        echo "  - Création du nouvel utilisateur...\n";
        
        $hashedPassword = password_hash('hr123', PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['hr_manager', 'hr@asbl-ong.org', $hashedPassword, 'hr_manager']);
        
        echo "  [✓] Utilisateur 'hr_manager' créé\n";
    }
    
    // Afficher la liste des utilisateurs admin/hr
    echo "\n[3] Utilisateurs disponibles pour accès HR:\n";
    
    $sql = "SELECT id, username, email, role FROM users WHERE role IN ('admin', 'moderator', 'hr_manager', 'supervisor') ORDER BY role DESC, username ASC";
    $users = $db->query($sql)->fetchAll();
    
    echo "  ┌─────┬──────────────────────┬────────────────────────┬──────────────┐\n";
    echo "  │ ID  │ Username             │ Email                  │ Role         │\n";
    echo "  ├─────┼──────────────────────┼────────────────────────┼──────────────┤\n";
    
    foreach ($users as $user) {
        $id = str_pad($user['id'], 3);
        $username = str_pad($user['username'], 20);
        $email = str_pad($user['email'], 22);
        $role = str_pad($user['role'], 12);
        echo "  │ {$id} │ {$username} │ {$email} │ {$role} │\n";
    }
    
    echo "  └─────┴──────────────────────┴────────────────────────┴──────────────┘\n";
    
    echo "\n[✓] Configuration terminée avec succès!\n";
    echo "\n[INFO] Identifiants de connexion pour tester:\n";
    echo "  Compte admin:\n";
    echo "    Username: admin\n";
    echo "    Password: admin123\n";
    echo "\n  Compte HR Manager:\n";
    echo "    Username: hr_manager\n";
    echo "    Password: hr123\n";
    
} catch (Exception $e) {
    echo "[✗] Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
?>
