<?php
/**
 * Check actual employee data
 */

require_once 'config.php';

try {
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "=== EMPLOYEE DATA CHECK ===\n\n";
    
    // Get all employees
    $stmt = $db->prepare("SELECT * FROM employees ORDER BY id");
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total employees: " . count($employees) . "\n\n";
    
    foreach ($employees as $emp) {
        echo "ID: " . $emp['id'] . "\n";
        echo "  Name: " . $emp['first_name'] . " " . $emp['last_name'] . "\n";
        echo "  Email: " . $emp['email'] . "\n";
        echo "  Status: " . $emp['employment_status'] . "\n";
        echo "  Hire Date: " . $emp['hire_date'] . "\n";
        echo "\n";
    }
    
    // Also check other tables
    echo "\n=== OTHER EMPLOYEE-LIKE TABLES ===\n";
    
    // Check employes (old table from schema.sql)
    echo "\n1. 'employes' table:\n";
    $stmt = $db->prepare("
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'employes'
    ");
    $stmt->execute([DB_NAME]);
    if ($result = $stmt->fetch()) {
        echo "   ✓ 'employes' table exists\n";
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM employes");
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        echo "   Count: " . $count . " records\n";
    } else {
        echo "   ✗ 'employes' table does NOT exist\n";
    }
    
    // Check members
    echo "\n2. 'members' table:\n";
    $stmt = $db->prepare("
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'members'
    ");
    $stmt->execute([DB_NAME]);
    if ($result = $stmt->fetch()) {
        echo "   ✓ 'members' table exists\n";
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM members");
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        echo "   Count: " . $count . " records\n";
    } else {
        echo "   ✗ 'members' table does NOT exist\n";
    }
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
