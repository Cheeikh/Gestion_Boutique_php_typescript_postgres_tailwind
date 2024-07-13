<?php
// src/App/Controller/ClientController.php

namespace App\Controller;

use App\Model\ClientModel;
use App\Model\UtilisateurModel;
use App\Model\DebtModel;
use App\Authorize\Authorize;
use App\Files\FileHandler;

class ClientController extends Controller {
    private $clientModel;
    private $utilisateurModel;
    private $debtModel;

    public function __construct(Authorize $authorize, FileHandler $fileHandler, ClientModel $clientModel, UtilisateurModel $utilisateurModel, DebtModel $debtModel, $isApi = false) {
        parent::__construct($authorize, $fileHandler, $isApi);
        $this->clientModel = $clientModel;
        $this->utilisateurModel = $utilisateurModel;
        $this->debtModel = $debtModel;
    }

    public function index() {
        $this->render('Client/clients');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation des données
            $validationRules = [
                'nom' => [
                    'pattern' => '/^[a-zA-Z\s]+$/',
                    'message' => 'Le nom ne doit contenir que des lettres et des espaces.'
                ],
                'prenom' => [
                    'pattern' => '/^[a-zA-Z\s]+$/',
                    'message' => 'Le prénom ne doit contenir que des lettres et des espaces.'
                ],
                'email' => [
                    'pattern' => '/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                    'message' => 'L\'adresse e-mail n\'est pas valide.'
                ],
                'telephone' => [
                    'pattern' => '/^(77|78|70|76)\d{7}$/',
                    'message' => 'Le numéro de téléphone doit commencer par 77, 78, 70 ou 76 et être composé de 9 chiffres.'
                ]
            ];

            // Validation des champs du formulaire
            $errors = $this->validate($_POST, $validationRules);

            // Vérification d'unicité des données
            $existingUser = $this->utilisateurModel->findBy('email', $_POST['email']);
            if ($existingUser) {
                $errors['email'] = 'Fall e-mail bi amna ba paré.';
            }

            $existingUser = $this->utilisateurModel->findBy('telephone', $_POST['telephone']);
            if ($existingUser) {
                $errors['telephone'] = 'Looy dougeulaatéé numéro bi nii ?';
            }

            // Si des erreurs sont présentes, afficher le formulaire avec les erreurs
            if (!empty($errors)) {
                $this->render('Client/clients', ['errors' => $errors]);
                return;
            }

            // Si aucune erreur, procéder à la création du nouvel utilisateur et client
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            // Utilisation de la méthode de téléchargement de fichier factorisée
            $photo = 'naruto.jpg'; // Photo par défaut
            if (isset($_FILES['photo'])) {
                $photo = $this->uploadFile($_FILES['photo'], '/var/www/html/gestionboutique/public/upload/');
            }

            // Créer un nouvel utilisateur
            $utilisateurId = $this->utilisateurModel->create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'telephone' => $telephone,
                'role_id' => 3,
                'photo' => $photo
            ]);

            // Créer un nouveau client associé à cet utilisateur
            $this->clientModel->create([
                'utilisateur_id' => $utilisateurId
            ]);

            // Redirection vers la liste des clients après la création
            $this->redirect('/clients');
        } else {
            $this->redirect('/clients');
        }
    }

    public function show() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchNumber'])) {
            $clients = $this->clientModel->findClientByPhoneNumber($_POST['searchNumber']);
            if (!empty($clients)) {
                $client = $clients[0];  // Nous supposons qu'il y a un seul résultat
                $id_client = $client->id;
                $dettesData = $this->debtModel->findClientDette($id_client);
                $dettes = $dettesData['dettes'];  // Récupération des objets DebtEntity
                $totalMontantImpaye = $dettesData['total_dette_impaye'];  // Total des montants impayés
                $totalMontantVerse = $dettesData['total_montant_verse'];  // Total des montants versés
    
                $this->render('Client/clients', [
                    'client' => $client, 
                    'dettes' => $dettes,
                    'totalMontantImpaye' => $totalMontantImpaye,
                    'totalMontantVerse' => $totalMontantVerse
                ]);
            } else {
                $this->redirect('/clients');
            }
        }
    }
    
}
