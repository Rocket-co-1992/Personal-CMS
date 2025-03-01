<?php
namespace Controllers;

use Core\Auth;
use Core\PluginManager;
use Core\TemplateManager;

class PluginController
{
    private $auth;
    private $pluginManager;
    private $templateManager;
    
    public function __construct()
    {
        $this->auth = new Auth();
        $this->pluginManager = new PluginManager();
        $this->templateManager = new TemplateManager();
        
        // Check if user is logged in
        if (!$this->auth->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        // Check if user has permission
        if (!$this->auth->check('manage_plugins')) {
            header('Location: /admin');
            exit;
        }
    }
    
    public function index()
    {
        $plugins = $this->pluginManager->getPlugins();
        
        $data = [
            'page_title' => 'Manage Plugins',
            'plugins' => $plugins,
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/plugins/index.twig', $data);
    }
    
    public function activate($params)
    {
        $id = $params['id'] ?? 0;
        $this->pluginManager->activatePlugin($id);
        
        header('Location: /admin/plugins');
        exit;
    }
    
    public function deactivate($params)
    {
        $id = $params['id'] ?? 0;
        $this->pluginManager->deactivatePlugin($id);
        
        header('Location: /admin/plugins');
        exit;
    }
}
