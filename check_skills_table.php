<?php
/**
 * Test skills table and data
 */

require_once 'config.php';

try {
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "=== SKILLS TABLE CHECK ===\n\n";
    
    // Check if skills table exists
    $stmt = $db->prepare("
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'skills'
    ");
    $stmt->execute([DB_NAME]);
    if ($result = $stmt->fetch()) {
        echo "✓ 'skills' table exists\n";
        
        // Get columns
        $stmt = $db->prepare("DESCRIBE skills");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "\nColumns:\n";
        foreach ($columns as $col) {
            echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
        }
        
        // Count records
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM skills");
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        echo "\nTotal skills: " . $count . "\n";
        
        // Test getCategories query
        echo "\n--- Testing getCategories query ---\n";
        $sql = "SELECT DISTINCT category FROM skills WHERE category IS NOT NULL AND category != '' ORDER BY category";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Categories found: " . count($results) . "\n";
        foreach ($results as $row) {
            echo "  - " . $row['category'] . "\n";
        }
        
        // Show all skills
        if ($count > 0) {
            echo "\n--- All skills ---\n";
            $stmt = $db->prepare("SELECT * FROM skills LIMIT 10");
            $stmt->execute();
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($skills as $skill) {
                echo "  - " . $skill['name'] . " (" . $skill['category'] . ")\n";
            }
        }
    } else {
        echo "✗ 'skills' table does NOT exist\n";
        echo "\nAvailable tables:\n";
        $stmt = $db->prepare("
            SELECT TABLE_NAME 
            FROM INFORMATION_SCHEMA.TABLES 
            WHERE TABLE_SCHEMA = ?
            ORDER BY TABLE_NAME
        ");
        $stmt->execute([DB_NAME]);
        $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tables as $table) {
            echo "  - " . $table['TABLE_NAME'] . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}
?>
