<?php
class User {
    private $conn;
    private $table_name = 'utilisateurs';

    public $id;
    public $nom;
    public $prenom;
    public $username;
    public $password;
    public $role_id;
    public $statut;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readClients() {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE role_id = 4';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readDebtors() {
        $query = 'SELECT u.*, SUM(d.montant - d.montant_verse) AS total_du FROM utilisateurs u INNER JOIN dette d ON u.id = d.client_id WHERE d.etat = :etat GROUP BY u.id HAVING total_du > 0';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':etat', $this->etat);

        $this->etat = 'impaye';

        $stmt->execute();
        return $stmt;
    }
}
