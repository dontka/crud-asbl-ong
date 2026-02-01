<?php
/**
 * Configuration File
 * Based on Phase 3: Environment Setup and Base Structure - Step 3.3
 */

// Database Configuration
// Use environment variables for security in production
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'crud_asbl_ong');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'CRUD ASBL-ONG System');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://crud-asbl-ong.test'); // Adjust for your virtual host

// Paths
define('ROOT_PATH', __DIR__ . '/');
define('CONFIG_PATH', ROOT_PATH . 'config/');
define('MODELS_PATH', ROOT_PATH . 'models/');
define('CONTROLLERS_PATH', ROOT_PATH . 'controllers/');
define('VIEWS_PATH', ROOT_PATH . 'views/');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('DATABASE_PATH', ROOT_PATH . 'database/');

// Error Reporting (set to false in production)
ini_set('display_errors', true);
error_reporting(E_ALL);
?>