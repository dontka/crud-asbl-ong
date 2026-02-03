<?php

/**
 * Contrôleur de gestion des données de test (Seeding)
 * Permet de générer des données fictives pour le développement et les tests
 */

class SeedController extends Controller
{
    /**
     * Affiche la page de seeding
     */
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!$this->isAuthenticated()) {
            $this->setFlash('error', 'Vous devez être connecté');
            header('Location: /login');
            exit;
        }

        // Vérifier que l'utilisateur est admin
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Accès refusé - Administrateur requis');
            header('Location: /dashboard');
            exit;
        }

        return $this->renderPage('admin/seeding', [
            'pageTitle' => 'Générateur de Données Fictives'
        ]);
    }

    /**
     * Exécute le seeding des données fictives
     */
    public function generateData()
    {
        // Vider tout buffer existant et empêcher toute sortie
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Démarrer un nouveau buffer pour capturer TOUT output
        ob_start();

        // S'assurer que le header JSON est défini EN PREMIER
        header('Content-Type: application/json; charset=utf-8');

        // Session check
        session_start();

        try {
            // Vérifier que l'utilisateur est connecté
            if (empty($_SESSION['user_id'])) {
                http_response_code(401);
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Vous devez être connecté']);
                exit;
            }

            // Vérifier que l'utilisateur est admin
            if (!$this->isAdmin()) {
                http_response_code(403);
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Vous n\'avez pas les permissions pour générer les données']);
                exit;
            }

            // Vérifier la confirmation
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['confirm']) || $input['confirm'] !== 'yes') {
                http_response_code(400);
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Confirmation manquante']);
                exit;
            }

            // Récupérer les types et quantités
            $types = $input['types'] ?? [];
            $quantities = $input['quantities'] ?? [];

            // Validation : au moins un type sélectionné
            if (empty($types)) {
                http_response_code(400);
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Aucun type de données sélectionné']);
                exit;
            }

            require_once __DIR__ . '/../database/seeds/FakerSeeder.php';

            // Capturer la sortie du seeder
            $seeder = new FakerSeeder();
            $seeder->seedSelective($types, $quantities);
            $output = ob_get_clean();

            // Retourner le JSON propre
            echo json_encode([
                'success' => true,
                'message' => 'Données fictives générées',
                'output' => $output
            ]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            ob_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors du seeding: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Vérifie si l'utilisateur est admin
     */
    private function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
