<?php
// src/App/Model/UtilisateurModel.php

namespace App\Model;

class UtilisateurModel extends Model {
    protected $table = 'utilisateurs';

    // Méthode pour créer un utilisateur
    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (nom, prenom, email, password, telephone, role_id, photo) 
                VALUES (:nom, :prenom, :email, :password, :telephone, :role_id, :photo)";
        return $this->query($sql, $data);
    }

    // Méthode pour rechercher un utilisateur par un champ spécifique
    public function findBy($field, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ?";
        return $this->query($sql, [$value]);
    }
}
