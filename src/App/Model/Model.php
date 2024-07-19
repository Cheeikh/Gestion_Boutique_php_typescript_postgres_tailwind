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
        return $this->query('SELECT * FROM ' . $this->table, [], get_called_class());
    }

    public function find($id) {
        $result = $this->query('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $result ? $result[0] : null;
    }

    public function findBy($field, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ?";
        return $this->query($sql, [$value]);
    }

    protected function query($sql, $params = [], $entityClass = null) {
        return $this->database->query($sql, $params, $entityClass);
    }

    public function save(array $data) {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
            $this->database->execute($sql, array_values($data));
            return $this->database->lastInsertId();
        }

    public function update($id, array $data) {
        $columns = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$this->table} SET {$columns} WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;
        return $this->database->execute($sql, $params);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->database->execute($sql, [$id]);
    }

    public function hasMany($modelClass, $foreignKey, $entity) {
        $model = new $modelClass($this->database);
        $sql = "SELECT * FROM {$model->getTable()} WHERE {$foreignKey} = ?";
        return $this->query($sql, [$entity->id], $modelClass);
    }

    public function belongsTo($modelClass, $foreignKey, $entity) {
        $model = new $modelClass($this->database);
        $sql = "SELECT * FROM {$model->getTable()} WHERE id = ?";
        $result = $this->query($sql, [$entity->{$foreignKey}], $modelClass);
        return $result ? $result[0] : null;
    }

    public function belongsToMany($modelClass, $pivotTable, $foreignKey, $otherKey, $entity) {
        $model = new $modelClass($this->database);
        $sql = "SELECT * FROM {$model->getTable()} 
                JOIN {$pivotTable} ON {$pivotTable}.{$otherKey} = {$model->getTable()}.id 
                WHERE {$pivotTable}.{$foreignKey} = ?";
        return $this->query($sql, [$entity->id], $modelClass);
    }

    public function hasOne($modelClass, $foreignKey, $entity) {
        $model = new $modelClass($this->database);
        $sql = "SELECT * FROM {$model->getTable()} WHERE {$foreignKey} = ?";
        $result = $this->query($sql, [$entity->id], $modelClass);
        return $result ? $result[0] : null;
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
