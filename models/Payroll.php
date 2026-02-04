<?php

class Payroll extends Model
{
    protected $table = 'payroll';
    protected $fillable = [
        'employee_id',
        'payroll_month',
        'payroll_year',
        'salary_gross',
        'bonuses',
        'deductions',
        'taxes',
        'social_contributions',
        'salary_net',
        'overtime_hours',
        'overtime_pay',
        'status',
        'payment_date',
        'payment_method',
        'notes'
    ];

    /**
     * Get payroll by employee and month
     */
    public function getByEmployeeAndMonth($employeeId, $month)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE employee_id = ? AND payroll_month = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employeeId, $month]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch payroll: " . $e->getMessage());
        }
    }

    /**
     * Get all payroll for an employee
     */
    public function getByEmployee($employeeId)
    {
        try {
            return $this->findBy('employee_id', $employeeId, 'payroll_month DESC');
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch payroll: " . $e->getMessage());
        }
    }

    /**
     * Calculate net salary based on salary components
     */
    public static function calculateNetSalary($salary_gross, $bonuses = 0, $deductions = 0, $taxes = 0, $social_contributions = 0)
    {
        $total_gross = $salary_gross + $bonuses;
        $total_deductions = $deductions + $taxes + $social_contributions;
        $net = $total_gross - $total_deductions;
        return max(0, $net); // Never negative
    }

    /**
     * Calculate social contributions (23.5% for employees)
     */
    public static function calculateSocialContributions($salary_gross)
    {
        return round($salary_gross * 0.235, 2);
    }

    /**
     * Calculate income tax (simplified)
     */
    public static function calculateIncomeTax($salary_net_before_tax)
    {
        if ($salary_net_before_tax < 1500) {
            return 0;
        }
        return round(($salary_net_before_tax - 1500) * 0.15, 2);
    }

    /**
     * Get payroll statistics for a period
     */
    public function getStatistics($startMonth = null, $endMonth = null)
    {
        try {
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
                    FROM {$this->table}
                    WHERE status IN ('draft', 'validated', 'paid')";

            $params = [];
            if ($startMonth) {
                $sql .= " AND payroll_month >= ?";
                $params[] = $startMonth;
            }
            if ($endMonth) {
                $sql .= " AND payroll_month <= ?";
                $params[] = $endMonth;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch statistics: " . $e->getMessage());
        }
    }

    /**
     * Generate payroll for all active employees for a given month
     */
    public function generatePayrollForMonth($dateStr)
    {
        try {
            $date = new DateTime($dateStr);
            $month = intval($date->format('m'));
            $year = intval($date->format('Y'));
            
            $employee = new Employee();
            $employees = $employee->findAll();
            $generated = 0;

            foreach ($employees as $emp) {
                // Check if already exists
                $existing = $this->getByEmployeeAndMonth($emp['id'], $month);
                if (!$existing) {
                    // Simulate salary (in real app, would come from contract)
                    $salary_gross = rand(2000, 4500);
                    $social_contributions = self::calculateSocialContributions($salary_gross);
                    $net_before_tax = $salary_gross - $social_contributions;
                    $taxes = self::calculateIncomeTax($net_before_tax);
                    $salary_net = self::calculateNetSalary($salary_gross, 0, 0, $taxes, $social_contributions);

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
                        'notes' => 'Auto-generated'
                    ];

                    $this->insert($data);
                    $generated++;
                }
            }

            return $generated;
        } catch (Exception $e) {
            throw new Exception("Unable to generate payroll: " . $e->getMessage());
        }
    }

    /**
     * Validate payroll data
     */
    public function validate($data)
    {
        $errors = [];
        
        if (empty($data['employee_id'])) {
            $errors['employee_id'] = 'Employee ID is required';
        }
        
        if (empty($data['payroll_month'])) {
            $errors['payroll_month'] = 'Month is required';
        }
        
        if (!isset($data['salary_gross']) || $data['salary_gross'] < 0) {
            $errors['salary_gross'] = 'Gross salary must be a positive number';
        }
        
        if (!isset($data['salary_net']) || $data['salary_net'] < 0) {
            $errors['salary_net'] = 'Net salary must be a positive number';
        }
        
        if (empty($data['status'])) {
            $errors['status'] = 'Status is required';
        }
        
        return $errors;
    }
}
