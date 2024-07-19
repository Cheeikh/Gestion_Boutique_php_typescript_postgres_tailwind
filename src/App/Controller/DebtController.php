<?php

namespace App\Controller;

use App\Model\DebtModel;
use App\Model\ClientModel;
use App\Model\UtilisateurModel;
use App\Model\ProduitsModel;
use App\Authorize\Authorize;
use App\Files\FileHandler;
use App\Session\Session;
use App\Model\PaiementModel;


class DebtController extends Controller
{

    private $clientModel;
    private $debtModel;
    private $produitsModel;
    private $utilisateurModel;
    private $paiementModel;

    public function __construct(Authorize $authorize, FileHandler $fileHandler, DebtModel $debtModel, Session $session, ClientModel $clientModel, ProduitsModel $produitsModel, UtilisateurModel $utilisateurModel, PaiementModel $paiementModel, $isApi = false)
    {
        parent::__construct($authorize, $fileHandler, $session, $isApi);
        $this->debtModel = $debtModel;
        $this->clientModel = $clientModel;
        $this->produitsModel = $produitsModel;
        $this->utilisateurModel = $utilisateurModel;
        $this->paiementModel = $paiementModel;
    }

    public function create()
    {
        $client = $this->session::get('client') ?? null;
        $produits = $this->session::get('produits') ?? [];
        $total_dette = array_sum(array_column($produits, 'montant'));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['searchNumber'])) {
                $client = $this->clientModel->findClientByPhoneNumber($_POST['searchNumber']);
                if ($client) {
                    $client = $client[0];
                    $this->session::set('client', $client);
                } else {
                    $this->session::setFlash('error', 'Aucun client trouvé avec ce numéro de téléphone.');
                }
            }

            if (!empty($_POST['ref_produit']) && isset($_POST['quantite'])) {
                $produit = $this->produitsModel->find($_POST['ref_produit']);
                if ($produit) {
                    $produit = $produit[0];
                    $quantite = (int)$_POST['quantite'];
                    $prix = (float)$produit->prix;

                    if ($quantite <= 0) {
                        $this->session::setFlash('error', 'La quantité doit être supérieure à zéro.');
                    } elseif ($quantite > $produit->quantite) {
                        $this->session::setFlash('error', "La quantité demandée pour le produit '{$produit->nom}' dépasse le stock disponible.");
                    } else {
                        $produitExistant = null;
                        foreach ($produits as &$p) {
                            if ($p->id == $produit->id) {
                                $produitExistant = &$p;
                                break;
                            }
                        }

                        if ($produitExistant) {
                            $nouvelleQuantite = $produitExistant->quantite + $quantite;
                            if ($nouvelleQuantite > $produit->quantite) {
                                $this->session::setFlash('error', "La quantité totale demandée pour le produit '{$produit->nom}' dépasse le stock disponible.");
                            } else {
                                $produitExistant->quantite = $nouvelleQuantite;
                                $produitExistant->montant = $nouvelleQuantite * $prix;
                                $this->session::setFlash('success', 'Quantité mise à jour avec succès.');
                            }
                        } else {
                            $nouveauProduit = clone $produit;
                            $nouveauProduit->quantite = $quantite;
                            $nouveauProduit->montant = $quantite * $prix;
                            $produits[] = $nouveauProduit;
                            $this->session::setFlash('success', 'Produit ajouté avec succès.');
                        }

                        $this->session::set('produits', $produits);
                    }
                } else {
                    $this->session::setFlash('error', 'Produit non trouvé.');
                }
            }

            // Traitement de l'enregistrement de la dette
            if (isset($_POST['enregistrer_dette'])) {
                if (!$client) {
                    $this->session::setFlash('error', 'Veuillez sélectionner un client avant d\'enregistrer la dette.');
                } elseif (empty($produits)) {
                    $this->session::setFlash('error', 'Veuillez ajouter au moins un produit à la dette.');
                } else {
                    $total_dette = array_sum(array_column($produits, 'montant'));
                    $data = [
                        'id_client' => $client->id,
                        'montant' => $total_dette,
                        'montant_verser' => 0, // Montant initial versé
                        'date' => date('Y-m-d H:i:s')
                    ];

                    try {
                        $dette_id = $this->debtModel->createDetteWithProducts($data, $produits);
                        if ($dette_id) {
                            $this->session::remove('client');
                            $this->session::remove('produits');
                            $this->session::setFlash('success', 'La dette a été enregistrée avec succès.');
                            $this->redirect('/dettes');
                        }
                    } catch (\Exception $e) {
                        $this->session::setFlash('error', 'Une erreur est survenue lors de l\'enregistrement de la dette: ' . $e->getMessage());
                    }
                }
            }
        }



        // Calculer le total de la dette
        $total_dette = array_sum(array_column($produits, 'montant'));
        $this->render('Debt/add', [
            'client' => $client,
            'produits' => $produits,
            'total_dette' => $total_dette,
        ]);
    }

    public function list($id)
    {
        $clientModel = $this->clientModel->find($id);
        $client = $this->utilisateurModel->find($clientModel['utilisateur_id']);
        $dettes = $this->debtModel->findClientDette($id);

        // Filtrer les dettes par défaut (impayées)
        $etatFiltre = $_GET['etat'] ?? 'impaye';
        $dettesFiltrees = array_filter($dettes['dettes'], function ($dette) use ($etatFiltre) {
            return $dette->etat === $etatFiltre;
        });

        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 5;
        $totalDettes = count($dettesFiltrees);
        $totalPages = ceil($totalDettes / $perPage);
        $start = ($page - 1) * $perPage;
        $dettesPage = array_slice($dettesFiltrees, $start, $perPage);

        $this->render('Debt/list', [
            'client' => $client,
            'dettes' => [
                'dettes' => $dettesPage,
                'total_dette_impaye' => $dettes['total_dette_impaye'],
                'total_montant_verse' => $dettes['total_montant_verse']
            ],
            'etatFiltre' => $etatFiltre,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }


    public function Paiements($id)
    {
        $dette = $this->debtModel->findDette($id);

        if (!$dette) {
            // Gérer le cas où la dette n'existe pas
            return;
        }

        $paiements = $this->paiementModel->findBy('id_dette', $id);



        $this->render('Paiement/list', [
            'dette' => $dette,
            'paiements' => $paiements
        ]);
    }

    public function AddPaiement($id)
    {
        $dette = $this->debtModel->findDette($id);

        if (!$dette) {
            // Gérer le cas où la dette n'existe pas
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_dette' => $id,
                'montant' => $_POST['montant'],
            ];
            $paiements = $this->paiementModel->findBy('id_dette', $id);
            $this->paiementModel->create($data);
            $this->render('Paiement/list', [
                'dette' => $dette,
                'paiements' => $paiements
            ]);
        }

        $this->render('Paiement/add', [
            'dette' => $dette
        ]);
    }

    public function removeProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_index'])) {
            $produits = $this->session::get('produits') ?? [];
            $index = (int)$_POST['product_index'];



            if (isset($produits[$index])) {
                unset($produits[$index]);
                $produits = array_values($produits); // Réindexer le tableau
                $this->session::set('produits', $produits);
                $this->session::setFlash('success', 'Produit supprimé avec succès.');
            } else {
                $this->session::setFlash('error', 'Produit non trouvé.');
            }
        }

        $client = $this->session::get('client') ?? null;
        // Calculer le total de la dette
        $total_dette = array_sum(array_column($produits, 'montant'));
        $this->render('Debt/add', [
            'client' => $client,
            'produits' => $produits,
            'total_dette' => $total_dette,
        ]);
    }

    public function details($id) {
        $details = $this->debtModel->findDebtDetailsWithProducts($id);
        $debt = $details['dette'];
        $products = $details['produits'];
    
        ob_start();
        ?>
        <h2>Détails de la dette</h2>
        <p>Montant : <?= $debt->montant ?> Franc CFA</p>
        <p>Montant restant : <?= number_format(floatval($debt->montant) - floatval($debt->montant_verser), 2) ?> Franc CFA</p>
        <p>Date : <?= $debt->date ?></p>
        <h3>Produits</h3>
        <ul>
            <?php foreach ($products as $product) : ?>
                <li><?= $product['nom'] ?> - <?= $product['prix'] ?> Franc CFA - <?= $product['qte'] ?> unités - <?= $product['montant'] ?> Franc CFA</li>
            <?php endforeach; ?>
        </ul>
        <?php
        $content = ob_get_clean();
        
        echo $content;
        exit;
    }
    
    public function clearCart()
    {
        $this->session::remove('produits');
        
        if ($this->isAjaxRequest()) {
            echo json_encode(['success' => true]);
            exit;
        }
        
        $this->session::setFlash('success', 'Le panier a été vidé avec succès.');
        $this->redirect('/debt/create');
    }
    
    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
}
