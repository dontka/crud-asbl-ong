<?php
require_once 'config.php';
require_once 'models/Database.php';
require_once 'models/User.php';

echo "<h1>Création d'un utilisateur admin valide</h1>";

try {
    $user = new User();
    
    // Check if admin already exists
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT id FROM users WHERE username = 'admin'");
    $stmt->execute();
    $existing = $stmt->fetch();
    
    if ($existing) {
        echo "<p>L'utilisateur admin existe déjà avec ID: " . $existing['id'] . "</p>";
        
        // Update with a valid password
        $password = 'admin123';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
        $stmt->execute([$hashedPassword]);
        
        echo "<p style='color: green;'>✓ Mot de passe admin mis à jour</p>";
        echo "<p><strong>Identifiants de test:</strong></p>";
        echo "<ul>";
        echo "<li>Username: <strong>admin</strong></li>";
        echo "<li>Password: <strong>admin123</strong></li>";
        echo "<li>Email: <strong>admin@asbl-ong.org</strong></li>";
        echo "<li>Role: <strong>admin</strong></li>";
        echo "</ul>";
    } else {
        echo "<p>Création d'un nouvel utilisateur admin...</p>";
        
        $password = 'admin123';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@asbl-ong.org', $hashedPassword, 'admin']);
        
        echo "<p style='color: green;'>✓ Utilisateur admin créé avec succès</p>";
        echo "<p><strong>Identifiants de test:</strong></p>";
        echo "<ul>";
        echo "<li>Username: <strong>admin</strong></li>";
        echo "<li>Password: <strong>admin123</strong></li>";
        echo "<li>Email: <strong>admin@asbl-ong.org</strong></li>";
        echo "<li>Role: <strong>admin</strong></li>";
        echo "</ul>";
    }
    
    // Create or update hr_manager user
    echo "<h2>Création d'un utilisateur hr_manager</h2>";
    $stmt = $db->prepare("SELECT id FROM users WHERE username = 'hr_manager'");
    $stmt->execute();
    $existing = $stmt->fetch();
    
    if ($existing) {
        echo "<p>L'utilisateur hr_manager existe déjà</p>";
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = 'hr_manager'");
        $stmt->execute([password_hash('hr123', PASSWORD_BCRYPT)]);
        echo "<p style='color: green;'>✓ Mot de passe hr_manager mis à jour</p>";
    } else {
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['hr_manager', 'hr@asbl-ong.org', password_hash('hr123', PASSWORD_BCRYPT), 'hr_manager']);
        echo "<p style='color: green;'>✓ Utilisateur hr_manager créé</p>";
    }
    
    echo "<p><strong>Identifiants HR Manager:</strong></p>";
    echo "<ul>";
    echo "<li>Username: <strong>hr_manager</strong></li>";
    echo "<li>Password: <strong>hr123</strong></li>";
    echo "<li>Email: <strong>hr@asbl-ong.org</strong></li>";
    echo "<li>Role: <strong>hr_manager</strong></li>";
    echo "</ul>";
    
    echo "<h2>Utilisateurs actuels</h2>";
    $users = $db->query("SELECT id, username, email, role FROM users")->fetchAll();
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th></tr>";
    foreach ($users as $u) {
        echo "<tr><td>{$u['id']}</td><td>{$u['username']}</td><td>{$u['email']}</td><td>{$u['role']}</td></tr>";
    }
    echo "</table>";
    
    echo "<h2>Prochaines étapes</h2>";
    echo "<ol>";
    echo "<li>Connectez-vous avec l'utilisateur <strong>admin</strong> / <strong>admin123</strong></li>";
    echo "<li>Allez sur <a href='http://crud-asbl-ong.test/hr/payroll' target='_blank'>/hr/payroll</a></li>";
    echo "<li>Vous devriez voir la page de gestion de la paie au lieu d'une redirection</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
