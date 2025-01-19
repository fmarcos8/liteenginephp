<?php

namespace Core;

class Migration {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    protected function execute($sql, $params = []): void {
        $conn = $this->pdo->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    }

    public static function getMigrationClassName($fileName): string {
        $className = pathinfo($fileName, PATHINFO_FILENAME);
        return str_replace('_', '', ucwords($className, '_'));
    }
}