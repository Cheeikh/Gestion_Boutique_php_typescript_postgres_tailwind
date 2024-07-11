<?php
// src/App/Security/SecurityDatabase.php

namespace App\Security;

use App\Database\MysqlDatabase;
use App\Model\UtilisateurModel;

class SecurityDatabase {
    private $database;
    private $utilisateurModel;

    public function __construct(MysqlDatabase $database) {
        $this->database = $database;
        $this->utilisateurModel = new UtilisateurModel($database);
    }

    public function login($email, $password) {
        $user = $this->utilisateurModel->findBy('email', $email);

        if (!empty($user) && password_verify($password, $user[0]['password'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['user_role'] = $user[0]['role_id'];
            return true;
        }

        return false;
    }

    public function isLogged(): bool {
        return isset($_SESSION['user_id']);
    }

    public function getRoles() {
        if ($this->isLogged()) {
            $user = $this->getUserLogged();
            $roleId = $user['role_id'];
            
      
            switch ($roleId) {
                case 1:
                    return ['ROLE_ADMIN'];
                case 2:
                    return ['ROLE_SELLER'];
                default:
                    return ['ROLE_CLIENT'];
            }
        }
        return ['ROLE_ANONYMOUS'];
    }

    public function getUserLogged() {
        if ($this->isLogged()) {
            $userId = $_SESSION['user_id'];
            $user = $this->utilisateurModel->find($userId);
            return $user[0] ?? null;
        }
        return null;
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        session_destroy();
    }
}