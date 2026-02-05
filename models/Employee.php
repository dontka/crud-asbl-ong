<?php

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'nationality',
        'address',
        'city',
        'postal_code',
        'country',
        'employee_number',
        'position',
        'department',
        'hire_date',
        'employment_status',
        'employment_type',
        'manager_id',
        'salary_gross',
        'currency',
        'social_security_number',
        'tax_id',
        'documents_path',
        'notes'
    ];

    protected $hidden = ['social_security_number', 'tax_id'];

    /**
     * Validate employee data
     */
    public function validate($data)
    {
        $errors = [];
        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        }
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        }
        return $errors;
    }

    /**
     * Get full name
     */
    public function getFullName()
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Get employee age from birth_date
     */
    public function getAge()
    {
        if (!isset($this->birth_date) || empty($this->birth_date)) {
            return null;
        }
        try {
            $birthDate = \DateTime::createFromFormat('Y-m-d', $this->birth_date ?? '');
            if (!$birthDate) return null;
            return $birthDate->diff(new \DateTime())->y;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get years of service
     */
    public function getYearsOfService()
    {
        if (!isset($this->hire_date) || empty($this->hire_date)) {
            return null;
        }
        try {
            $hireDate = \DateTime::createFromFormat('Y-m-d', $this->hire_date ?? '');
            if (!$hireDate) return null;
            return $hireDate->diff(new \DateTime())->y;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get employment duration string
     */
    public function getEmploymentDuration()
    {
        if (!isset($this->hire_date) || empty($this->hire_date)) {
            return 'N/A';
        }

        try {
            $now = new \DateTime();
            $hire = \DateTime::createFromFormat('Y-m-d', $this->hire_date ?? '');
            if (!$hire) return 'N/A';
            
            $interval = $hire->diff($now);

            $parts = [];
            if ($interval->y > 0) {
                $parts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
            }
            if ($interval->m > 0) {
                $parts[] = $interval->m . ' mois';
            }
            if ($interval->d > 0 && empty($parts)) {
                $parts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
            }

            return empty($parts) ? '0 jour' : implode(', ', $parts);
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Check if employee is active
     */
    public function isActive()
    {
        return ($this->employment_status ?? null) === 'active';
    }

    /**
     * Get active employees
     */
    public static function getActiveEmployees()
    {
        $employee = new self();
        $all = $employee->findAll();
        return array_filter($all, function($emp) {
            return ($emp['employment_status'] ?? null) === 'active';
        });
    }

    /**
     * Get employees by department
     */
    public static function getByDepartment($department)
    {
        $employee = new self();
        $all = $employee->findAll();
        return array_filter($all, function($emp) use ($department) {
            return ($emp['department'] ?? null) === $department;
        });
    }

    /**
     * Get employees by manager
     */
    public static function getByManager($managerId)
    {
        $employee = new self();
        $all = $employee->findAll();
        return array_filter($all, function($emp) use ($managerId) {
            return ($emp['manager_id'] ?? null) == $managerId;
        });
    }

    /**
     * Get all unique departments
     */
    public static function getAllDepartments()
    {
        $employee = new self();
        $all = $employee->findAll();
        $departments = [];
        foreach ($all as $emp) {
            $dept = $emp['department'] ?? 'Non défini';
            if (!in_array($dept, $departments)) {
                $departments[] = $dept;
            }
        }
        return $departments;
    }

    /**
     * Count employees by department
     */
    public static function countByDepartment()
    {
        $employee = new self();
        $all = $employee->findAll();
        $counts = [];
        foreach ($all as $emp) {
            $dept = $emp['department'] ?? 'Non défini';
            if (!isset($counts[$dept])) {
                $counts[$dept] = 0;
            }
            $counts[$dept]++;
        }
        return $counts;
    }

    /**
     * Count employees by employment status
     */
    public static function countByStatus()
    {
        $employee = new self();
        $all = $employee->findAll();
        $counts = [];
        foreach ($all as $emp) {
            $status = $emp['employment_status'] ?? 'unknown';
            if (!isset($counts[$status])) {
                $counts[$status] = 0;
            }
            $counts[$status]++;
        }
        return $counts;
    }
}
