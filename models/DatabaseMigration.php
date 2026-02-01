<?php

/**
 * Database Migration Class
 * Phase 7: Deployment and Maintenance - Step 7.1
 * Handles database schema updates and data migration
 */

class DatabaseMigration
{
    private $db;
    public function getMigrations()
    {
        return $this->migrations;
    }

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->loadMigrations();
    }

    public function runMigrations()
    {
        echo "🗄️  Running Database Migrations\n";
        echo "===============================\n\n";

        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        foreach ($this->migrations as $version => $migration) {
            if (!in_array($version, $appliedMigrations)) {
                echo "Applying migration: $version - {$migration['description']}\n";

                try {
                    $this->db->beginTransaction();

                    // Run migration SQL
                    if (isset($migration['up'])) {
                        $this->db->exec($migration['up']);
                    }

                    // Run migration PHP code
                    if (isset($migration['up_callback'])) {
                        call_user_func($migration['up_callback'], $this->db);
                    }

                    // Record migration as applied
                    $this->recordMigration($version);

                    $this->db->commit();
                    echo "✅ Migration $version applied successfully\n";
                } catch (Exception $e) {
                    $this->db->rollBack();
                    echo "❌ Migration $version failed: " . $e->getMessage() . "\n";
                    return false;
                }
            } else {
                echo "⏭️  Migration $version already applied\n";
            }
        }

        echo "\n✅ All migrations completed!\n";
        return true;
    }

    public function createBackup()
    {
        echo "💾 Creating database backup before migration...\n";

        $backupFile = "backups/pre_migration_backup_" . date('Y-m-d_H-i-s') . ".sql";

        try {
            // Get all tables
            $tables = $this->db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

            $sql = "-- Pre-migration backup: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

            foreach ($tables as $table) {
                // Get table structure
                $stmt = $this->db->query("SHOW CREATE TABLE `$table`");
                $createTable = $stmt->fetch(PDO::FETCH_ASSOC);
                $sql .= $createTable['Create Table'] . ";\n\n";

                // Get table data
                $stmt = $this->db->query("SELECT * FROM `$table`");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($rows)) {
                    $columns = array_keys($rows[0]);
                    $sql .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES\n";

                    $values = [];
                    foreach ($rows as $row) {
                        $rowValues = [];
                        foreach ($row as $value) {
                            $rowValues[] = $this->db->quote($value);
                        }
                        $values[] = "(" . implode(", ", $rowValues) . ")";
                    }

                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";

            if (!is_dir('backups')) {
                mkdir('backups', 0755, true);
            }

            file_put_contents($backupFile, $sql);
            echo "✅ Backup created: $backupFile (" . strlen($sql) . " bytes)\n";

            return $backupFile;
        } catch (Exception $e) {
            echo "❌ Backup failed: " . $e->getMessage() . "\n";
            return false;
        }
    }

    private function createMigrationsTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                version VARCHAR(255) NOT NULL UNIQUE,
                applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                description TEXT
            )
        ");
    }

    private function getAppliedMigrations()
    {
        $stmt = $this->db->query("SELECT version FROM migrations ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function recordMigration($version)
    {
        $stmt = $this->db->prepare("
            INSERT INTO migrations (version, description)
            VALUES (?, ?)
        ");

        $description = $this->migrations[$version]['description'] ?? 'Migration ' . $version;
        $stmt->execute([$version, $description]);
    }

    private function loadMigrations()
    {
        // Define migrations in order
        $this->migrations = [
            '001_initial_schema' => [
                'description' => 'Create initial database schema',
                'up' => "
                    -- Initial schema already created by schema.sql
                    -- This migration marks the schema as applied
                "
            ],

            '002_add_user_roles' => [
                'description' => 'Add role column to users table',
                'up_callback' => function ($db) {
                    // Check if all required columns exist
                    $roleExists = $db->query("SHOW COLUMNS FROM users LIKE 'role'")->rowCount() > 0;
                    $createdAtExists = $db->query("SHOW COLUMNS FROM users LIKE 'created_at'")->rowCount() > 0;
                    $updatedAtExists = $db->query("SHOW COLUMNS FROM users LIKE 'updated_at'")->rowCount() > 0;

                    // Only add missing columns
                    if (!$roleExists) {
                        $db->exec("ALTER TABLE users ADD COLUMN role ENUM('admin', 'moderator', 'member', 'visitor') DEFAULT 'visitor'");
                    }
                    if (!$createdAtExists) {
                        $db->exec("ALTER TABLE users ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                    }
                    if (!$updatedAtExists) {
                        $db->exec("ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                    }
                }
            ],

            '003_add_member_status' => [
                'description' => 'Add status column to members table',
                'up_callback' => function ($db) {
                    // Check if all required columns exist
                    $statusExists = $db->query("SHOW COLUMNS FROM members LIKE 'status'")->rowCount() > 0;
                    $createdAtExists = $db->query("SHOW COLUMNS FROM members LIKE 'created_at'")->rowCount() > 0;
                    $updatedAtExists = $db->query("SHOW COLUMNS FROM members LIKE 'updated_at'")->rowCount() > 0;

                    // Only add missing columns
                    if (!$statusExists) {
                        $db->exec("ALTER TABLE members ADD COLUMN status ENUM('active', 'inactive', 'suspended') DEFAULT 'active'");
                    }
                    if (!$createdAtExists) {
                        $db->exec("ALTER TABLE members ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                    }
                    if (!$updatedAtExists) {
                        $db->exec("ALTER TABLE members ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                    }
                }
            ],

            '004_add_project_status' => [
                'description' => 'Add status column to projects table',
                'up_callback' => function ($db) {
                    // Check if all required columns exist
                    $statusExists = $db->query("SHOW COLUMNS FROM projects LIKE 'status'")->rowCount() > 0;
                    $createdAtExists = $db->query("SHOW COLUMNS FROM projects LIKE 'created_at'")->rowCount() > 0;
                    $updatedAtExists = $db->query("SHOW COLUMNS FROM projects LIKE 'updated_at'")->rowCount() > 0;

                    // Only add missing columns
                    if (!$statusExists) {
                        $db->exec("ALTER TABLE projects ADD COLUMN status ENUM('planning', 'active', 'completed', 'cancelled') DEFAULT 'planning'");
                    }
                    if (!$createdAtExists) {
                        $db->exec("ALTER TABLE projects ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                    }
                    if (!$updatedAtExists) {
                        $db->exec("ALTER TABLE projects ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                    }
                }
            ],

            '005_add_event_status' => [
                'description' => 'Add status column to events table',
                'up_callback' => function ($db) {
                    // Check if all required columns exist
                    $statusExists = $db->query("SHOW COLUMNS FROM events LIKE 'status'")->rowCount() > 0;
                    $createdAtExists = $db->query("SHOW COLUMNS FROM events LIKE 'created_at'")->rowCount() > 0;
                    $updatedAtExists = $db->query("SHOW COLUMNS FROM events LIKE 'updated_at'")->rowCount() > 0;

                    // Only add missing columns
                    if (!$statusExists) {
                        $db->exec("ALTER TABLE events ADD COLUMN status ENUM('planned', 'confirmed', 'cancelled', 'completed') DEFAULT 'planned'");
                    }
                    if (!$createdAtExists) {
                        $db->exec("ALTER TABLE events ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                    }
                    if (!$updatedAtExists) {
                        $db->exec("ALTER TABLE events ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                    }
                }
            ],

            '006_add_donation_tracking' => [
                'description' => 'Add tracking columns to donations table',
                'up_callback' => function ($db) {
                    // Check if all required columns exist
                    $columns = ['payment_method', 'transaction_id', 'notes', 'created_at', 'updated_at'];
                    $existingColumns = [];

                    foreach ($columns as $column) {
                        if ($db->query("SHOW COLUMNS FROM donations LIKE '$column'")->rowCount() > 0) {
                            $existingColumns[] = $column;
                        }
                    }

                    // Only add missing columns
                    if (!in_array('payment_method', $existingColumns)) {
                        $db->exec("ALTER TABLE donations ADD COLUMN payment_method VARCHAR(50)");
                    }
                    if (!in_array('transaction_id', $existingColumns)) {
                        $db->exec("ALTER TABLE donations ADD COLUMN transaction_id VARCHAR(255)");
                    }
                    if (!in_array('notes', $existingColumns)) {
                        $db->exec("ALTER TABLE donations ADD COLUMN notes TEXT");
                    }
                    if (!in_array('created_at', $existingColumns)) {
                        $db->exec("ALTER TABLE donations ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
                    }
                    if (!in_array('updated_at', $existingColumns)) {
                        $db->exec("ALTER TABLE donations ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                    }
                }
            ],

            '007_create_indexes' => [
                'description' => 'Create performance indexes',
                'up_callback' => function ($db) {
                    $indexes = [
                        "CREATE INDEX idx_members_status ON members(status)",
                        "CREATE INDEX idx_members_email ON members(email)",
                        "CREATE INDEX idx_members_join_date ON members(join_date)",
                        "CREATE INDEX idx_projects_status ON projects(status)",
                        "CREATE INDEX idx_events_status ON events(status)",
                        "CREATE INDEX idx_events_event_date ON events(event_date)",
                        "CREATE INDEX idx_donations_member_id ON donations(member_id)",
                        "CREATE INDEX idx_donations_created_at ON donations(created_at)",
                        "CREATE INDEX idx_users_username ON users(username)",
                        "CREATE INDEX idx_users_email ON users(email)"
                    ];

                    foreach ($indexes as $index) {
                        try {
                            $db->exec($index);
                        } catch (Exception $e) {
                            // Index might already exist, ignore
                        }
                    }
                }
            ],

            '008_add_security_logs' => [
                'description' => 'Create security logging table',
                'up_callback' => function ($db) {
                    $db->exec("
                        CREATE TABLE IF NOT EXISTS security_logs (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            user_id INT NULL,
                            action VARCHAR(255) NOT NULL,
                            ip_address VARCHAR(45),
                            user_agent TEXT,
                            details JSON,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
                        )
                    ");
                }
            ],

            '009_add_cache_table' => [
                'description' => 'Create caching table',
                'up_callback' => function ($db) {
                    $db->exec("
                        CREATE TABLE IF NOT EXISTS cache (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            cache_key VARCHAR(255) NOT NULL UNIQUE,
                            cache_value LONGTEXT,
                            expires_at TIMESTAMP NULL,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            INDEX idx_cache_key (cache_key),
                            INDEX idx_expires_at (expires_at)
                        )
                    ");
                }
            ]
        ];
    }

    public function rollback($version = null)
    {
        echo "🔄 Rolling back migrations...\n";

        if ($version === null) {
            // Rollback last migration
            $stmt = $this->db->query("SELECT version FROM migrations ORDER BY id DESC LIMIT 1");
            $lastMigration = $stmt->fetch(PDO::FETCH_COLUMN);

            if ($lastMigration && isset($this->migrations[$lastMigration]['down'])) {
                $this->rollbackMigration($lastMigration);
            }
        } else {
            // Rollback specific migration and all after it
            $appliedMigrations = $this->getAppliedMigrations();
            $rollbackVersions = [];

            foreach (array_reverse($appliedMigrations) as $appliedVersion) {
                $rollbackVersions[] = $appliedVersion;
                if ($appliedVersion === $version) {
                    break;
                }
            }

            foreach ($rollbackVersions as $rollbackVersion) {
                if (isset($this->migrations[$rollbackVersion]['down'])) {
                    $this->rollbackMigration($rollbackVersion);
                }
            }
        }
    }

    private function rollbackMigration($version)
    {
        echo "Rolling back migration: $version\n";

        try {
            $this->db->beginTransaction();

            // Run rollback SQL
            if (isset($this->migrations[$version]['down'])) {
                $this->db->exec($this->migrations[$version]['down']);
            }

            // Run rollback PHP code
            if (isset($this->migrations[$version]['down_callback'])) {
                call_user_func($this->migrations[$version]['down_callback'], $this->db);
            }

            // Remove migration record
            $stmt = $this->db->prepare("DELETE FROM migrations WHERE version = ?");
            $stmt->execute([$version]);

            $this->db->commit();
            echo "✅ Migration $version rolled back successfully\n";
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "❌ Rollback of migration $version failed: " . $e->getMessage() . "\n";
        }
    }
}
