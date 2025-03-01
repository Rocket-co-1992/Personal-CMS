<?php
namespace Controllers;

use Core\Auth;
use Core\SectionManager;
use Core\TemplateManager;

class SectionController
{
    private $auth;
    private $sectionManager;
    private $templateManager;
    private $db;
    
    public function __construct()
    {
        $this->auth = new Auth();
        $this->sectionManager = new SectionManager();
        $this->templateManager = new TemplateManager();
        
        global $db;
        $this->db = $db;
        
        // Check if user is logged in
        if (!$this->auth->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        // Check if user has permission
        if (!$this->auth->check('manage_sections') && !$this->auth->check('edit_content')) {
            header('Location: /admin');
            exit;
        }
    }
    
    public function index()
    {
        $sections = $this->db->query("SELECT * FROM sections ORDER BY sort_order");
        
        $data = [
            'page_title' => 'Manage Sections',
            'sections' => $sections,
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/sections/index.twig', $data);
    }
    
    public function edit($params)
    {
        $id = $params['id'] ?? 0;
        $sections = $this->db->query("SELECT * FROM sections WHERE id = ? LIMIT 1", [$id]);
        
        if (empty($sections)) {
            header('Location: /admin/sections');
            exit;
        }
        
        $section = $sections[0];
        $sectionContent = $this->sectionManager->getSectionContent($section['type'], $section['id']);
        
        $data = [
            'page_title' => 'Edit ' . $section['name'],
            'section' => $section,
            'section_content' => $sectionContent,
            'available_types' => $this->sectionManager->getAvailableSectionTypes(),
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/sections/edit.twig', $data);
    }
    
    public function update($params)
    {
        $id = $params['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $active = isset($_POST['active']) ? 1 : 0;
        $sort_order = $_POST['sort_order'] ?? 0;
        
        // Update section
        $this->db->query(
            "UPDATE sections SET name = ?, active = ?, sort_order = ? WHERE id = ?",
            [$name, $active, $sort_order, $id]
        );
        
        // Update section content based on type
        $sections = $this->db->query("SELECT * FROM sections WHERE id = ? LIMIT 1", [$id]);
        
        if (!empty($sections)) {
            $section = $sections[0];
            $this->updateSectionContent($section['type'], $id);
        }
        
        header('Location: /admin/sections');
        exit;
    }
    
    private function updateSectionContent($type, $sectionId)
    {
        switch ($type) {
            case 'slider':
                $this->updateSliderContent($sectionId);
                break;
            case 'news':
                $this->updateNewsContent($sectionId);
                break;
            case 'team':
                $this->updateTeamContent($sectionId);
                break;
            case 'gallery':
                $this->updateGalleryContent($sectionId);
                break;
            case 'contacts':
                $this->updateContactsContent($sectionId);
                break;
        }
    }
    
    // Content update methods for each section type
    private function updateSliderContent($sectionId) {
        // Implementation for updating slider content
    }
    
    private function updateNewsContent($sectionId) {
        // Implementation for updating news content
    }
    
    private function updateTeamContent($sectionId) {
        // Implementation for updating team content
    }
    
    private function updateGalleryContent($sectionId) {
        // Implementation for updating gallery content
    }
    
    private function updateContactsContent($sectionId) {
        // Implementation for updating contacts content
    }
}
