<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private $connection = null;

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    "mysql:host=" . constant('DB_HOST') . ";dbname=" . constant('DB_NAME'),
                    constant('DB_USER'),
                    constant('DB_PASS'),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        
        return $this->connection;
    }
}
