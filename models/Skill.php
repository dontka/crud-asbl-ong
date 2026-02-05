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
        $id = $this->attributes['id'] ?? null;
        if (empty($id)) {
            return [];
        }
        $sql = "SELECT e.* FROM employees e 
                INNER JOIN employee_skills es ON e.id = es.employee_id 
                WHERE es.skill_id = ? 
                ORDER BY e.name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    /**
     * Create a new skill
     */
    public function insert($data)
    {
        return parent::insert($data);
    }

    /**
     * Update a skill
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }
}
