<?php

/**
 * Donation Model
 * Based on Phase 4: Backend Development - Step 4.2 Specific Models
 * Handles donations
 */

class Donation extends Model
{
    protected $table = 'donations';

    /**
     * Validate donation data
     * @param array $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['donor_name']) || strlen($data['donor_name']) < 2) {
            throw new Exception("Donor name must be at least 2 characters");
        }

        if (isset($data['donor_email']) && !filter_var($data['donor_email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid donor email address");
        }

        if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
            throw new Exception("Amount must be a positive number");
        }

        if (empty($data['donation_date']) || !strtotime($data['donation_date'])) {
            throw new Exception("Invalid donation date");
        }

        if (!isset($data['payment_method']) || !in_array($data['payment_method'], ['cash', 'bank_transfer', 'online'])) {
            $data['payment_method'] = 'cash'; // Default method
        }

        if (isset($data['project_id']) && !$this->isValidProject($data['project_id'])) {
            throw new Exception("Invalid project ID");
        }

        return true;
    }

    /**
     * Get donations by project
     * @param int $projectId
     * @return array
     */
    public function getDonationsByProject($projectId)
    {
        return $this->findBy('project_id', $projectId, 'donation_date DESC');
    }

    /**
     * Get donations by date range
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getDonationsByDateRange($startDate, $endDate)
    {
        return $this->findAll([
            'donation_date' => ['>=', $startDate],
            'donation_date' => ['<=', $endDate]
        ], 'donation_date DESC');
    }

    /**
     * Get donations by payment method
     * @param string $method
     * @return array
     */
    public function getDonationsByPaymentMethod($method)
    {
        return $this->findBy('payment_method', $method, 'donation_date DESC');
    }

    /**
     * Get donations with project names
     * @param array $conditions Optional WHERE conditions
     * @param string $orderBy Optional ORDER BY clause
     * @return array
     */
    public function getDonationsWithProjects($conditions = [], $orderBy = '')
    {
        try {
            $sql = "SELECT d.*, p.name as project_name FROM {$this->table} d LEFT JOIN projects p ON d.project_id = p.id";
            $params = [];

            if (!empty($conditions)) {
                $whereClause = $this->buildWhereClause($conditions);
                $sql .= " WHERE " . $whereClause['clause'];
                $params = $whereClause['params'];
            }

            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            } else {
                $sql .= " ORDER BY d.donation_date DESC";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logError("getDonationsWithProjects failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total amount of donations
     * @param array $conditions Optional WHERE conditions
     * @return float
     */
    public function getTotalAmount($conditions = [])
    {
        try {
            $sql = "SELECT SUM(amount) as total FROM {$this->table}";
            $params = [];

            if (!empty($conditions)) {
                $whereClause = $this->buildWhereClause($conditions);
                $sql .= " WHERE " . $whereClause['clause'];
                $params = $whereClause['params'];
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return (float) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            $this->logError("getTotalAmount failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total count of donations
     * @param array $conditions Optional WHERE conditions
     * @return int
     */
    public function getTotalCount($conditions = [])
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $params = [];

            if (!empty($conditions)) {
                $whereClause = $this->buildWhereClause($conditions);
                $sql .= " WHERE " . $whereClause['clause'];
                $params = $whereClause['params'];
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            $this->logError("getTotalCount failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Check if project ID is valid
     * @param int $projectId
     * @return bool
     */
    private function isValidProject($projectId)
    {
        try {
            $sql = "SELECT COUNT(*) FROM projects WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$projectId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
