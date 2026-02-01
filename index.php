<?php
/**
 * Entry Point for CRUD ASBL-ONG System
 * Based on Phase 3: Environment Setup and Base Structure - Step 3.3
 * Automatically creates database and tables on first run
 */

// Include configuration and autoloader
require_once 'config.php';
require_once 'autoloader.php';

try {
    // Get database instance
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    // Check if database exists
    if (!$db->databaseExists(DB_NAME)) {
        echo "<h2>Setting up database...</h2>";
        $db->createDatabase(DB_NAME);
        echo "<p>Database '" . DB_NAME . "' created successfully.</p>";
    }

    // Select the database
    $db->selectDatabase(DB_NAME);

    // Check if tables exist (using users table as indicator)
    if (!$db->tableExists('users')) {
        echo "<h2>Creating tables...</h2>";

        // Execute schema.sql
        $db->executeSqlFile(DATABASE_PATH . 'schema.sql');
        echo "<p>Tables created successfully.</p>";

        echo "<h2>Inserting test data...</h2>";
        // Execute test_data.sql
        $db->executeSqlFile(DATABASE_PATH . 'test_data.sql');
        echo "<p>Test data inserted successfully.</p>";

        echo "<h2>Setup Complete!</h2>";
        echo "<p>The database has been initialized with sample data.</p>";
        echo "<p>You can now proceed with developing the application.</p>";
    } else {
        echo "<h2>Database Already Initialized</h2>";
        echo "<p>The system is ready to use.</p>";
    }

    // Basic welcome message
    echo "<h1>Welcome to " . APP_NAME . "</h1>";
    echo "<p>Version: " . APP_VERSION . "</p>";
    echo "<p>Next steps: Implement authentication, models, controllers, and views.</p>";

} catch (Exception $e) {
    echo "<h2>Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Please check your database configuration and ensure MySQL is running.</p>";
}
?>