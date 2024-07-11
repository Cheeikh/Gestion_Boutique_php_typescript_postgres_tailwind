<?php
// src/App/Entity/ClientEntity.php
namespace App\Entity;

class ClientEntity extends Entity {
    protected $id;
    protected $utilisateur_id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $telephone;
    protected $photo;
    protected $created_at;
}