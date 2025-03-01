<?php
namespace Core;

class SectionManager
{
    private $db;
    private $sections = [
        'slider',
        'news',
        'team',
        'gallery',
        'contacts'
    ];
    
    public function __construct()
    {
        global $db;
        $this->db = $db ?? new Database();
    }
    
    public function getActiveSections()
    {
        $result = $this->db->query("SELECT * FROM sections WHERE active = 1 ORDER BY sort_order");
        return $result;
    }
    
    public function getSectionContent($sectionType, $sectionId = null)
    {
        switch ($sectionType) {
            case 'slider':
                return $this->getSliderContent($sectionId);
            case 'news':
                return $this->getNewsContent($sectionId);
            case 'team':
                return $this->getTeamContent($sectionId);
            case 'gallery':
                return $this->getGalleryContent($sectionId);
            case 'contacts':
                return $this->getContactsContent($sectionId);
            default:
                return null;
        }
    }
    
    private function getSliderContent($sectionId)
    {
        if ($sectionId) {
            return $this->db->query("SELECT * FROM slider_items WHERE section_id = ?", [$sectionId]);
        }
        return [];
    }
    
    private function getNewsContent($sectionId)
    {
        if ($sectionId) {
            return $this->db->query("SELECT * FROM news WHERE section_id = ? ORDER BY date DESC", [$sectionId]);
        }
        return [];
    }
    
    private function getTeamContent($sectionId)
    {
        if ($sectionId) {
            return $this->db->query("SELECT * FROM team_members WHERE section_id = ? ORDER BY sort_order", [$sectionId]);
        }
        return [];
    }
    
    private function getGalleryContent($sectionId)
    {
        if ($sectionId) {
            return $this->db->query("SELECT * FROM gallery_items WHERE section_id = ? ORDER BY sort_order", [$sectionId]);
        }
        return [];
    }
    
    private function getContactsContent($sectionId)
    {
        if ($sectionId) {
            return $this->db->query("SELECT * FROM contacts WHERE section_id = ?", [$sectionId])[0] ?? [];
        }
        return [];
    }
    
    public function getAvailableSectionTypes()
    {
        return $this->sections;
    }
}
