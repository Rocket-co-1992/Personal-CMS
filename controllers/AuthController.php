<?php
namespace Controllers;

use Core\Auth;
use Core\TemplateManager;

class AuthController
{
    private $auth;
    private $templateManager;
    
    public function __construct()
    {
        $this->auth = new Auth();
        $this->templateManager = new TemplateManager();
    }
    
    public function loginForm()
    {
        // Redirect if already logged in
        if ($this->auth->isLoggedIn()) {
            header('Location: /admin');
            exit;
        }
        
        $data = [
            'page_title' => 'Login',
            'error' => $_SESSION['login_error'] ?? null
        ];
        
        // Clear any error message
        unset($_SESSION['login_error']);
        
        $this->templateManager->render('admin/login.twig', $data);
    }
    
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($this->auth->login($email, $password)) {
            header('Location: /admin');
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid email or password';
            header('Location: /admin/login');
            exit;
        }
    }
    
    public function logout()
    {
        $this->auth->logout();
        header('Location: /admin/login');
        exit;
    }
}
