<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SESSION['user'] = ['id' => 1, 'role' => 'admin'];

require 'config.php';
require 'autoloader.php';

echo "=== Testing Payroll Generation ===\n\n";

try {
    echo "1. Testing Employee::findAll()...\n";
    $employee = new Employee();
    $employees = $employee->findAll();
    echo "   ✓ Found " . count($employees) . " employees\n\n";
    
    echo "2. Testing Payroll::generatePayrollForMonth()...\n";
    $payroll = new Payroll();
    $generated = $payroll->generatePayrollForMonth(date('Y-m-01'));
    echo "   ✓ Generated $generated payroll records\n\n";
    
    echo "3. Checking payroll table content...\n";
    $all = $payroll->findAll();
    echo "   ✓ Total payroll records: " . count($all) . "\n\n";
    
    echo "SUCCESS!\n";
    
} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n\n";
    echo "   Full Stack:\n";
    echo $e->getTraceAsString() . "\n";
}
?>
