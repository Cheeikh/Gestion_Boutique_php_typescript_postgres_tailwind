<?php
// src/App/Controller/Controller.php

namespace App\Controller;

use App\Authorize\Authorize;
use App\Files\FileHandler;
use App\Session\Session;

abstract class Controller implements ControllerInterface {
    protected $authorize;
    protected $fileHandler;
    protected $session;
    protected $isApi = false;

    use ViewTrait;
    use ValidationTrait;
    use RedirectTrait;

    public function __construct(Authorize $authorize, FileHandler $fileHandler, Session $session, $isApi = false) {
        $this->isApi = $isApi;
        $this->authorize = $authorize;
        $this->fileHandler = $fileHandler;
        $this->session = $session;
    }

    // Ajout des nouvelles méthodes de gestion des fichiers et de l'utilisateur
    protected function uploadFile(array $file, string $directory): string {
        return $this->fileHandler->upload($file, $directory);
    }

    protected function saveUser($user): void {
        $this->authorize->saveUser($user);
    }

    protected function getUserLogged() {
        return $this->authorize->getUserLogged();
    }

    protected function isLogged(): bool {
        return $this->authorize->isLogged();
    }

    protected function hasRole(string $role): bool {
        return $this->authorize->hasRole($role);
    }

    protected function setSessionValue(string $key, $value): void {
        $this->session::set($key, $value);
    }

    protected function getSessionValue(string $key) {
        return $this->session::get($key);
    }

    protected function issetSessionValue(string $key): bool {
        return $this->session::isset($key);
    }
}
