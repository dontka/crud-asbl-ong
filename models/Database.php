<?php

/**
 * Database Connection Class
 * Based on Phase 3: Environment Setup and Base Structure - Step 3.3
 * Uses Singleton pattern for DB connection
 */

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    // Method to check if database exists
    public function databaseExists($dbName)
    {
        $stmt = $this->pdo->query("SHOW DATABASES LIKE '$dbName'");
        return $stmt->rowCount() > 0;
    }

    // Method to create database
    public function createDatabase($dbName)
    {
        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    // Method to select database
    public function selectDatabase($dbName)
    {
        $this->pdo->exec("USE `$dbName`");
    }

    // Method to check if table exists
    public function tableExists($tableName)
    {
        $stmt = $this->pdo->query("SHOW TABLES LIKE '$tableName'");
        return $stmt->rowCount() > 0;
    }

    // Method to execute SQL file
    public function executeSqlFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("SQL file not found: $filePath");
        }

        $sql = file_get_contents($filePath);
        $this->pdo->exec($sql);
    }
}
