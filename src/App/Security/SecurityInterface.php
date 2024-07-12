<?php
// src/App/Security/SecurityInterface.php

namespace App\Security;

interface SecurityInterface {
    public function login(string $email, string $password): bool;
    public function isLogged(): bool;
    public function getRoles(): array;
    public function getUserLogged();
    public function logout(): void;
}
