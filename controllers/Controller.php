<?php

/**
 * Base Controller Class
 * Based on Phase 4: Backend Development - Step 4.3 Controllers and Business Logic
 * Provides common functionality for all controllers
 */

abstract class Controller
{
    protected $model;

    public function __construct()
    {
        $this->startSession();
    }

    /**
     * Start session if not already started
     */
    protected function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Check if user is authenticated
     * @return bool
     */
    protected function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get current user data
     * @return array|null
     */
    protected function getCurrentUser()
    {
        if ($this->isAuthenticated()) {
            return $_SESSION['user'] ?? null;
        }
        return null;
    }

    /**
     * Check if current user has required role
     * @param string|array $roles
     * @return bool
     */
    protected function hasRole($roles)
    {
        $user = $this->getCurrentUser();
        if (!$user) return false;

        if (is_array($roles)) {
            return in_array($user['role'], $roles);
        }
        return $user['role'] === $roles;
    }

    /**
     * Require authentication
     */
    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login.php');
        }
    }

    /**
     * Require specific role
     * @param string|array $roles
     */
    protected function requireRole($roles)
    {
        $this->requireAuth();
        if (!$this->hasRole($roles)) {
            $this->setFlash('error', 'Access denied. Insufficient permissions.');
            $this->redirect('/dashboard.php');
        }
    }

    /**
     * Redirect to URL
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Set flash message
     * @param string $type
     * @param string $message
     */
    protected function setFlash($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Get and clear flash message
     * @return array|null
     */
    protected function getFlash()
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Render a view
     * @param string $view
     * @param array $data
     */
    protected function render($view, $data = [])
    {
        // Extract data to variables
        extract($data);

        // Include header
        include VIEWS_PATH . 'header.php';

        // Include the view
        $viewPath = VIEWS_PATH . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<p>View not found: {$view}</p>";
        }

        // Include footer
        include VIEWS_PATH . 'footer.php';
    }

    /**
     * Render only the content without layout
     * @param string $view
     * @param array $data
     */
    protected function renderContent($view, $data = [])
    {
        // Extract data to variables
        extract($data);

        // Include the view
        $viewPath = VIEWS_PATH . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<p>View not found: {$view}</p>";
        }
    }

    /**
     * Render with full layout (header, sidebar, content, footer)
     * @param string $view
     * @param array $data
     * @param string $pageTitle
     */
    protected function renderPage($view, $data = [], $pageTitle = '')
    {
        // Extract data to variables
        extract($data);

        // Get flash message if available
        $flash = $this->getFlash();

        // Include header
        include VIEWS_PATH . 'header.php';

        // Include sidebar
        include VIEWS_PATH . 'sidebar.php';

        // Include the main content
        $viewPath = VIEWS_PATH . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<p>View not found: {$view}</p>";
        }

        // Include footer
        include VIEWS_PATH . 'footer.php';
    }

    /**
     * Handle validation errors
     * @param Exception $e
     */
    protected function handleValidationError($e)
    {
        $this->setFlash('error', $e->getMessage());

        // For POST requests, redirect back to the form with errors
        // For GET requests, redirect to a safe location
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the current route to determine where to redirect
            $referer = $_SERVER['HTTP_REFERER'] ?? '';
            if (!empty($referer) && strpos($referer, BASE_URL) === 0) {
                $this->redirect($referer);
            } else {
                // Fallback: redirect to the index page of the current section
                $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
                $path = parse_url($currentUrl, PHP_URL_PATH);
                $segments = explode('/', trim($path, '/'));
                $section = $segments[0] ?? 'dashboard';
                $this->redirect('/' . $section);
            }
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Get POST data
     * @return array
     */
    protected function getPostData()
    {
        return $_POST;
    }

    /**
     * Get GET data
     * @return array
     */
    protected function getQueryData()
    {
        return $_GET;
    }

    /**
     * Sanitize input
     * @param string $data
     * @return string
     */
    protected function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}
