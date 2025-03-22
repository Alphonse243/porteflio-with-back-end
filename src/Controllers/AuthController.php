<?php
namespace Controllers;

use Models\User;
use Core\Controller;
use Core\View;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->processLogin();
        }

        return View::render('auth/login', [
            'error' => '',
            'profile' => $this->getProfile()
        ]);
    }

    private function processLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $response = ['success' => false, 'error' => '', 'redirect' => ''];

        if (empty($email) || empty($password)) {
            $response['error'] = 'Veuillez remplir tous les champs';
            return $this->jsonResponse($response);
        }

        try {
            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                $response['success'] = true;
                $response['redirect'] = $_GET['redirect'] ?? 'index.php';
            } else {
                $response['error'] = 'Email ou mot de passe incorrect';
            }
        } catch (\Exception $e) {
            $response['error'] = $this->isDebugMode() ? 
                'Erreur : ' . $e->getMessage() : 
                'Une erreur est survenue';
        }

        return $this->jsonResponse($response);
    }

    public function register()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->processRegister();
        }

        return View::render('auth/register', [
            'error' => '',
            'profile' => $this->getProfile()
        ]);
    }

    private function processRegister()
    {
        $response = ['success' => false, 'error' => '', 'redirect' => ''];
        
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $response['error'] = 'Veuillez remplir tous les champs';
            return $this->jsonResponse($response);
        }

        if ($password !== $confirmPassword) {
            $response['error'] = 'Les mots de passe ne correspondent pas';
            return $this->jsonResponse($response);
        }

        try {
            if ($this->userModel->emailExists($email)) {
                $response['error'] = 'Cet email est déjà utilisé';
                return $this->jsonResponse($response);
            }

            $userId = $this->userModel->register($username, $email, $password);
            if ($userId) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;
                
                $response['success'] = true;
                $response['redirect'] = 'index.php';
            }
        } catch (\Exception $e) {
            $response['error'] = $this->isDebugMode() ? 
                'Erreur : ' . $e->getMessage() : 
                'Une erreur est survenue';
        }

        return $this->jsonResponse($response);
    }
}
