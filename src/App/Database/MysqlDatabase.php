<?php
// src/App/Database/MysqlDatabase.php

namespace App\Database;

use PDO;
use PDOException;

class MysqlDatabase implements DatabaseInterface {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }

    public function query(string $sql, array $params = [], string $entityClass = null): array {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            if ($entityClass) {
                $stmt->setFetchMode(PDO::FETCH_CLASS, $entityClass);
                return $stmt->fetchAll();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException('Query failed: ' . $e->getMessage());
        }
    }

    public function execute(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new PDOException('Execution failed: ' . $e->getMessage());
        }
    }

    public function prepare(string $sql) {
        return $this->pdo->prepare($sql);
    }

    public function lastInsertId(): string {
        return $this->pdo->lastInsertId();
    }
}
