<?php

namespace App\Controller;

use App\Model\ClientModel;
use App\Model\UtilisateurModel;

class ClientController extends Controller {
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
            $utilisateurModel = new UtilisateurModel($this->app->getDatabase());
            
          

            // Vérifier l'unicité de l'email
            $existingUser = $utilisateurModel->findBy('email', $_POST['email']);
            if ($existingUser) {
                $errors['email'] = 'Cet e-mail existe déjà.';
            }

            // Vérifier l'unicité du téléphone
            $existingUser = $utilisateurModel->findBy('telephone', $_POST['telephone']);
            if ($existingUser) {
                $errors['telephone'] = 'Ce numéro de téléphone existe déjà.';
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

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
             
                // Créer le dossier de téléchargement s'il n'existe pas
                $uploadFileDir = '/var/www/html/gestionboutique/public/upload/';
            
                
                // Gérer les caractères spéciaux dans le nom du fichier
                $fileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $fileName);
                
                // Définir le chemin de destination
                $dest_path = $uploadFileDir . $fileName;
            
            
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $photo = $fileName; // Enregistrer uniquement le nom du fichier
                } else {
                    // Gérer l'erreur
                    $photo = 'naruto.jpg'; // Photo par défaut si le téléchargement échoue
                }
            } else {
                $photo = 'naruto.jpg'; // Photo par défaut si aucun fichier n'est téléchargé
            }

            // Créer un nouvel utilisateur
            $utilisateurId = $utilisateurModel->create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'telephone' => $telephone,
                'role_id' => 3,
                'photo' => $photo
            ]);

            // Créer un nouveau client associé à cet utilisateur
            $clientModel = new ClientModel($this->app->getDatabase());
            $clientModel->create([
                'utilisateur_id' => $utilisateurId
            ]);

            // Redirection vers la liste des clients après la création
            header('Location: /clients');
            exit();
        }
    }

    public function show() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchNumber'])) {
            $clientModel = new ClientModel($this->app->getDatabase());
            $client = $clientModel->findClientByPhoneNumber($_POST['searchNumber']);
            $id_client = $client[0]['id'];
            $dettes = $clientModel->findClientDette($id_client);

            if ($client) {
                $this->render('Client/clients', ['client' => $client[0], 'dettes' => $dettes]);
            } else {
                $this->render('Client/clients', ['error' => 'Client not found']);
            }
        }
    }
}
