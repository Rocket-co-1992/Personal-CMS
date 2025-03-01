<?php
namespace Controllers;

use Core\Auth;
use Core\TemplateManager;

class AdminController
{
    private $auth;
    private $templateManager;
    
    public function __construct()
    {
        $this->auth = new Auth();
        $this->templateManager = new TemplateManager();
        
        // Check if user is logged in
        if (!$this->auth->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
    }
    
    public function dashboard()
    {
        $data = [
            'page_title' => 'Dashboard',
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/dashboard.twig', $data);
    }
}
