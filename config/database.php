<?php
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

    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Tester la connexion
    $pdo->query('SELECT 1');
    
    return $pdo;

} catch (PDOException $e) {
    error_log('Database Connection Error: ' . $e->getMessage());
    throw new PDOException('Database connection failed: ' . $e->getMessage());
}
