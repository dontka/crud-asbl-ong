<?php

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = ['name', 'category', 'description'];

    /**
     * Get employees with this skill
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_skills', 'skill_id', 'employee_id')
            ->withPivot('proficiency_level', 'acquired_date', 'expiry_date');
    }

    /**
     * Scope: By category
     */
    public static function byCategory($category)
    {
        return self::where('category', $category);
    }

    /**
     * Get all unique categories
     */
    public static function getCategories()
    {
        return self::distinct()->pluck('category')->filter();
    }

    /**
     * Validate skill data
     */
    public function validate($data)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Skill name is required';
        }
        return $errors;
    }
}
