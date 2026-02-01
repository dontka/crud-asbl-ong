<?php

/**
 * Event Model
 * Based on Phase 4: Backend Development - Step 4.2 Specific Models
 * Handles events
 */

class Event extends Model
{
    protected $table = 'events';

    /**
     * Validate event data
     * @param array $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['title']) || strlen($data['title']) < 3) {
            throw new Exception("Event title must be at least 3 characters");
        }

        if (empty($data['event_date']) || !strtotime($data['event_date'])) {
            throw new Exception("Invalid event date");
        }

        if (isset($data['max_participants']) && (!is_numeric($data['max_participants']) || $data['max_participants'] < 0)) {
            throw new Exception("Max participants must be a positive number");
        }

        if (!isset($data['status']) || !in_array($data['status'], ['planned', 'ongoing', 'completed', 'cancelled'])) {
            $data['status'] = 'planned'; // Default status
        }

        if (isset($data['organizer_id']) && !$this->isValidOrganizer($data['organizer_id'])) {
            throw new Exception("Invalid organizer ID");
        }

        return true;
    }

    /**
     * Get upcoming events
     * @param int $limit
     * @return array
     */
    public function getUpcomingEvents($limit = null)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE event_date >= NOW() AND status != 'cancelled' ORDER BY event_date ASC";
            if ($limit) {
                $sql .= " LIMIT {$limit}";
            }
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logError("getUpcomingEvents failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to fetch upcoming events");
        }
    }

    /**
     * Get events by organizer
     * @param int $organizerId
     * @return array
     */
    public function getEventsByOrganizer($organizerId)
    {
        return $this->findBy('organizer_id', $organizerId, 'event_date DESC');
    }

    /**
     * Get events by date range
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getEventsByDateRange($startDate, $endDate)
    {
        return $this->findAll([
            'event_date' => ['>=', $startDate],
            'event_date' => ['<=', $endDate]
        ], 'event_date ASC');
    }

    /**
     * Get events by status
     * @param string $status
     * @return array
     */
    public function getEventsByStatus($status)
    {
        return $this->findBy('status', $status, 'event_date DESC');
    }

    /**
     * Check if organizer ID is valid
     * @param int $organizerId
     * @return bool
     */
    private function isValidOrganizer($organizerId)
    {
        try {
            $sql = "SELECT COUNT(*) FROM users WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$organizerId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
