<?php

/**
 * Router principal du système CRUD ASBL-ONG
 * Toutes les routes et contrôleurs sont gérés ici
 */

try {
    // Connexion simple à la base de données (suppose que la base est déjà installée)
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    $db->selectDatabase(DB_NAME);

    // Get the current route
    $route = getRoute();

    // Handle routing
    switch ($route) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                handleLoginAuthenticate();
            } else {
                handleLogin();
            }
            break;
        case 'logout':
            handleLogout();
            break;
        case 'dashboard':
            handleDashboard();
            break;
        case 'users':
            handleUsers();
            break;
        case 'members':
            handleMembers();
            break;
        case 'projects':
            handleProjects();
            break;
        case 'events':
            handleEvents();
            break;
        case 'donations':
            handleDonations();
            break;
        case 'documentation':
            handleDocumentation();
            break;
        case 'search':
            handleSearch();
            break;
        default:
            // Default to dashboard if authenticated, login if not
            if (isAuthenticated()) {
                handleDashboard();
            } else {
                handleLogin();
            }
            break;
    }
} catch (Exception $e) {
    displayError($e->getMessage());
}


/**
 * Get the current route from URL
 * @return string
 */
function getRoute()
{
    $requestUri = $_SERVER['REQUEST_URI'];
    $scriptName = $_SERVER['SCRIPT_NAME'];

    // Remove script name from URI
    $path = str_replace(dirname($scriptName), '', $requestUri);

    // Remove query string
    $path = parse_url($path, PHP_URL_PATH);

    // Remove leading/trailing slashes
    $path = trim($path, '/');

    // Get the first segment as route
    $segments = explode('/', $path);
    $route = $segments[0] ?? '';

    return $route;
}

/**
 * Check if user is authenticated
 * @return bool
 */
function isAuthenticated()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}

/**
 * Display error message
 * @param string $message
 */
function displayError($message)
{
    $pageTitle = 'Erreur';
    include 'views/header.php';
    echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
    include 'views/footer.php';
}

// --- Handler Functions for Routing ---
function handleDashboard()
{
    require_once __DIR__ . '/../controllers/DashboardController.php';
    $controller = new DashboardController();
    $controller->index();
}

function handleLogin()
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->login();
}

function handleLoginAuthenticate()
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->authenticate();
}

function handleLogout()
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->logout();
}

function handleUsers()
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->index();
}

function handleMembers()
{
    require_once __DIR__ . '/../controllers/MemberController.php';
    $controller = new MemberController();
    $controller->index();
}

function handleProjects()
{
    require_once __DIR__ . '/../controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->index();
}

function handleEvents()
{
    require_once __DIR__ . '/../controllers/EventController.php';
    $controller = new EventController();
    $controller->index();
}

function handleDonations()
{
    require_once __DIR__ . '/../controllers/DonationController.php';
    $controller = new DonationController();
    $controller->index();
}

function handleDocumentation()
{
    require_once __DIR__ . '/../controllers/DocumentationController.php';
    $controller = new DocumentationController();
    $controller->index();
}

function handleSearch()
{
    require_once __DIR__ . '/../controllers/SearchController.php';
    $controller = new SearchController();
    $controller->index();
}
