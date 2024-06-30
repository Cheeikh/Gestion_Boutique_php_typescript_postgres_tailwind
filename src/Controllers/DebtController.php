<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Debt.php');

class DebtController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function index() {
        $debt = new Debt($this->conn);
        $result = $debt->read();
    
        require_once(__DIR__ . '/../Views/debt/index.php');
    }
    

    public function store() {
        $debt = new Debt($this->conn);

        $debt->id_client = $_POST['id_client'];
        $debt->montant = $_POST['montant'];
        $debt->date = date('Y-m-d H:i:s');
        $debt->etat = 'impaye';

        if ($debt->create()) {
            header("Location: /debts");
        } else {
            echo "Erreur lors de l'enregistrement de la dette.";
        }
    }
}
?>
