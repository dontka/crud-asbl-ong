<?php
/**
 * Environment Validation Script
 * Based on Phase 3: Environment Setup - Step 3.1
 * Run this to verify PHP extensions, database connection, and setup.
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../autoloader.php';

echo "<h1>Environment Validation</h1>";

// Check PHP Version
echo "<h2>PHP Version</h2>";
echo "<p>Current PHP Version: " . phpversion() . "</p>";
echo "<p>Required: 7.4+ - " . (version_compare(phpversion(), '7.4.0', '>=') ? '✓ OK' : '✗ Upgrade needed') . "</p>";

// Check Extensions
echo "<h2>PHP Extensions</h2>";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mysqli', 'mbstring', 'session'];
foreach ($requiredExtensions as $ext) {
    echo "<p>$ext: " . (extension_loaded($ext) ? '✓ Loaded' : '✗ Not loaded') . "</p>";
}

// Check Database Connection
echo "<h2>Database Connection</h2>";
try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    // Check if database exists
    if ($db->databaseExists(DB_NAME)) {
        $db->selectDatabase(DB_NAME);
        echo "<p>Database '" . DB_NAME . "': ✓ Exists</p>";

        // Check tables
        $tables = ['users', 'members', 'projects', 'events', 'donations'];
        foreach ($tables as $table) {
            echo "<p>Table '$table': " . ($db->tableExists($table) ? '✓ Exists' : '✗ Missing') . "</p>";
        }

        // Test query
        $stmt = $pdo->query("SELECT COUNT(*) as user_count FROM users");
        $result = $stmt->fetch();
        echo "<p>Test Query: ✓ Executed (Users: " . $result['user_count'] . ")</p>";
    } else {
        echo "<p>Database '" . DB_NAME . "': ✗ Does not exist. Run index.php first.</p>";
    }
} catch (Exception $e) {
    echo "<p>Database Error: ✗ " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Check File Permissions (basic)
echo "<h2>File Permissions</h2>";
$filesToCheck = ['../config.php', '../models/Database.php', '../database/schema.sql'];
foreach ($filesToCheck as $file) {
    echo "<p>$file: " . (is_readable($file) ? '✓ Readable' : '✗ Not readable') . "</p>";
}

echo "<h2>Summary</h2>";
echo "<p>If all checks show ✓, the environment is properly configured for Phase 4 development.</p>";
?>