<?php
// src/App/Security/SecurityDatabase.php

namespace App\Security;

use App\Database\MysqlDatabase;
use App\Model\UtilisateurModel;
use App\Session\Session;
use App\Authorize\Authorize;
use App\Files\FileHandler;


class SecurityDatabase implements SecurityInterface {
    private $database;
    private $utilisateurModel;
    private $authorize;
    private $fileHandler;
    private $session;

    public function __construct(MysqlDatabase $database, Authorize $authorize, FileHandler $fileHandler, Session $session)
    {
        $this->database = $database;
        $this->utilisateurModel = new UtilisateurModel($database);
        $this->authorize = $authorize;
        $this->fileHandler = $fileHandler;
        $this->session = $session;
    }





 

    public function login(string $email, string $password): bool {
        $user = $this->utilisateurModel->findBy('email', $email);
        
        if ($password == $user[0]['password']) {
            
            Session::set('user_id', $user[0]['id']);
            Session::set('user_role', $user[0]['role_id']);
            return true;
        }
        return false;
    }

    public function isLogged(): bool {
        return Session::isset('user_id');
    }

    public function getRoles(): array {
        if ($this->isLogged()) {
            $user = $this->getUserLogged();
            switch ($user['role_id']) {
                case 1:
                    return ['ROLE_ADMIN'];
                case 2:
                    return ['ROLE_SELLER'];
                case 3:
                    return ['ROLE_CLIENT'];
            }
        }
        return ['ROLE_ANONYMOUS'];
    }

    public function getUserLogged() {
        if ($this->isLogged()) {
            $userId = Session::get('user_id');
            $user = $this->utilisateurModel->find($userId);
            return $user[0] ?? null;
        }
        return null;
    }

    public function logout(): void {
        Session::close();
    }

    public function getAuthorize()
    {
        return $this->authorize;
    }

    public function getFileHandler()
    {
        return $this->fileHandler;
    }

    public function getSession()
    {
        return $this->session;
    }
}
