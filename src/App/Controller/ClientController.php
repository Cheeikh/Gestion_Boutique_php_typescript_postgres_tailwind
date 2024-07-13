<?php
// src/App/Controller/ClientController.php

namespace App\Controller;

use App\Model\ClientModel;
use App\Model\UtilisateurModel;
use App\Model\DebtModel;
use App\Authorize\Authorize;
use App\Files\FileHandler;
use App\Session\Session;

class ClientController extends Controller {
    private $clientModel;
    private $utilisateurModel;
    private $debtModel;

    public function __construct(Authorize $authorize, FileHandler $fileHandler, ClientModel $clientModel, UtilisateurModel $utilisateurModel, DebtModel $debtModel, Session $session, $isApi = false) {
        parent::__construct($authorize, $fileHandler, $session, $isApi);
        $this->clientModel = $clientModel;
        $this->utilisateurModel = $utilisateurModel;
        $this->debtModel = $debtModel;
    }

    public function index() {
        $errors = $this->session::get('errors');
        $this->session::set('errors', null);
        
        $client = $this->session::get('client');
        $this->session::set('client', null);
        
        $dettes = $this->session::get('dettes');
        $this->session::set('dettes', null);
        
        $this->render('Client/clients', [
            'errors' => $errors,
            'client' => $client,
            'dettes' => $dettes
        ]);
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

            // Si des erreurs sont présentes, les stocker dans la session et rediriger
            if (!empty($errors)) {
                $this->session::set('errors', $errors);
                $this->redirect('/clients');
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

            // Stocker un message de succès dans la session
            $this->session::set('success_message', 'Le client a été créé avec succès.');

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
                
                $this->storeClientDataInSession($client, $dettesData);
            } else {
                $this->session::set('error_message', 'Aucun client trouvé avec ce numéro de téléphone.');
            }
        }
        
        $this->displayClientData();
    }
    
    private function storeClientDataInSession($client, $dettesData) {
        $this->session::set('client', $client);
        $this->session::set('dettes', [
            'dettes' => $dettesData['dettes'],
            'totalMontantImpaye' => $dettesData['total_dette_impaye'],
            'totalMontantVerse' => $dettesData['total_montant_verse']
        ]);
    }
    
    private function displayClientData() {
        $client = $this->session::get('client');
        $dettes = $this->session::get('dettes');
        
        if ($client && $dettes) {
            $this->render('Client/clients', [
                'client' => $client,
                'dettes' => $dettes['dettes'],
                'totalMontantImpaye' => $dettes['totalMontantImpaye'],
                'totalMontantVerse' => $dettes['totalMontantVerse']
            ]);
        } else {
            $this->render('Client/clients');
        }
        
        // Clear the session data after rendering
        $this->session::set('client', null);
        $this->session::set('dettes', null);
    }
    
}
