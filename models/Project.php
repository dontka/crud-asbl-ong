<?php

/**
 * Project Model
 * Based on Phase 4: Backend Development - Step 4.2 Specific Models
 * Handles projects
 */

class Project extends Model
{
    protected $table = 'projects';

    /**
     * Validate project data
     * @param array $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['name']) || strlen($data['name']) < 3) {
            throw new Exception("Project name must be at least 3 characters");
        }

        if (isset($data['start_date']) && !strtotime($data['start_date'])) {
            throw new Exception("Invalid start date");
        }

        if (isset($data['end_date']) && !strtotime($data['end_date'])) {
            throw new Exception("Invalid end date");
        }

        if (
            isset($data['start_date']) && isset($data['end_date']) &&
            strtotime($data['start_date']) > strtotime($data['end_date'])
        ) {
            throw new Exception("End date must be after start date");
        }

        if (isset($data['budget']) && (!is_numeric($data['budget']) || $data['budget'] < 0)) {
            throw new Exception("Budget must be a positive number");
        }

        if (!isset($data['status']) || !in_array($data['status'], ['planning', 'active', 'completed', 'on_hold'])) {
            $data['status'] = 'planning'; // Default status
        }

        if (isset($data['manager_id']) && !$this->isValidManager($data['manager_id'])) {
            throw new Exception("Invalid manager ID");
        }

        return true;
    }

    /**
     * Get active projects
     * @return array
     */
    public function getActiveProjects()
    {
        return $this->findBy('status', 'active', 'name ASC');
    }

    /**
     * Get projects by manager
     * @param int $managerId
     * @return array
     */
    public function getProjectsByManager($managerId)
    {
        return $this->findBy('manager_id', $managerId, 'name ASC');
    }

    /**
     * Get projects within date range
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getProjectsByDateRange($startDate, $endDate)
    {
        return $this->findAll([
            'start_date' => ['>=', $startDate],
            'end_date' => ['<=', $endDate]
        ], 'start_date DESC');
    }

    /**
     * Get total budget for active projects
     * @return float
     */
    public function getTotalActiveBudget()
    {
        try {
            $sql = "SELECT SUM(budget) as total FROM {$this->table} WHERE status = 'active'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return (float) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            $this->logError("getTotalActiveBudget failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to calculate total budget");
        }
    }

    /**
     * Check if manager ID is valid
     * @param int $managerId
     * @return bool
     */
    private function isValidManager($managerId)
    {
        try {
            $sql = "SELECT COUNT(*) FROM users WHERE id = ? AND role IN ('admin', 'moderator')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$managerId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
