<?php
// src/App/Model/Model.php
namespace App\Model;

use App\Database\MysqlDatabase;
use PDO;

abstract class Model {
    protected $table;
    protected $database;

    public function __construct(MysqlDatabase $database) {
        $this->database = $database;
    }

    public function all() {
        return $this->query('SELECT * FROM ' . $this->table);
    }

    public function find($id) {
        return $this->query('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }

    protected function query($sql, $params = []) {
        $stmt = $this->database->getPDO()->prepare($sql);
        $stmt->execute($params);
        
        // Si la requête est un INSERT, retourne l'ID du dernier enregistrement inséré
        if (preg_match('/^INSERT/i', $sql)) {
            return $this->database->getPDO()->lastInsertId();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(array $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));
    }

    public function update($id, array $data) {
        $columns = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$this->table} SET {$columns} WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;
        $this->query($sql, $params);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->query($sql, [$id]);
    }

    public function hasMany($model, $foreign_key) {
        $sql = "SELECT * FROM {$model->getTable()} WHERE {$foreign_key} = ?";
        return $this->query($sql, [$this->id]);
    }

    public function belongsTo($model, $foreign_key) {
        $sql = "SELECT * FROM {$model->getTable()} WHERE id = ?";
        return $this->query($sql, [$this->{$foreign_key}]);
    }

    public function belongsToMany($model, $pivot, $foreign_key, $other_key) {
        $sql = "SELECT * FROM {$model->getTable()} 
                JOIN {$pivot} ON {$pivot}.{$other_key} = {$model->getTable()}.id 
                WHERE {$pivot}.{$foreign_key} = ?";
        return $this->query($sql, [$this->id]);
    }

    public function hasOne($model, $foreign_key) {
        $sql = "SELECT * FROM {$model->getTable()} WHERE {$foreign_key} = ?";
        return $this->query($sql, [$this->id]);
    }

    public function transaction(callable $callback) {
        try {
            $this->database->getPDO()->beginTransaction();
            $callback($this);
            $this->database->getPDO()->commit();
        } catch (\Exception $e) {
            $this->database->getPDO()->rollBack();
            throw $e;
        }
    }

    protected function getTable() {
        return $this->table;
    }
}
