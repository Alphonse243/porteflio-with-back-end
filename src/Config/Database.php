<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            try {
                $host = 'localhost';
                $dbname = 'tutolabpro';
                $username = 'root';
                $password = '';
                $charset = 'utf8mb4';

                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                self::$instance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                throw new PDOException('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
