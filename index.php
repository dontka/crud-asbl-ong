<?php

/**
 * Main Entry Point for CRUD ASBL-ONG System
 * Handles routing and page display
 */

// Include configuration and autoloader
require_once 'config.php';
require_once 'autoloader.php';

try {
    // Initialize database connection
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    // Check if database setup is needed
    if (!$db->databaseExists(DB_NAME)) {
        $db->createDatabase(DB_NAME);
        $db->selectDatabase(DB_NAME);
        $db->executeSqlFile(DATABASE_PATH . 'schema.sql');
        $db->executeSqlFile(DATABASE_PATH . 'test_data.sql');
    } else {
        $db->selectDatabase(DB_NAME);
    }

    // Get the current route
    $route = getRoute();

    // Handle routing
    switch ($route) {
        case 'login':
            handleLogin();
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
 * Handle login page
 */
function handleLogin()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->authenticate();
        return;
    }

    $pageTitle = 'Connexion';
    $controller = new UserController();
    ob_start();
    $controller->login();
    $content = ob_get_clean();
    includeLayout('auth/login', $content);
}

/**
 * Handle logout
 */
function handleLogout()
{
    $controller = new UserController();
    $controller->logout();
}

/**
 * Handle dashboard
 */
function handleDashboard()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Dashboard';
    $controller = new DashboardController();
    ob_start();
    $controller->index();
    $content = ob_get_clean();
    includeLayout('dashboard/index', $content);
}

/**
 * Handle users management
 */
function handleUsers()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Gestion des Utilisateurs';
    $controller = new UserController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'index';
        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
        }
        return;
    }

    $action = $_GET['action'] ?? 'index';
    ob_start();
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'show':
            $controller->show();
            break;
        default:
            $controller->index();
            break;
    }
    $content = ob_get_clean();
    includeLayout('users/' . $action, $content);
}

/**
 * Handle members management
 */
function handleMembers()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Gestion des Membres';
    $controller = new MemberController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'index';
        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
        }
        return;
    }

    $action = $_GET['action'] ?? 'index';
    ob_start();
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'show':
            $controller->show();
            break;
        default:
            $controller->index();
            break;
    }
    $content = ob_get_clean();
    includeLayout('members/' . $action, $content);
}

/**
 * Handle projects management
 */
function handleProjects()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Gestion des Projets';
    $controller = new ProjectController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'index';
        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
        }
        return;
    }

    $action = $_GET['action'] ?? 'index';
    ob_start();
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'show':
            $controller->show();
            break;
        default:
            $controller->index();
            break;
    }
    $content = ob_get_clean();
    includeLayout('projects/' . $action, $content);
}

/**
 * Handle events management
 */
function handleEvents()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Gestion des Événements';
    $controller = new EventController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'index';
        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
        }
        return;
    }

    $action = $_GET['action'] ?? 'index';
    ob_start();
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'show':
            $controller->show();
            break;
        default:
            $controller->index();
            break;
    }
    $content = ob_get_clean();
    includeLayout('events/' . $action, $content);
}

/**
 * Handle donations management
 */
function handleDonations()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Gestion des Dons';
    $controller = new DonationController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'index';
        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
        }
        return;
    }

    $action = $_GET['action'] ?? 'index';
    ob_start();
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'show':
            $controller->show();
            break;
        default:
            $controller->index();
            break;
    }
    $content = ob_get_clean();
    includeLayout('donations/' . $action, $content);
}

/**
 * Handle search functionality
 */
function handleSearch()
{
    if (!isAuthenticated()) {
        redirect('/login');
        return;
    }

    $pageTitle = 'Search Results';
    $controller = new SearchController();
    ob_start();
    $controller->index();
    $content = ob_get_clean();
    includeLayout('search/index', $content);
}

/**
 * Include layout with header and footer
 * @param string $view Path to the view file (without .php)
 * @param string $content Optional content to display
 */
function includeLayout($view, $content = null)
{
    global $pageTitle;

    include 'views/header.php';

    if ($content) {
        echo $content;
    } else {
        $viewFile = 'views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo '<div class="alert alert-danger">Vue non trouvée: ' . htmlspecialchars($view) . '</div>';
        }
    }

    include 'views/footer.php';
}

/**
 * Redirect to a URL
 * @param string $url
 */
function redirect($url)
{
    header('Location: ' . BASE_URL . $url);
    exit;
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
