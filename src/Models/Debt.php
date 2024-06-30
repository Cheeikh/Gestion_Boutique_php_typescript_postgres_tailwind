<?php
// src/Models/Debt.php

class Debt {
    private $conn;
    private $table = 'dette';

    public $id;
    public $id_client;
    public $montant;
    public $date;
    public $etat;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table . " WHERE etat = 'impaye'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (id_client, montant, date, etat) VALUES (:id_client, :montant, :date, :etat)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_client', $this->id_client);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':etat', $this->etat);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
?>
