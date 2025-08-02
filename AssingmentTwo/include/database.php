<?php
require_once 'connection.php';

class Database
{
    private static $instance = null;
    private $pdo;

    // Private constructor to prevent multiple instances
    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // In production, log this error instead of displaying it
            die('Connection failed: ' . $e->getMessage());
        }
    }

    // Get the singleton instance
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    // Get the underlying PDO connection (if needed)
    public function getConnection(): PDO
    {
        return self::getInstance();
    }
}
?>
