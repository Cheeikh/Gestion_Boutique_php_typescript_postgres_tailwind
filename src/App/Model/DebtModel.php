<?php
// src/App/Model/DebtModel.php

namespace App\Model;

use App\Entity\DebtEntity;

class DebtModel extends Model {
    protected $table = 'dettes';


    public function findDebtDetailsWithProducts($detteId) {
        $sql = "SELECT d.*, pd.nom AS nom_produit, pd.prix AS prix_produit, pd.quantite AS qte_produit, 
                       pd.prix * pd.quantite AS montant_produit
                FROM {$this->table} d
                LEFT JOIN produitDette pd ON d.id = pd.id_dette
                WHERE d.id = ?";
        
        $result = $this->query($sql, [$detteId]);
        
        $detteDetails = [];
        foreach ($result as $row) {
            if (empty($detteDetails['dette'])) {
                $detteDetails['dette'] = $this->createEntityFromRow(array_intersect_key($row, array_flip(['id', 'montant', 'etat', 'date', 'id_client', 'montant_verser', 'created_at'])));
            }
            if ($row['nom_produit']) {
                $detteDetails['produits'][] = [
                    'nom' => $row['nom_produit'],
                    'prix' => $row['prix_produit'],
                    'qte' => $row['qte_produit'],
                    'montant' => $row['montant_produit']
                ];
            }
        }
        
        return $detteDetails;
    }
    

    public function findClientDette($clientId) {
        $sql = "SELECT * FROM {$this->table} WHERE id_client = ? ORDER BY date DESC"; // Ajout du tri par date en ordre décroissant
        $result = $this->query($sql, [$clientId]);
        
        $dettes = [];
        $totalMontantImpaye = 0;
        $totalMontantVerse = 0;
    
        foreach ($result as $row) {
            $debtEntity = $this->createEntityFromRow($row);
            $dettes[] = $debtEntity;
            $totalMontantImpaye += $debtEntity->montant;
            $totalMontantVerse += $debtEntity->montant_verser;
        }
        
        return [
            'dettes' => $dettes,
            'total_dette_impaye' => $totalMontantImpaye,
            'total_montant_verse' => $totalMontantVerse,
        ];
    }
    
    public function show() {
        echo "Hello from DebtModel";
    }
    
    private function createEntityFromRow(array $row): DebtEntity {
        $debtEntity = new DebtEntity();
        foreach ($row as $key => $value) {
            $debtEntity->$key = $value;
        }
        return $debtEntity;
    }
    
    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (id_client, montant, montant_verser, date) VALUES (:id_client, :montant, :montant_verser, :date)";
        return $this->query($sql, $data);
    }

    public function update($id, array $data) {
        return parent::update($id, $data);
    }

    public function delete($id) {
        return parent::delete($id);
    }

    public function createDetteWithProducts(array $detteData, array $produits) {
        return $this->transaction(function($model) use ($detteData, $produits) {
            // Vérifier les quantités disponibles avant l'insertion
            foreach ($produits as $produit) {
                $stockActuel = $model->database->query("SELECT quantite FROM produits WHERE id = ?", [$produit->id])[0]['quantite'];
                if ($stockActuel < $produit->quantite) {
                    throw new \Exception("La quantité demandée pour le produit '{$produit->nom}' dépasse le stock disponible.");
                }
            }
    
            // Insérer la dette
            $dette_id = $model->save($detteData);
    
            // Insérer les lignes de produit_dette et mettre à jour les quantités de produits
            foreach ($produits as $produit) {
                // Insérer dans produit_dette
                $produitDetteData = [
                    'id_dette' => $dette_id,
                    'id_produit' => $produit->id,
                    'nom' => $produit->nom,
                    'prix' => $produit->prix,
                    'quantite' => $produit->quantite
                ];
                $model->database->execute("INSERT INTO produitDette (id_dette, id_produit, nom, prix, quantite) VALUES (:id_dette, :id_produit, :nom, :prix, :quantite)", $produitDetteData);
    
                // Mettre à jour la quantité du produit
                $model->database->execute("UPDATE produits SET quantite = quantite - :quantite WHERE id = :id", [
                    'quantite' => $produit->quantite,
                    'id' => $produit->id
                ]);
            }
    
            return $dette_id;
        });
    }

    public function findDette($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->query($sql, [$id]);
        
        if (empty($result)) {
            return null; // Retourne null si aucune dette n'est trouvée
        }
        
        // Crée et retourne un objet DebtEntity
        return $this->createEntityFromRow($result[0]);
    }

    public function getPaiements(DebtEntity $dette) {
        return $this->hasMany(PaiementModel::class, 'id_dette', $dette);
    }
}
