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

        // Get advanced widgets data
        $alerts = $this->getAlerts();
        $todo_tasks = $this->getTodoTasks();

        // Get chart data
        $chart_data = $this->getChartData();

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

            // RH Stats
            $stmt = $db->query("SELECT COUNT(*) as total FROM employes WHERE status = 'active'");
            $stats['total_employes'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM contrats WHERE status = 'actif'");
            $stats['contrats_actifs'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM absences WHERE status = 'demande'");
            $stats['absences_en_cours'] = $stmt->fetch()['total'];

            // Finance Stats
            $stmt = $db->query("SELECT SUM(amount) as total FROM budgets");
            $stats['total_budgets'] = $stmt->fetch()['total'] ?? 0;

            $stmt = $db->query("SELECT COUNT(*) as total FROM factures WHERE statut = 'brouillon'");
            $stats['factures_en_cours'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM releves_bancaires");
            $stats['releves_bancaires'] = $stmt->fetch()['total'];

            // Projets Stats
            $stmt = $db->query("SELECT COUNT(*) as total FROM taches WHERE statut = 'en_cours'");
            $stats['total_taches'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM risques WHERE niveau = 'eleve'");
            $stats['risques_ouverts'] = $stmt->fetch()['total'];

            // CRM Stats
            $stmt = $db->query("SELECT COUNT(*) as total FROM contacts");
            $stats['total_contacts'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM campagnes WHERE statut = 'active'");
            $stats['campagnes_actives'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM engagements WHERE statut = 'promesse'");
            $stats['engagements_en_cours'] = $stmt->fetch()['total'];

            // Documents Stats
            $stmt = $db->query("SELECT COUNT(*) as total FROM documents WHERE statut = 'actif'");
            $stats['total_documents'] = $stmt->fetch()['total'];

            $stmt = $db->query("SELECT COUNT(*) as total FROM audit_trail");
            $stats['audit_trail'] = $stmt->fetch()['total'];

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
                'recent_donations_count' => 0,
                'total_employes' => 0,
                'contrats_actifs' => 0,
                'absences_en_cours' => 0,
                'total_budgets' => 0,
                'factures_en_cours' => 0,
                'releves_bancaires' => 0,
                'total_taches' => 0,
                'risques_ouverts' => 0,
                'total_contacts' => 0,
                'campagnes_actives' => 0,
                'engagements_en_cours' => 0,
                'total_documents' => 0,
                'audit_trail' => 0
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

    /**
     * Get alerts and notifications
     * @return array
     */
    private function getAlerts()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $alerts = [];

            // Check for expiring contracts
            $stmt = $db->query("SELECT COUNT(*) as total FROM contrats WHERE end_date <= DATE_ADD(CURRENT_DATE(), INTERVAL 30 DAY) AND status = 'actif'");
            $expiring_contracts = $stmt->fetch()['total'];
            if ($expiring_contracts > 0) {
                $alerts[] = ['message' => "$expiring_contracts contrats expirent bientôt"];
            }

            // Check for overdue tasks
            $stmt = $db->query("SELECT COUNT(*) as total FROM taches WHERE echeance < CURRENT_DATE() AND statut != 'terminee'");
            $overdue_tasks = $stmt->fetch()['total'];
            if ($overdue_tasks > 0) {
                $alerts[] = ['message' => "$overdue_tasks tâches en retard"];
            }

            // Check for high risks
            $stmt = $db->query("SELECT COUNT(*) as total FROM risques WHERE niveau = 'eleve'");
            $high_risks = $stmt->fetch()['total'];
            if ($high_risks > 0) {
                $alerts[] = ['message' => "$high_risks risques élevés à gérer"];
            }

            return $alerts;
        } catch (Exception $e) {
            error_log("Error getting alerts: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get todo tasks
     * @return array
     */
    private function getTodoTasks()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT titre, statut FROM taches WHERE statut IN ('a_faire', 'en_cours') ORDER BY echeance ASC LIMIT 5");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error getting todo tasks: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get chart data for graphs
     * @return array
     */
    private function getChartData()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $chart_data = [];

            // Donations over last 6 months
            $stmt = $db->query("
                SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    SUM(amount) as total
                FROM donations 
                WHERE created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month ASC
            ");
            $donations_data = $stmt->fetchAll();
            $chart_data['donations'] = [
                'labels' => array_column($donations_data, 'month'),
                'data' => array_column($donations_data, 'total')
            ];

            // Module distribution (simplified)
            $chart_data['modules'] = [
                'labels' => ['RH', 'Finance', 'Projets', 'CRM', 'Documents', 'Support'],
                'data' => [
                    $this->getTableCount('employes'),
                    $this->getTableCount('budgets'),
                    $this->getTableCount('projects'),
                    $this->getTableCount('contacts'),
                    $this->getTableCount('documents'),
                    0 // Support tickets not implemented yet
                ]
            ];

            // HR data
            $chart_data['hr'] = [
                'labels' => ['Employés actifs', 'Contrats actifs', 'Absences en cours', 'Pointages du mois'],
                'data' => [
                    $this->getTableCount('employes', "status = 'active'"),
                    $this->getTableCount('contrats', "status = 'actif'"),
                    $this->getTableCount('absences', "status = 'demande'"),
                    $this->getTableCount('pointages', "MONTH(date) = MONTH(CURRENT_DATE())")
                ]
            ];

            // Projects status
            $stmt = $db->query("SELECT status, COUNT(*) as count FROM projects GROUP BY status");
            $project_status = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            $chart_data['projects'] = [
                'labels' => ['Planification', 'Actif', 'Terminé', 'En pause'],
                'data' => [
                    $project_status['planning'] ?? 0,
                    $project_status['active'] ?? 0,
                    $project_status['completed'] ?? 0,
                    $project_status['on_hold'] ?? 0
                ]
            ];

            return $chart_data;
        } catch (Exception $e) {
            error_log("Error getting chart data: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Helper method to get count from table with optional condition
     * @param string $table
     * @param string $condition
     * @return int
     */
    private function getTableCount($table, $condition = '1=1')
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT COUNT(*) as total FROM $table WHERE $condition");
            return $stmt->fetch()['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
}
