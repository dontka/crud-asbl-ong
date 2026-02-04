<?php
/**
 * Check getStatistics function output
 */

require_once 'config.php';
require_once 'autoloader.php';

try {
    // This won't work due to autoloader issues, so let's just query directly
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "=== STATISTICS CHECK ===\n\n";
    
    // Check stats with all statuses
    echo "1. Payroll records by status:\n";
    $stmt = $db->prepare("SELECT status, COUNT(*) as count FROM payroll GROUP BY status");
    $stmt->execute();
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "   Status '" . $row['status'] . "': " . $row['count'] . " records\n";
    }
    
    // Check what getStatistics() returns (status IN ('validated', 'paid'))
    echo "\n2. getStatistics() results (status = 'validated' or 'paid'):\n";
    $stmt = $db->prepare("
        SELECT 
            COUNT(DISTINCT employee_id) as total_employees,
            COUNT(*) as total_payrolls,
            SUM(salary_net) as total_salary_net,
            AVG(salary_net) as avg_salary_net,
            SUM(social_contributions) as total_social_contributions
        FROM payroll
        WHERE status IN ('validated', 'paid')
    ");
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   Total employees: " . $stats['total_employees'] . "\n";
    echo "   Total payrolls: " . $stats['total_payrolls'] . "\n";
    echo "   Total salary net: €" . $stats['total_salary_net'] . "\n";
    echo "   Avg salary net: €" . $stats['avg_salary_net'] . "\n";
    echo "   Total social contributions: €" . $stats['total_social_contributions'] . "\n";
    
    // Check what stats should be (all payroll)
    echo "\n3. Statistics including 'draft' payroll:\n";
    $stmt = $db->prepare("
        SELECT 
            COUNT(DISTINCT employee_id) as total_employees,
            COUNT(*) as total_payrolls,
            SUM(salary_net) as total_salary_net,
            AVG(salary_net) as avg_salary_net,
            SUM(social_contributions) as total_social_contributions
        FROM payroll
    ");
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   Total employees: " . $stats['total_employees'] . "\n";
    echo "   Total payrolls: " . $stats['total_payrolls'] . "\n";
    echo "   Total salary net: €" . $stats['total_salary_net'] . "\n";
    echo "   Avg salary net: €" . $stats['avg_salary_net'] . "\n";
    echo "   Total social contributions: €" . $stats['total_social_contributions'] . "\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
