<?php
// src/App/Database/DatabaseInterface.php

namespace App\Database;

use PDO;

interface DatabaseInterface {
    public function getPDO(): PDO;
    public function query(string $sql, array $params = []): array;
    public function execute(string $sql, array $params = []): bool;
    public function prepare(string $sql);
    public function lastInsertId(): string;
}
