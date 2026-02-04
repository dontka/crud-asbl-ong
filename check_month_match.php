<?php
/**
 * Check if payroll month matches current month setting
 */

require_once 'config.php';

$db = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

echo "=== PAYROLL MONTH CHECK ===\n\n";

// Check current date format
$currentMonth = date('Y-m');
echo "Current month (date('Y-m')): " . $currentMonth . "\n";
list($year, $month) = explode('-', $currentMonth);
echo "Parsed year: " . $year . ", month: " . $month . "\n\n";

// Check what months exist in payroll table
echo "Months in payroll table:\n";
$stmt = $db->prepare("SELECT DISTINCT payroll_year, payroll_month FROM payroll ORDER BY payroll_year DESC, payroll_month DESC");
$stmt->execute();
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "  Year: " . $row['payroll_year'] . ", Month: " . $row['payroll_month'] . "\n";
}

// Check if there's payroll for current month
echo "\nPayroll for current month (" . $currentMonth . "):\n";
$stmt = $db->prepare("SELECT COUNT(*) as cnt FROM payroll WHERE payroll_month = ? AND payroll_year = ?");
$stmt->execute([$month, $year]);
$count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
echo "  Records: " . $count . "\n";

// Check if there's payroll for February 2026
echo "\nPayroll for February 2026 (2026-02):\n";
$stmt = $db->prepare("SELECT COUNT(*) as cnt FROM payroll WHERE payroll_month = 2 AND payroll_year = 2026");
$stmt->execute();
$count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
echo "  Records: " . $count . "\n";

echo "\n→ If no payroll for current month, click 'Générer Masse' to generate for current month\n";
?>
