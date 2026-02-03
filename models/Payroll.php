<?php

class Payroll extends Model
{
    protected $table = 'fiches_paie';
    protected $fillable = [
        'employe_id',
        'mois',
        'salaire_base',
        'prime',
        'gratification',
        'cotisation_sociale',
        'impot_revenu',
        'autres_retenues',
        'salaire_net',
        'statut',
        'date_paiement',
        'notes'
    ];

    /**
     * Get payroll by employee and month
     */
    public function getByEmployeeAndMonth($employeeId, $month)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE employe_id = ? AND mois = ?";
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
            return $this->findBy('employe_id', $employeeId, 'mois DESC');
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch payroll: " . $e->getMessage());
        }
    }

    /**
     * Calculate net salary
     */
    public static function calculateNetSalary($salaire_base, $prime = 0, $gratification = 0, $cotisation = 0, $impot = 0, $autres = 0)
    {
        $brut = $salaire_base + $prime + $gratification;
        $net = $brut - $cotisation - $impot - $autres;
        return max(0, $net); // Never negative
    }

    /**
     * Calculate cotisation sociale (23.5% for employees)
     */
    public static function calculateCotisation($salaire_base)
    {
        return round($salaire_base * 0.235, 2);
    }

    /**
     * Calculate income tax (simplified)
     */
    public static function calculateIncomeTax($salaire_net_before_tax)
    {
        if ($salaire_net_before_tax < 1500) {
            return 0;
        }
        return round(($salaire_net_before_tax - 1500) * 0.15, 2);
    }

    /**
     * Get payroll statistics for a period
     */
    public function getStatistics($startMonth = null, $endMonth = null)
    {
        try {
            $sql = "SELECT 
                        COUNT(DISTINCT employe_id) as total_employees,
                        COUNT(*) as total_payrolls,
                        SUM(salaire_base) as total_salaire_base,
                        SUM(prime) as total_primes,
                        SUM(gratification) as total_gratifications,
                        SUM(cotisation_sociale) as total_cotisations,
                        SUM(impot_revenu) as total_impots,
                        SUM(autres_retenues) as total_retenues,
                        SUM(salaire_net) as total_salaire_net,
                        AVG(salaire_net) as avg_salaire_net
                    FROM {$this->table}
                    WHERE statut IN ('valide', 'paye')";

            $params = [];
            if ($startMonth) {
                $sql .= " AND mois >= ?";
                $params[] = $startMonth;
            }
            if ($endMonth) {
                $sql .= " AND mois <= ?";
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
    public function generatePayrollForMonth($month)
    {
        try {
            $employee = new Employee();
            $employees = $employee->findAll(['status' => 'active']);
            $generated = 0;

            foreach ($employees as $emp) {
                // Check if already exists
                $existing = $this->getByEmployeeAndMonth($emp['id'], $month);
                if (!$existing) {
                    // Simulate salary (in real app, would come from contract)
                    $salary = rand(2000, 4500);
                    $cotisation = self::calculateCotisation($salary);
                    $net_before_tax = $salary - $cotisation;
                    $impot = self::calculateIncomeTax($net_before_tax);
                    $net = self::calculateNetSalary($salary, 0, 0, $cotisation, $impot, 0);

                    $data = [
                        'employe_id' => $emp['id'],
                        'mois' => $month,
                        'salaire_base' => $salary,
                        'prime' => 0,
                        'gratification' => 0,
                        'cotisation_sociale' => $cotisation,
                        'impot_revenu' => $impot,
                        'autres_retenues' => 0,
                        'salaire_net' => $net,
                        'statut' => 'brouillon'
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
}
