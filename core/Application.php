<?php
namespace Core;

class Application
{
    private $router;
    private $db;
    private $auth;
    private $pluginManager;
    private $templateManager;
    private $sectionManager;
    
    public function __construct()
    {
        // Initialize database connection
        $this->db = new Database();
        
        // Initialize authentication service
        $this->auth = new Auth($this->db);
        
        // Initialize router
        $this->router = new Router();
        
        // Initialize plugin manager
        $this->pluginManager = new PluginManager();
        
        // Initialize template manager
        $this->templateManager = new TemplateManager();
        
        // Initialize section manager
        $this->sectionManager = new SectionManager();
        
        // Register routes
        $this->registerRoutes();
        
        // Load active plugins
        $this->pluginManager->loadActivePlugins();
    }
    
    private function registerRoutes()
    {
        // Admin routes
        $this->router->add('GET', '/admin', 'AdminController@dashboard');
        $this->router->add('GET', '/admin/login', 'AuthController@loginForm');
        $this->router->add('POST', '/admin/login', 'AuthController@login');
        $this->router->add('GET', '/admin/logout', 'AuthController@logout');
        
        // Section routes
        $this->router->add('GET', '/admin/sections', 'SectionController@index');
        $this->router->add('GET', '/admin/sections/edit/{id}', 'SectionController@edit');
        $this->router->add('POST', '/admin/sections/update/{id}', 'SectionController@update');
        
        // Plugin routes
        $this->router->add('GET', '/admin/plugins', 'PluginController@index');
        $this->router->add('GET', '/admin/plugins/activate/{id}', 'PluginController@activate');
        $this->router->add('GET', '/admin/plugins/deactivate/{id}', 'PluginController@deactivate');
        
        // Template routes
        $this->router->add('GET', '/admin/templates', 'TemplateController@index');
        $this->router->add('GET', '/admin/templates/activate/{id}', 'TemplateController@activate');
        
        // User routes
        $this->router->add('GET', '/admin/users', 'UserController@index');
        $this->router->add('GET', '/admin/users/create', 'UserController@create');
        $this->router->add('POST', '/admin/users/store', 'UserController@store');
        $this->router->add('GET', '/admin/users/edit/{id}', 'UserController@edit');
        $this->router->add('POST', '/admin/users/update/{id}', 'UserController@update');
        $this->router->add('GET', '/admin/users/delete/{id}', 'UserController@delete');
        
        // Front-end route
        $this->router->add('GET', '/', 'FrontController@index');
    }
    
    public function run()
    {
        try {
            $this->router->dispatch();
        } catch (\Exception $e) {
            // Handle exceptions
            echo 'Error: ' . $e->getMessage();
        }
    }
}
