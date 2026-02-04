<?php
require 'config.php';
require 'autoloader.php';

echo "=== Checking Employees ===\n\n";

try {
    $db = Database::getInstance();
    $connection = $db->getConnection();
    $db->selectDatabase(DB_NAME);
    
    echo "1. First 5 employees in database:\n";
    $result = $connection->query("SELECT id, first_name, last_name FROM employees LIMIT 5");
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        echo "   ID: {$row['id']} - {$row['first_name']} {$row['last_name']}\n";
    }
    
    echo "\n2. Testing with first employee:\n";
    $employee = new Employee();
    $first = $employee->findById(1);
    if ($first) {
        echo "   ✓ Employee ID 1 found: {$first['first_name']} {$first['last_name']}\n";
    } else {
        echo "   ✗ Employee ID 1 NOT found\n";
    }
    
    echo "\n3. Checking foreign key constraints:\n";
    $fkResult = $connection->query("SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME='payroll'");
    $fks = $fkResult->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fks as $fk) {
        echo "   " . $fk['CONSTRAINT_NAME'] . ": {$fk['TABLE_NAME']}.{$fk['COLUMN_NAME']} → {$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
