<?php

/**
 * Dashboard Controller
 * Handles dashboard display and statistics
 */

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
    }

    /**
     * Display dashboard with statistics
     */
    public function index()
    {
        $user = $this->getCurrentUser();

        // Get statistics
        $stats = $this->getDashboardStats();

        // Get recent data
        $recent_members = $this->getRecentMembers();
        $upcoming_events = $this->getUpcomingEvents();
        $recent_donations = $this->getRecentDonations();

        // Include the view
        require_once 'views/dashboard/index.php';
    }

    /**
     * Get dashboard statistics
     * @return array
     */
    private function getDashboardStats()
    {
        try {
            $db = Database::getInstance()->getConnection();

            // Get total members
            $stmt = $db->query("SELECT COUNT(*) as total FROM members WHERE status = 'active'");
            $stats['total_members'] = $stmt->fetch()['total'];

            // Get total projects
            $stmt = $db->query("SELECT COUNT(*) as total FROM projects WHERE status = 'active'");
            $stats['total_projects'] = $stmt->fetch()['total'];

            // Get total events
            $stmt = $db->query("SELECT COUNT(*) as total FROM events WHERE status = 'active'");
            $stats['total_events'] = $stmt->fetch()['total'];

            // Get total donations
            $stmt = $db->query("SELECT SUM(amount) as total FROM donations");
            $stats['total_donations'] = $stmt->fetch()['total'] ?? 0;

            // Get monthly donations (current month)
            $stmt = $db->query("SELECT SUM(amount) as total FROM donations WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
            $stats['monthly_donations'] = $stmt->fetch()['total'] ?? 0;

            // Get upcoming events (next 30 days)
            $stmt = $db->query("SELECT COUNT(*) as total FROM events WHERE event_date >= CURRENT_DATE() AND event_date <= DATE_ADD(CURRENT_DATE(), INTERVAL 30 DAY) AND status = 'active'");
            $stats['upcoming_events'] = $stmt->fetch()['total'];

            // Get recent donations count (last 30 days)
            $stmt = $db->query("SELECT COUNT(*) as total FROM donations WHERE created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)");
            $stats['recent_donations_count'] = $stmt->fetch()['total'];

            return $stats;
        } catch (Exception $e) {
            error_log("Error getting dashboard stats: " . $e->getMessage());
            return [
                'total_members' => 0,
                'total_projects' => 0,
                'total_events' => 0,
                'total_donations' => 0,
                'monthly_donations' => 0,
                'upcoming_events' => 0,
                'recent_donations_count' => 0
            ];
        }
    }

    /**
     * Get recent members (last 5)
     * @return array
     */
    private function getRecentMembers()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT first_name, last_name, join_date FROM members WHERE status = 'active' ORDER BY join_date DESC LIMIT 5");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error getting recent members: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get upcoming events (next 5)
     * @return array
     */
    private function getUpcomingEvents()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT title, event_date FROM events WHERE event_date >= CURRENT_DATE() AND status = 'active' ORDER BY event_date ASC LIMIT 5");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error getting upcoming events: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get recent donations (last 5)
     * @return array
     */
    private function getRecentDonations()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT 
                    d.amount, 
                    d.created_at as donation_date,
                    CONCAT(m.first_name, ' ', m.last_name) as donor_name,
                    p.name as project_name
                FROM donations d 
                JOIN members m ON d.member_id = m.id 
                LEFT JOIN projects p ON d.project_id = p.id 
                ORDER BY d.created_at DESC 
                LIMIT 5
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error getting recent donations: " . $e->getMessage());
            return [];
        }
    }
}
