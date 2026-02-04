<?php
/**
 * Debug insert operation in generatePayrollForMonth
 */

require_once 'autoloader.php';

use Models\Payroll;
use Models\Employee;

try {
    echo "=== DEBUGGING PAYROLL GENERATION ===\n\n";
    
    // 1. Check employees
    echo "1. Checking employees...\n";
    $employee = new Employee();
    $employees = $employee->findAll();
    echo "   Found " . count($employees) . " employees\n";
    if (!empty($employees)) {
        $first = $employees[0];
        echo "   First employee: ID=" . $first['id'] . ", Name=" . $first['first_name'] . " " . $first['last_name'] . "\n";
        echo "   Data: " . print_r($first, true) . "\n";
    }
    
    // 2. Test insert with a single employee
    echo "\n2. Testing insert with first employee...\n";
    if (!empty($employees)) {
        $payroll = new Payroll();
        $emp = $employees[0];
        
        $month = 1; // January
        $year = 2024;
        
        // Same data as generatePayrollForMonth
        $salary_gross = 3000;
        $social_contributions = 450; // ~15%
        $taxes = 240; // ~8%
        $salary_net = 2310;
        
        $data = [
            'employee_id' => $emp['id'],
            'payroll_month' => $month,
            'payroll_year' => $year,
            'salary_gross' => $salary_gross,
            'bonuses' => 0,
            'deductions' => 0,
            'taxes' => $taxes,
            'social_contributions' => $social_contributions,
            'salary_net' => $salary_net,
            'status' => 'draft',
            'payment_method' => 'bank_transfer',
            'notes' => 'Test insert'
        ];
        
        echo "   Data to insert: " . print_r($data, true) . "\n";
        echo "   Attempting insert...\n";
        
        $result = $payroll->insert($data);
        echo "   ✓ Insert successful! ID: $result\n";
    }
    
} catch (\Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
    echo "   Code: " . $e->getCode() . "\n";
    
    if ($e->getPrevious()) {
        echo "\n   Previous Exception:\n";
        echo "   " . $e->getPrevious()->getMessage() . "\n";
    }
}
?>
