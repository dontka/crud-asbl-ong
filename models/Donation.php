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
     * Get total donations amount
     * @param array $conditions Optional conditions
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
            throw new Exception("Database error: Unable to calculate total amount");
        }
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
     * Search donations by donor name or email
     * @param string $query
     * @return array
     */
    public function searchByDonor($query)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE donor_name LIKE ? OR donor_email LIKE ? ORDER BY donation_date DESC";
            $searchTerm = "%{$query}%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$searchTerm, $searchTerm]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logError("searchByDonor failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to search donations");
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
