<?php

namespace App\Model;

use App\Database\MysqlDatabase;
use App\Entity\produitEntity;
class ProduitsModel extends Model {
    protected $table = 'produits';

    public function __construct(MysqlDatabase $db) {
        parent::__construct($db);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], produitEntity::class);
    }
}
