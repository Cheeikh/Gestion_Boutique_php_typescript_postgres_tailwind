<?php
// src/Models/Product.php
class Product {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM produit WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($libelle, $prix, $stock) {
        $sql = "INSERT INTO produit (libelle, prix, stock) VALUES (:libelle, :prix, :stock)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':stock', $stock);
        return $stmt->execute();
    }

    // Ajoutez d'autres méthodes nécessaires
}
?>
