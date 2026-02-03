<?php

class Employee extends Model
{
    protected $table = 'employes';
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
     * Get the user associated with the employee
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the manager of this employee
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Get the subordinates of this employee
     */
    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * Get the contracts associated with this employee
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'employee_id');
    }

    /**
     * Get the current contract
     */
    public function currentContract()
    {
        return $this->contracts()
            ->where('status', 'active')
            ->orWhereNull('end_date')
            ->latest('start_date')
            ->first();
    }

    /**
     * Get the absences associated with this employee
     */
    public function absences()
    {
        return $this->hasMany(Absence::class, 'employee_id');
    }

    /**
     * Get the leave balance
     */
    public function leaveBalance()
    {
        return $this->hasOne(LeaveBalance::class, 'employee_id');
    }

    /**
     * Get the timekeeping records
     */
    public function timekeeping()
    {
        return $this->hasMany(Timekeeping::class, 'employee_id');
    }

    /**
     * Get the skills
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'employee_skills', 'employee_id', 'skill_id')
            ->withPivot('proficiency_level', 'acquired_date', 'expiry_date');
    }

    /**
     * Get the trainings
     */
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'employee_trainings', 'employee_id', 'training_id')
            ->withPivot('status', 'score', 'certification_obtained', 'certification_date');
    }

    /**
     * Get the evaluations
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'employee_id');
    }

    /**
     * Get the payroll records
     */
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    /**
     * Get active employees
     */
    public static function active()
    {
        return self::where('employment_status', 'active');
    }

    /**
     * Get employees by department
     */
    public static function byDepartment($department)
    {
        return self::where('department', $department);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get employee age from birth_date
     */
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }
        return \DateTime::createFromFormat('Y-m-d', $this->birth_date)
            ->diff(new \DateTime())->y;
    }

    /**
     * Get years of service
     */
    public function getYearsOfServiceAttribute()
    {
        if (!$this->hire_date) {
            return null;
        }
        return \DateTime::createFromFormat('Y-m-d', $this->hire_date)
            ->diff(new \DateTime())->y;
    }

    /**
     * Check if employee is manager
     */
    public function isManager()
    {
        return $this->subordinates()->count() > 0;
    }

    /**
     * Get employment duration string
     */
    public function getEmploymentDurationAttribute()
    {
        if (!$this->hire_date) {
            return 'N/A';
        }

        $now = new \DateTime();
        $hire = \DateTime::createFromFormat('Y-m-d', $this->hire_date);
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

        return implode(', ', $parts);
    }

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
}
