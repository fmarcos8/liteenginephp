<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $config = include __DIR__ . '/../config.php';
        $dbConfig = $config['db'];

        try {
            $this->connection = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']}",
                $dbConfig['user'],
                $dbConfig['pass']
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public static function getInstance(): Database {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

}