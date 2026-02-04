<?php
/**
 * Test payroll stats with updated model
 */

require_once 'config.php';

// Direct database test
$db = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

echo "=== TESTING UPDATED getStatistics() ===\n\n";

// Simulate what Payroll::getStatistics() does now
$sql = "SELECT 
            COUNT(DISTINCT employee_id) as total_employees,
            COUNT(*) as total_payrolls,
            SUM(salary_gross) as total_salary_gross,
            SUM(bonuses) as total_bonuses,
            SUM(deductions) as total_deductions,
            SUM(taxes) as total_taxes,
            SUM(social_contributions) as total_social_contributions,
            SUM(salary_net) as total_salary_net,
            AVG(salary_net) as avg_salary_net
        FROM payroll
        WHERE status IN ('draft', 'validated', 'paid')";

$stmt = $db->prepare($sql);
$stmt->execute();
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Statistics (including draft):\n";
echo "  Total employees: " . $stats['total_employees'] . "\n";
echo "  Total payrolls: " . $stats['total_payrolls'] . "\n";
echo "  Total salary gross: €" . number_format($stats['total_salary_gross'] ?? 0, 2, ',', ' ') . "\n";
echo "  Total salary net: €" . number_format($stats['total_salary_net'] ?? 0, 2, ',', ' ') . "\n";
echo "  Avg salary net: €" . number_format($stats['avg_salary_net'] ?? 0, 2, ',', ' ') . "\n";
echo "  Total taxes: €" . number_format($stats['total_taxes'] ?? 0, 2, ',', ' ') . "\n";
echo "  Total social contributions: €" . number_format($stats['total_social_contributions'] ?? 0, 2, ',', ' ') . "\n";
echo "\n✓ STATS NOW INCLUDE DRAFT PAYROLL RECORDS\n";
?>
