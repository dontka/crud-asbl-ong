<?php

class Absence extends Model
{
    protected $table = 'absences';
    protected $fillable = [
        'employe_id',
        'employee_id',
        'type',
        'absence_type',
        'start_date',
        'end_date',
        'duration_days',
        'status',
        'reason',
        'manager_id',
        'approval_date',
        'approval_comments',
        'attachment_path'
    ];

    /**
     * Get the employee associated with the absence
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the manager who approved the absence
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Scope: Pending approvals
     */
    public static function pending()
    {
        return self::where('status', 'pending');
    }

    /**
     * Scope: Approved absences
     */
    public static function approved()
    {
        return self::where('status', 'approved');
    }

    /**
     * Scope: By employee
     */
    public static function byEmployee($employeeId)
    {
        return self::where('employee_id', $employeeId);
    }

    /**
     * Scope: By date range
     */
    public static function inDateRange($startDate, $endDate)
    {
        return self::whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate]);
    }

    /**
     * Approve the absence
     */
    public function approve($managerId, $comments = null)
    {
        $this->status = 'approved';
        $this->manager_id = $managerId;
        $this->approval_date = date('Y-m-d H:i:s');
        $this->approval_comments = $comments;
        return $this->save();
    }

    /**
     * Reject the absence
     */
    public function reject($managerId, $reason = null)
    {
        $this->status = 'rejected';
        $this->manager_id = $managerId;
        $this->approval_date = date('Y-m-d H:i:s');
        $this->approval_comments = $reason;
        return $this->save();
    }

    /**
     * Check if absence is overlapping with another
     */
    public static function hasOverlap($employeeId, $startDate, $endDate, $excludeId = null)
    {
        $query = self::where('employee_id', $employeeId)
            ->where('status', '!=', 'rejected')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Validate absence data
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
        if (empty($data['absence_type'])) {
            $errors['absence_type'] = 'Absence type is required';
        }
        return $errors;
    }
}
