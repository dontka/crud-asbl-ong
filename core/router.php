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
        case 'hr':
            handleHR();
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

function handleHR()
{
    // Check HR access before instantiating controller
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    error_log("=== handleHR() CALLED ===");
    error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);
    error_log("user_id isset: " . (isset($_SESSION['user_id']) ? "YES" : "NO"));
    error_log("user_id value: " . ($_SESSION['user_id'] ?? 'NULL'));
    error_log("user role: " . ($_SESSION['user']['role'] ?? 'NULL'));
    
    // First, check if user is authenticated at all
    if (!isset($_SESSION['user_id'])) {
        error_log("REDIRECT: Not authenticated -> /login");
        // User not authenticated, redirect to login
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        header("Location: " . $protocol . $host . "/login");
        exit;
    }
    
    // For now, allow all authenticated users to access HR (can be restricted later)
    $allowedRoles = ['admin', 'moderator', 'hr_manager', 'supervisor', 'hr', 'manager', 'user', 'visitor'];
    $userRole = $_SESSION['user']['role'] ?? null;
    
    error_log("userRole: " . ($userRole ?? 'NULL'));
    error_log("in_array result: " . (in_array($userRole, $allowedRoles) ? "YES" : "NO"));
    
    if (!in_array($userRole, $allowedRoles) || empty($userRole)) {
        error_log("REDIRECT: Invalid role or empty -> /dashboard");
        // Redirect without using BASE_URL to avoid issues
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        header("Location: " . $protocol . $host . "/dashboard");
        exit;
    }
    
    error_log("PASSED authentication and role check, proceeding to controller");
    
    require_once __DIR__ . '/../controllers/HRController.php';
    $controller = new HRController();

    // Get request path and method
    $requestUri = $_SERVER['REQUEST_URI'];
    $path = parse_url($requestUri, PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    // Parse HR routes
    if (preg_match('#^/hr/dashboard$#', $path)) {
        $controller->dashboard();
    } elseif (preg_match('#^/hr/payroll/(\d+)/pdf$#', $path, $matches)) {
        $controller->payrollPDF($matches[1]);
    } elseif (preg_match('#^/hr/payroll/(\d+)/delete$#', $path, $matches)) {
        $controller->deletePayroll($matches[1]);
    } elseif (preg_match('#^/hr/payroll/(\d+)/edit$#', $path, $matches)) {
        $controller->editPayroll($matches[1]);
    } elseif (preg_match('#^/hr/payroll/create$#', $path)) {
        $controller->editPayroll();
    } elseif (preg_match('#^/hr/payroll$#', $path)) {
        $controller->payroll();
    } elseif (preg_match('#^/hr/absence/(\d+)/edit$#', $path, $matches)) {
        $controller->editAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absence/(\d+)/approve$#', $path, $matches)) {
        $controller->approveAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absence/(\d+)/reject$#', $path, $matches)) {
        $controller->rejectAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences/(\d+)/approve$#', $path, $matches) && $method === 'POST') {
        $controller->approveAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences/(\d+)/reject$#', $path, $matches) && $method === 'POST') {
        $controller->rejectAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences/(\d+)$#', $path, $matches)) {
        $controller->showAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences$#', $path)) {
        $controller->absences();
    } elseif (preg_match('#^/hr/evaluations/(\d+)/create$#', $path, $matches)) {
        $controller->createEvaluation($matches[1]);
    } elseif (preg_match('#^/hr/evaluations/?$#', $path) && $method === 'POST') {
        $controller->storeEvaluation();
    } elseif (preg_match('#^/hr/evaluations/?$#', $path)) {
        // DEBUG
        error_log("ROUTE MATCHED: /hr/evaluations - calling evaluations()");
        try {
            $controller->evaluations();
        } catch (Exception $e) {
            error_log("EXCEPTION in evaluations(): " . $e->getMessage());
            throw $e;
        }
    } elseif (preg_match('#^/hr/contract/(\d+)/delete$#', $path, $matches)) {
        $controller->deleteContract($matches[1]);
    } elseif (preg_match('#^/hr/contract/(\d+)/edit$#', $path, $matches)) {
        $controller->editContract($matches[1]);
    } elseif (preg_match('#^/hr/contract/(\d+)$#', $path, $matches) && $method === 'PUT') {
        $controller->updateContract($matches[1]);
    } elseif (preg_match('#^/hr/contract/(\d+)$#', $path, $matches)) {
        $controller->showContract($matches[1]);
    } elseif (preg_match('#^/hr/create-contract$#', $path)) {
        $controller->createContract();
    } elseif (preg_match('#^/hr/store-contract$#', $path) && $method === 'POST') {
        $controller->storeContract();
    } elseif (preg_match('#^/hr/contracts$#', $path)) {
        $controller->contracts();
    } elseif (preg_match('#^/hr/trainings$#', $path)) {
        $controller->trainings();
    } elseif (preg_match('#^/hr/skills/(\d+)/delete$#', $path, $matches)) {
        $controller->deleteSkill($matches[1]);
    } elseif (preg_match('#^/hr/skills/(\d+)/edit$#', $path, $matches)) {
        $controller->editSkill($matches[1]);
    } elseif (preg_match('#^/hr/skills/create$#', $path)) {
        $controller->editSkill();
    } elseif (preg_match('#^/hr/skills$#', $path)) {
        $controller->skills();
    } elseif (preg_match('#^/hr/(\d+)/edit$#', $path, $matches)) {
        $controller->edit($matches[1]);
    } elseif (preg_match('#^/hr/(\d+)$#', $path, $matches) && $method === 'PUT') {
        $controller->update($matches[1]);
    } elseif (preg_match('#^/hr/(\d+)$#', $path, $matches)) {
        $controller->show($matches[1]);
    } elseif (preg_match('#^/hr/create$#', $path)) {
        $controller->create();
    } elseif (preg_match('#^/hr/store$#', $path) && $method === 'POST') {
        $controller->store();
    } elseif (preg_match('#^/hr/?$#', $path)) {
        $controller->dashboard();
    } else {
        $controller->index();
    }
}
