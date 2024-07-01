<?php
class Debt {
    private $conn;
    private $table = 'dette';

    public $id;
    public $montant;
    public $date;
    public $etat;
    public $id_client;
    public $client_nom;
    public $client_prenom;
    public $vendeur_nom;
    public $vendeur_prenom;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readRecentDebts() {
        $query = 'SELECT d.*, u_client.nom AS client_nom, u_client.prenom AS client_prenom, u_vendeur.nom AS vendeur_nom, u_vendeur.prenom AS vendeur_prenom 
                  FROM ' . $this->table . ' d 
                  JOIN client c ON d.id_client = c.id
                  JOIN utilisateurs u_client ON c.id = u_client.id
                  LEFT JOIN vendeur v ON d.id_vendeur = v.id
                  LEFT JOIN utilisateurs u_vendeur ON v.id = u_vendeur.id
                  ORDER BY d.date DESC
                  LIMIT 5';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }

    public function fetchDebtors() {
        $query = 'SELECT u.nom AS client_nom, u.prenom AS client_prenom, d.montant
                  FROM dette d
                  JOIN client c ON d.id_client = c.id
                  JOIN utilisateurs u ON c.id = u.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }
    
    
}
?>
