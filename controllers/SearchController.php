<?php

/**
 * Search Controller
 * Handles global search across entities
 */

class SearchController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
    }

    /**
     * Display search results
     */
    public function index()
    {
        $query = $_GET['q'] ?? '';
        $results = [];

        if (!empty($query)) {
            $results = $this->performSearch($query);
        }

        // Include the view
        require_once 'views/search/index.php';
    }

    /**
     * Perform search across entities
     * @param string $query
     * @return array
     */
    private function performSearch($query)
    {
        $results = [
            'members' => [],
            'projects' => [],
            'events' => [],
            'donations' => []
        ];

        try {
            $db = Database::getInstance()->getConnection();

            // Search members
            $stmt = $db->prepare("SELECT id, first_name, last_name, email FROM members WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?) AND status = 'active' LIMIT 10");
            $searchTerm = "%$query%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            $results['members'] = $stmt->fetchAll();

            // Search projects
            $stmt = $db->prepare("SELECT id, name, description FROM projects WHERE (name LIKE ? OR description LIKE ?) AND status = 'active' LIMIT 10");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results['projects'] = $stmt->fetchAll();

            // Search events
            $stmt = $db->prepare("SELECT id, title, description FROM events WHERE (title LIKE ? OR description LIKE ?) AND status = 'active' LIMIT 10");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results['events'] = $stmt->fetchAll();

            // Search donations (by member name or amount)
            $stmt = $db->prepare("SELECT d.id, d.amount, d.created_at, m.first_name, m.last_name FROM donations d JOIN members m ON d.member_id = m.id WHERE (m.first_name LIKE ? OR m.last_name LIKE ?) LIMIT 10");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results['donations'] = $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error performing search: " . $e->getMessage());
        }

        return $results;
    }
}
