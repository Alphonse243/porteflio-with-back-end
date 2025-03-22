<?php
namespace Models;

use Core\Database;
use Core\Model;

class User extends Model
{
    public function authenticate($email, $password)
    {
        $hashedPassword = sha1($password);
        
        $stmt = $this->db->prepare('SELECT id, username, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && $user['password'] === $hashedPassword) {
            return $user;
        }
        
        return false;
    }

    public function emailExists($email): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return (bool) $stmt->fetchColumn();
    }

    public function register($username, $email, $password)
    {
        $hashedPassword = sha1($password);
        
        $stmt = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $hashedPassword]);
        
        return $this->db->lastInsertId();
    }
}
