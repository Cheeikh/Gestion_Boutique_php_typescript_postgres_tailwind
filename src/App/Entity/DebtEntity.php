<?php
// src/App/Entity/DebtEntity.php

namespace App\Entity;

class DebtEntity extends Entity {
    private $id;
    private $montant;
    private $etat;
    private $date;
    private $id_client;
    private $montant_verser;
    private $created_at;
}
