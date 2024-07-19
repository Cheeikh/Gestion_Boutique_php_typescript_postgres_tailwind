<?php
// src/App/Controller/LoginController.php

namespace App\Controller;

use App\Security\SecurityDatabase;

class LoginController extends Controller
{
    private $security;

    public function __construct(SecurityDatabase $security)
    {
        $this->security = $security;
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            if ($this->security->login($email, $password)) {
                if ($remember) {
                    // Implémentez la logique pour "Se souvenir de moi" si nécessaire
                }
                $role = $this->security->getRoles();
                var_dump($role);
                die();

                $this->redirect('/clients'); // Redirigez vers le tableau de bord après connexion
            } else {
                $error = "Email ou mot de passe incorrect";
                $this->render('Login/connexion', ['error' => $error]);
            }
        }
    }

    public function logout()
    {
        $this->security->logout();
        $this->redirect('/login');
    }
}