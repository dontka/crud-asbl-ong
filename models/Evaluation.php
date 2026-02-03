<?php

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'evaluation_year',
        'evaluation_period',
        'evaluation_date',
        'job_knowledge',
        'performance',
        'teamwork',
        'communication',
        'initiative',
        'attendance',
        'overall_score',
        'strengths',
        'improvements',
        'career_goals',
        'general_comments',
        'status',
        'next_review_date'
    ];

    /**
     * Get the employee being evaluated
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the evaluator
     */
    public function evaluator()
    {
        return $this->belongsTo(Employee::class, 'evaluator_id');
    }

    /**
     * Calculate overall score from individual scores
     */
    public function calculateOverallScore()
    {
        $scores = [
            $this->job_knowledge,
            $this->performance,
            $this->teamwork,
            $this->communication,
            $this->initiative,
            $this->attendance
        ];

        $validScores = array_filter($scores);

        if (empty($validScores)) {
            return null;
        }

        return round(array_sum($validScores) / count($validScores), 2);
    }

    /**
     * Get performance rating text
     */
    public function getPerformanceRatingAttribute()
    {
        $score = $this->overall_score;

        if ($score >= 4.5) {
            return 'Excellent';
        } elseif ($score >= 4) {
            return 'Très Bon';
        } elseif ($score >= 3) {
            return 'Bon';
        } elseif ($score >= 2) {
            return 'Moyen';
        } else {
            return 'À Améliorer';
        }
    }

    /**
     * Scope: By year
     */
    public static function byYear($year)
    {
        return self::where('evaluation_year', $year);
    }

    /**
     * Scope: Finalized evaluations
     */
    public static function finalized()
    {
        return self::where('status', 'finalized');
    }

    /**
     * Scope: Pending reviews
     */
    public static function pending()
    {
        return self::whereIn('status', ['draft', 'submitted', 'reviewed']);
    }

    /**
     * Validate evaluation data
     */
    public function validate($data)
    {
        $errors = [];
        if (empty($data['employee_id'])) {
            $errors['employee_id'] = 'Employee is required';
        }
        if (empty($data['evaluation_year'])) {
            $errors['evaluation_year'] = 'Evaluation year is required';
        }
        return $errors;
    }
}
