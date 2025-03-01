<?php
namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateManager
{
    private $twig;
    private $db;
    private $activeTemplate;
    
    public function __construct()
    {
        global $db;
        $this->db = $db ?? new Database();
        
        // Initialize Twig
        $loader = new FilesystemLoader(BASE_PATH . '/templates');
        $this->twig = new Environment($loader, [
            'cache' => BASE_PATH . '/cache/twig',
            'debug' => true,
        ]);
        
        // Get active template
        $this->activeTemplate = $this->getActiveTemplate();
    }
    
    private function getActiveTemplate()
    {
        $result = $this->db->query("SELECT * FROM templates WHERE active = 1 LIMIT 1");
        return $result[0] ?? 'default';
    }
    
    public function render($template, $data = [])
    {
        // Add global variables
        $data['base_url'] = BASE_URL;
        $data['template_path'] = BASE_URL . '/templates/' . $this->activeTemplate;
        
        try {
            echo $this->twig->render($this->activeTemplate . '/' . $template, $data);
        } catch (\Exception $e) {
            // Fallback to default template if active template doesn't have this view
            try {
                echo $this->twig->render('default/' . $template, $data);
            } catch (\Exception $e) {
                throw new \Exception('Template not found: ' . $template);
            }
        }
    }
}
