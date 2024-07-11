<?php
// src/App/Model/DebtModel.php

namespace App\Model;

use App\Entity\DebtEntity;

class DebtModel extends Model {
    protected $table = 'dettes';

    public function show() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->query($sql);

        $dettes = [];
        foreach ($result as $row) {
            $debtEntity = new DebtEntity();
            foreach ($row as $key => $value) {
                $debtEntity->$key = $value; // Utilisation de __set
            }
            $dettes[] = $debtEntity;
        }

        return $dettes;
    }

    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (id_client, montant, montant_verser, date_dette) VALUES (:id_client, :montant, :montant_verser, :date_dette)";
        $this->query($sql, $data);
    }

    public function update($id, array $data) {
        parent::update($id, $data);
    }

    public function delete($id) {
        parent::delete($id);
    }
}
