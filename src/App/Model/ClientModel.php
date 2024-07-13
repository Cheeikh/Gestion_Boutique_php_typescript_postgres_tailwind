<?php
// src/App/Model/ClientModel.php

namespace App\Model;

use App\Entity\ClientEntity;

class ClientModel extends Model {
    protected $table = 'clients';

    public function create(array $data) {
        return $this->save($data);
    }

    public function findClientByPhoneNumber($phone) {
        $sql = "SELECT c.utilisateur_id, c.id, u.nom, u.prenom, u.email, u.photo, u.telephone 
                FROM {$this->table} c 
                JOIN utilisateurs u ON c.utilisateur_id = u.id 
                WHERE u.telephone = ? AND u.role_id = 3";
        return $this->query($sql, [$phone], ClientEntity::class);
    }

    public function findClientDette($id) {
        $sql = "SELECT SUM(montant) as montant, SUM(montant_verser) as montant_verser FROM dettes WHERE id_client = ?";
        return $this->query($sql, [$id]);
    }
}
