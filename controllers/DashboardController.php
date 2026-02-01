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

            // Get total donations this month
            $stmt = $db->query("SELECT SUM(amount) as total FROM donations WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
            $stats['monthly_donations'] = $stmt->fetch()['total'] ?? 0;

            return $stats;
        } catch (Exception $e) {
            error_log("Error getting dashboard stats: " . $e->getMessage());
            return [
                'total_members' => 0,
                'total_projects' => 0,
                'total_events' => 0,
                'monthly_donations' => 0
            ];
        }
    }
}
