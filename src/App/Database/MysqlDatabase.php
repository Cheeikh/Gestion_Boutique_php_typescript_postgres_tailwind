<?php
// src/App/Database/MysqlDatabase.php

namespace App\Database;

use PDO;
use PDOException;

class MysqlDatabase {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getPDO() {
        return $this->pdo;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log or handle the exception as needed
            throw new PDOException('Query failed: ' . $e->getMessage());
        }
    }

    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log or handle the exception as needed
            throw new PDOException('Execution failed: ' . $e->getMessage());
        }
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
