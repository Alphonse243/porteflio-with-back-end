<?php
namespace Core;

abstract class Controller
{
    protected function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    protected function redirect(string $path)
    {
        header("Location: $path");
        exit;
    }

    protected function jsonResponse(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function getProfile()
    {
        return [
            'name' => 'Mon Portfolio' // À personnaliser selon vos besoins
        ];
    }

    protected function isDebugMode(): bool
    {
        return defined('DEBUG_MODE') && DEBUG_MODE === true;
    }
}
