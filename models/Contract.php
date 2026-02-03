<?php

class Contract extends Model
{
    protected $table = 'contrats';
    protected $fillable = [
        'employee_id',
        'employe_id',
        'contract_type',
        'type',
        'contract_number',
        'start_date',
        'end_date',
        'renewal_date',
        'status',
        'position_title',
        'salary',
        'working_hours',
        'probation_period_days',
        'probation_end_date',
        'document_path',
        'notes',
        'alert_renewal',
        'alert_renewal_date'
    ];

    /**
     * Get the employee associated with the contract
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Scope: Active contracts
     */
    public static function active()
    {
        return self::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', date('Y-m-d'));
            });
    }

    /**
     * Check if contract is ending soon
     */
    public function isEndingSoon($days = 30)
    {
        if (!$this->end_date) {
            return false;
        }

        $endDate = new \DateTime($this->end_date);
        $today = new \DateTime();
        $diff = $today->diff($endDate);

        return $diff->days <= $days && $diff->invert === 0;
    }

    /**
     * Get contract duration in months
     */
    public function getDurationMonthsAttribute()
    {
        $start = new \DateTime($this->start_date);
        $end = new \DateTime($this->end_date ?? 'now');
        return $start->diff($end)->m + ($start->diff($end)->y * 12);
    }

    /**
     * Check if in probation period
     */
    public function inProbation()
    {
        if (!$this->probation_end_date) {
            return false;
        }
        return new \DateTime() <= new \DateTime($this->probation_end_date);
    }

    /**
     * Validate contract data
     */
    public function validate($data)
    {
        $errors = [];
        if (empty($data['employee_id'])) {
            $errors['employee_id'] = 'Employee is required';
        }
        if (empty($data['start_date'])) {
            $errors['start_date'] = 'Start date is required';
        }
        if (empty($data['contract_type'])) {
            $errors['contract_type'] = 'Contract type is required';
        }
        return $errors;
    }
}
