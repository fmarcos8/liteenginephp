<?php

use Core\Migration;

class CreateUsersTable extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $this->execute($sql);
    }

    public function down() {
        $sql = "DROP TABLE users";
        $this->execute($sql);
    }
}