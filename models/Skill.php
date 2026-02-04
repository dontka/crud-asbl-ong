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
        $skill = new self();
        try {
            $sql = "SELECT * FROM {$skill->table} WHERE category = ? ORDER BY name";
            $stmt = $skill->db->prepare($sql);
            $stmt->execute([$category]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch skills by category: " . $e->getMessage());
        }
    }

    /**
     * Get all unique categories
     */
    public static function getCategories()
    {
        $skill = new self();
        try {
            $sql = "SELECT DISTINCT category FROM {$skill->table} WHERE category IS NOT NULL AND category != '' ORDER BY category";
            $stmt = $skill->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $categories = [];
            foreach ($results as $row) {
                if (!empty($row['category'])) {
                    $categories[] = $row['category'];
                }
            }
            return $categories;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch categories: " . $e->getMessage());
        }
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
