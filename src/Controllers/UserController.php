<?php
require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/User.php';

class UserController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $stmt = $user->read();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/user/index.php';
    }

    public function debtors() {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $stmt = $user->readDebtors();
        $debtors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/user/debtors.php';
    }
}
