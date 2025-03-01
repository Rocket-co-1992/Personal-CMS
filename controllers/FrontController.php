<?php
namespace Controllers;

use Core\SectionManager;
use Core\TemplateManager;

class FrontController
{
    private $templateManager;
    private $sectionManager;
    
    public function __construct()
    {
        $this->templateManager = new TemplateManager();
        $this->sectionManager = new SectionManager();
    }
    
    public function index()
    {
        $sections = $this->sectionManager->getActiveSections();
        $data = ['sections' => []];
        
        foreach ($sections as $section) {
            $sectionData = [
                'id' => $section['id'],
                'name' => $section['name'],
                'type' => $section['type'],
                'settings' => json_decode($section['settings'], true),
                'content' => $this->sectionManager->getSectionContent($section['type'], $section['id'])
            ];
            
            $data['sections'][] = $sectionData;
        }
        
        $this->templateManager->render('index.twig', $data);
    }
}
