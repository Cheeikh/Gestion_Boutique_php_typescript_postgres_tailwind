<?php
// src/App/Model/DebtModel.php

namespace App\Model;

use App\Entity\PaiementEntity;

class PaiementModel extends Model {
    protected $table = 'paiements';

    public function list($id) {
      
    }

    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (id_dette, montant) VALUES (:id_dette, :montant)";
        return $this->query($sql, $data);
    }
}