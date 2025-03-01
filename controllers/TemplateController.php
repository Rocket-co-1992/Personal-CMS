<?php
namespace Controllers;

use Core\Auth;
use Core\TemplateManager;

class TemplateController
{
    private $auth;
    private $templateManager;
    private $db;
    
    public function __construct()
    {
        $this->auth = new Auth();
        $this->templateManager = new TemplateManager();
        
        global $db;
        $this->db = $db;
        
        // Check if user is logged in
        if (!$this->auth->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        // Check if user has permission
        if (!$this->auth->check('manage_templates')) {
            header('Location: /admin');
            exit;
        }
    }
    
    public function index()
    {
        $templates = $this->db->query("SELECT * FROM templates");
        
        $data = [
            'page_title' => 'Manage Templates',
            'templates' => $templates,
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/templates/index.twig', $data);
    }
    
    public function activate($params)
    {
        $id = $params['id'] ?? 0;
        
        // Deactivate all templates first
        $this->db->query("UPDATE templates SET active = 0");
        
        // Activate the selected template
        $this->db->query("UPDATE templates SET active = 1 WHERE id = ?", [$id]);
        
        header('Location: /admin/templates');
        exit;
    }
}
