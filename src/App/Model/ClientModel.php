<?php
// src/App/Model/ClientModel.php

namespace App\Model;

class ClientModel extends Model {
    protected $table = 'clients';

    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (utilisateur_id) VALUES (:utilisateur_id)";
        return $this->query($sql, $data);
    }

    public function findClientByPhoneNumber($phone) {
        $sql = "SELECT c.utilisateur_id, c.id, u.nom, u.prenom, u.email, u.photo, u.telephone 
                FROM {$this->table} c 
                JOIN utilisateurs u ON c.utilisateur_id = u.id 
                WHERE u.telephone = ? AND u.role_id = 3";
        return $this->query($sql, [$phone]);
    }

    public function findClientDette($id) {
        $sql = "SELECT SUM(montant) as montant, SUM(montant_verser) as montant_verser FROM dettes WHERE id_client = ?";
        return $this->query($sql, [$id]);
    }
}
