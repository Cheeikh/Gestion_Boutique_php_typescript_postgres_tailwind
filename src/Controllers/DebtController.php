<?php
// src/Controllers/DebtController.php

require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Debt.php');

class DebtController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function index() {
        try {
            $debt = new Debt($this->conn);
            $debts = $debt->readRecentDebts(); // Modification ici si nécessaire

            // Exemple de récupération de débiteurs (à ajuster selon votre logique)
            $debtors = $debt->fetchDebtors(); // Supposons que cette méthode récupère les débiteurs

            // Vérification si $debts et $debtors sont définis et non null avant de passer à la vue
            if ($debts !== null && $debtors !== null) {
                require_once(__DIR__ . '/../Views/debt/index.php');
            } else {
                // Gestion de l'erreur si $debts ou $debtors est null
                echo "Erreur lors de la récupération des données de dettes ou des débiteurs.";
            }
        } catch (Exception $e) {
            // Gestion des exceptions PDO
            echo "Erreur PDO : " . $e->getMessage();
        }
    }
}
?>
