<?php

namespace Core;

use PDO;
use PDOException;

class Model {
    private $pdo;
    protected $table;
    protected $fillable;
    private $stmt;

    public function __construct() {
        $this->pdo = Database::getInstance();

    }

    private function execute($sql, $params = []) {
        try {
            $this->stmt = $this->pdo->getConnection()->prepare($sql);
            $this->stmt->execute($params);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function all() {
        $this->execute("SELECT * FROM ".$this->table);
        return $this;
    }

    public function create($params) {
        try {
            $sql = "INSERT INTO $this->table (" . implode(",", array_values($this->fillable)) . ") VALUES (?,?,?)";
            $this->execute($sql, array_values($params));
            return $params;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function find($id) {
        $this->execute("SELECT * FROM ".$this->table." WHERE id = ?", [$id]);
        return $this;
    }

    public function where($column, $operator, $value) {
        $this->execute("SELECT * FROM $this->table WHERE $column $operator ?", [$value]);
        return $this;
    }

    public function get() {
        return $this->stmt->fetchAll(PDO::FETCH_CLASS);
    }
}