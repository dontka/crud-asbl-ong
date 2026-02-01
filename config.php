<?php

// --- Chargement des variables d'environnement (.env) ---
function loadEnv($path)
{
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}
loadEnv(__DIR__ . '/.env');

// --- Chemins principaux (structure avancée) ---
define('ROOT_PATH', __DIR__ . '/');
define('CONFIG_PATH', ROOT_PATH . 'config/');
define('MODELS_PATH', ROOT_PATH . 'models/');
define('CONTROLLERS_PATH', ROOT_PATH . 'controllers/');
define('VIEWS_PATH', ROOT_PATH . 'views/');
define('MODULES_PATH', ROOT_PATH . 'modules/');
define('PLUGINS_PATH', ROOT_PATH . 'plugins/');
define('API_PATH', ROOT_PATH . 'api/');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('DATABASE_PATH', ROOT_PATH . 'database/');
define('INCLUDES_PATH', ROOT_PATH . 'includes/');
define('DOCS_PATH', ROOT_PATH . 'docs/');
define('TESTS_PATH', ROOT_PATH . 'tests/');

// --- Configuration de l'application ---
define('APP_NAME', getenv('APP_NAME') ?: 'CRUD ASBL-ONG System');
define('APP_VERSION', getenv('APP_VERSION') ?: '1.0.0');
define('APP_DEBUG', getenv('APP_DEBUG') ?: 'true');

// --- Configuration base de données ---
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'crud_asbl_ong');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// --- BASE_URL : priorité à APP_URL du .env, sinon détection dynamique ---
$envBaseUrl = getenv('APP_URL');
if (!empty($envBaseUrl)) {
    define('BASE_URL', rtrim($envBaseUrl, '/'));
} else {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    if ($basePath === '' || $basePath === '.') {
        $basePath = '';
    }
    define('BASE_URL', $protocol . '://' . $host . ($basePath !== '' && $basePath !== '/' ? $basePath : ''));
}

// --- Chargement des configurations avancées (modules, rôles, sécurité, plugins) ---
// Ces fichiers doivent exister dans /config/ et retourner un tableau PHP
function loadConfig($file)
{
    $path = CONFIG_PATH . $file;
    if (file_exists($path)) {
        return include $path;
    }
    return [];
}

$ROLES = loadConfig('roles.php');
$MODULES = loadConfig('modules.php');
$SECURITY = loadConfig('security.php');
$PLUGINS = loadConfig('plugins.php');

// --- Chargement dynamique des plugins actifs ---
function loadActivePlugins($plugins)
{
    foreach ($plugins as $plugin) {
        $pluginMain = PLUGINS_PATH . $plugin . '/Plugin.php';
        if (file_exists($pluginMain)) {
            require_once $pluginMain;
        }
    }
}
if (!empty($PLUGINS['active'])) {
    loadActivePlugins($PLUGINS['active']);
}

// --- Sécurité globale (headers, CSRF, etc.) ---
require_once INCLUDES_PATH . 'security_headers.php';
require_once INCLUDES_PATH . 'csrf.php';
require_once INCLUDES_PATH . 'sanitize.php';

// --- Gestion des erreurs et debug ---
ini_set('display_errors', APP_DEBUG === 'true' ? '1' : '0');
error_reporting(APP_DEBUG === 'true' ? E_ALL : 0);

// --- Fonctions utilitaires globales (logger, cache, etc.) ---
if (file_exists(INCLUDES_PATH . 'logger.php')) {
    require_once INCLUDES_PATH . 'logger.php';
}
if (file_exists(INCLUDES_PATH . 'cache.php')) {
    require_once INCLUDES_PATH . 'cache.php';
}
