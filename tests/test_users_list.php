<?php
// Inclure le fichier bootstrap pour charger les dépendances et initialiser l'autoloader
require_once __DIR__ . '/../src/bootstrap.php';

use App\Models\User; // Assurez-vous que le chemin et le nom de classe sont corrects ici

// Créer une instance du modèle User
$userModel = new User();

// Récupérer la liste des utilisateurs
$users = $userModel->getAllUsers();

// Afficher les utilisateurs
echo "Liste des Utilisateurs :\n";
foreach ($users as $user) {
    echo "- {$user['nom']} {$user['prenom']} ({$user['username']})\n";
}
?>
