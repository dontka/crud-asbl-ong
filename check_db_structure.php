<?php
/**
 * Check database tables and structure
 */

require_once 'config.php';

try {
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "=== DATABASE TABLE CHECK ===\n\n";
    
    // Check if payroll table exists
    echo "1. Checking 'payroll' table...\n";
    $stmt = $db->prepare("
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'payroll'
    ");
    $stmt->execute([DB_NAME]);
    if ($stmt->fetch()) {
        echo "   ✓ 'payroll' table exists\n";
        
        // Get columns
        $stmt = $db->prepare("DESCRIBE payroll");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "   Columns:\n";
        foreach ($columns as $col) {
            echo "     - " . $col['Field'] . " (" . $col['Type'] . ") " . ($col['Null'] === 'NO' ? 'NOT NULL' : '') . "\n";
        }
    } else {
        echo "   ✗ 'payroll' table does NOT exist\n";
    }
    
    // Check if fiches_paie table exists
    echo "\n2. Checking 'fiches_paie' table...\n";
    $stmt = $db->prepare("
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'fiches_paie'
    ");
    $stmt->execute([DB_NAME]);
    if ($stmt->fetch()) {
        echo "   ✓ 'fiches_paie' table exists (OLD TABLE)\n";
    } else {
        echo "   ✗ 'fiches_paie' table does NOT exist\n";
    }
    
    // Check if employees table exists
    echo "\n3. Checking 'employees' table...\n";
    $stmt = $db->prepare("
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'employees'
    ");
    $stmt->execute([DB_NAME]);
    if ($stmt->fetch()) {
        echo "   ✓ 'employees' table exists\n";
        
        // Count employees
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM employees");
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        echo "   Count: " . $count . " employees\n";
    } else {
        echo "   ✗ 'employees' table does NOT exist\n";
    }
    
    // Check payroll table row count
    echo "\n4. Checking 'payroll' data...\n";
    $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM payroll");
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    echo "   Rows: " . $count . " payroll records\n";
    
    // Check Foreign Key Constraints
    echo "\n5. Checking Foreign Key Constraints...\n";
    $stmt = $db->prepare("
        SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = 'payroll'
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    $stmt->execute([DB_NAME]);
    $fks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fks as $fk) {
        echo "   - " . $fk['CONSTRAINT_NAME'] . ": " . $fk['TABLE_NAME'] . "." . $fk['COLUMN_NAME'] . " -> " . $fk['REFERENCED_TABLE_NAME'] . "." . $fk['REFERENCED_COLUMN_NAME'] . "\n";
    }
    
    // Test insert with a valid employee_id
    echo "\n6. Testing insert with valid employee_id...\n";
    $stmt = $db->prepare("SELECT id FROM employees LIMIT 1");
    $stmt->execute();
    $emp = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($emp) {
        echo "   First employee ID: " . $emp['id'] . "\n";
        
        // Try inserting a test payroll record
        try {
            $stmt = $db->prepare("
                INSERT INTO payroll (
                    employee_id, payroll_month, payroll_year, salary_gross, 
                    bonuses, deductions, taxes, social_contributions, 
                    salary_net, status, payment_method, notes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $emp['id'],    // employee_id
                1,             // payroll_month
                2024,          // payroll_year
                3000,          // salary_gross
                0,             // bonuses
                0,             // deductions
                240,           // taxes
                450,           // social_contributions
                2310,          // salary_net
                'draft',       // status
                'bank_transfer', // payment_method
                'Test insert'  // notes
            ]);
            echo "   ✓ Insert successful! ID: " . $db->lastInsertId() . "\n";
            
            // Delete the test record
            $db->prepare("DELETE FROM payroll WHERE id = ?")->execute([$db->lastInsertId()]);
            echo "   ✓ Test record deleted\n";
        } catch (PDOException $e) {
            echo "   ✗ Insert failed: " . $e->getMessage() . "\n";
            echo "   Error code: " . $e->getCode() . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Database connection error: " . $e->getMessage() . "\n";
}
?>
