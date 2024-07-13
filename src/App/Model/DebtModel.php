<?php
// src/App/Model/DebtModel.php

namespace App\Model;

use App\Entity\DebtEntity;

class DebtModel extends Model {
    protected $table = 'dettes';

    
    public function findClientDette($clientId) {
        // Requête pour récupérer les dettes impayées
        $sql = "SELECT * FROM {$this->table} WHERE id_client = ? AND etat = 'impaye'";
        $result = $this->query($sql, [$clientId]);
        
        $dettes = [];
        $totalMontantImpaye = 0;
        $totalMontantVerse = 0;
    
        foreach ($result as $row) {
            $debtEntity = new DebtEntity();
            foreach ($row as $key => $value) {
                $debtEntity->$key = $value; // Utilisation de __set
            }
            
            $dettes[] = $debtEntity;
            $totalMontantImpaye += $debtEntity->montant; // Somme des montants impayés
            $totalMontantVerse += $debtEntity->montant_verser; // Somme des montants versés
        }
        
        return [
            'dettes' => $dettes,
            'total_dette_impaye' => $totalMontantImpaye,
            'total_montant_verse' => $totalMontantVerse,
        ];
    }
    
    public function show() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->query($sql);

        $dettes = [];
        foreach ($result as $row) {
            $debtEntity = new DebtEntity();
            foreach ($row as $key => $value) {
                $debtEntity->$key = $value; // Utilisation de __set
            }
            $dettes[] = $debtEntity;
        }

        return $dettes;
    }
    
    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (id_client, montant, montant_verser, date_dette) VALUES (:id_client, :montant, :montant_verser, :date_dette)";
        $this->query($sql, $data);
    }

    public function update($id, array $data) {
        parent::update($id, $data);
    }

    public function delete($id) {
        parent::delete($id);
    }
}
