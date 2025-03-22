<?php
namespace App\Model;

use App\Config\Database;
use PDO;

class Project {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getPaginated($page, $perPage) {
        $offset = ($page - 1) * $perPage;
        
        $stmt = $this->pdo->prepare("SELECT * FROM projects ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotal() {
        return $this->pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    }
}
