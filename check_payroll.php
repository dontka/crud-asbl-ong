<?php
/**
 * Check generated payroll records
 */

require_once 'config.php';

try {
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "=== PAYROLL RECORDS CHECK ===\n\n";
    
    // Get payroll statistics
    $stmt = $db->prepare("SELECT COUNT(*) as total, COUNT(DISTINCT employee_id) as unique_employees FROM payroll");
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total payroll records: " . $stats['total'] . "\n";
    echo "Unique employees with payroll: " . $stats['unique_employees'] . "\n\n";
    
    // Group by month and year
    $stmt = $db->prepare("
        SELECT payroll_year, payroll_month, COUNT(*) as count 
        FROM payroll 
        GROUP BY payroll_year, payroll_month 
        ORDER BY payroll_year DESC, payroll_month DESC
    ");
    $stmt->execute();
    echo "Payroll records by month:\n";
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "  Year: " . $row['payroll_year'] . ", Month: " . $row['payroll_month'] . " - " . $row['count'] . " records\n";
    }
    
    // Show first 5 records
    echo "\nFirst 5 payroll records:\n";
    $stmt = $db->prepare("
        SELECT p.id, p.employee_id, e.first_name, e.last_name, p.payroll_year, p.payroll_month, 
               p.salary_gross, p.salary_net, p.status
        FROM payroll p
        JOIN employees e ON p.employee_id = e.id
        LIMIT 5
    ");
    $stmt->execute();
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "  ID: " . $row['id'] . " - " . $row['first_name'] . " " . $row['last_name'] . 
             " (emp_id: " . $row['employee_id'] . ") - " . $row['payroll_year'] . "-" . 
             $row['payroll_month'] . " - Gross: €" . $row['salary_gross'] . " Net: €" . $row['salary_net'] . 
             " Status: " . $row['status'] . "\n";
    }
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
