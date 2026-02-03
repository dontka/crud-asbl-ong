<?php

class Training extends Model
{
    protected $table = 'trainings';
    protected $fillable = [
        'name',
        'provider',
        'description',
        'training_type',
        'start_date',
        'end_date',
        'duration_hours',
        'location',
        'cost',
        'max_participants',
        'status'
    ];

    /**
     * Get employees participating in this training
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_trainings', 'training_id', 'employee_id')
            ->withPivot('status', 'score', 'certification_obtained', 'certification_date');
    }

    /**
     * Get current participants count
     */
    public function getParticipantsCountAttribute()
    {
        return $this->employees()->count();
    }

    /**
     * Get available spots
     */
    public function getAvailableSpotsAttribute()
    {
        return max(0, ($this->max_participants ?? 999) - $this->getParticipantsCountAttribute());
    }

    /**
     * Check if training is full
     */
    public function isFull()
    {
        return $this->available_spots <= 0;
    }

    /**
     * Scope: Upcoming trainings
     */
    public static function upcoming()
    {
        return self::where('start_date', '>', date('Y-m-d'))
            ->where('status', 'planned');
    }

    /**
     * Scope: Ongoing trainings
     */
    public static function ongoing()
    {
        return self::where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('status', 'ongoing');
    }

    /**
     * Scope: Completed trainings
     */
    public static function completed()
    {
        return self::where('end_date', '<', date('Y-m-d'))
            ->where('status', 'completed');
    }

    /**
     * Validate training data
     */
    public function validate($data)
    {
        $errors = [];
        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        }
        if (empty($data['start_date'])) {
            $errors['start_date'] = 'Start date is required';
        }
        if (empty($data['training_type'])) {
            $errors['training_type'] = 'Training type is required';
        }
        return $errors;
    }
}
