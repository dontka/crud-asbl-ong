<?php

/**
 * Member Model
 * Based on Phase 4: Backend Development - Step 4.2 Specific Models
 * Handles association members
 */

class Member extends Model
{
    protected $table = 'members';

    /**
     * Validate member data
     * @param array $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['first_name']) || strlen($data['first_name']) < 2) {
            throw new Exception("First name must be at least 2 characters");
        }

        if (empty($data['last_name']) || strlen($data['last_name']) < 2) {
            throw new Exception("Last name must be at least 2 characters");
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address");
        }

        if (empty($data['join_date']) || !strtotime($data['join_date'])) {
            throw new Exception("Invalid join date");
        }

        if (!isset($data['status']) || !in_array($data['status'], ['active', 'inactive'])) {
            $data['status'] = 'active'; // Default status
        }

        // Check for duplicate email
        if ($this->isEmailTaken($data['email'], $data['id'] ?? null)) {
            throw new Exception("Email already taken");
        }

        return true;
    }

    /**
     * Get active members
     * @return array
     */
    public function getActiveMembers()
    {
        return $this->findBy('status', 'active', 'last_name ASC, first_name ASC');
    }

    /**
     * Get members by join date range
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getMembersByJoinDateRange($startDate, $endDate)
    {
        return $this->findAll([
            'join_date' => ['>=', $startDate],
            'join_date' => ['<=', $endDate]
        ], 'join_date DESC');
    }

    /**
     * Check if email is taken
     * @param string $email
     * @param int|null $excludeId
     * @return bool
     */
    private function isEmailTaken($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
