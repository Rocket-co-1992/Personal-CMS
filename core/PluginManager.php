<?php
namespace Core;

class PluginManager
{
    private $db;
    private $loadedPlugins = [];
    
    public function __construct()
    {
        global $db;
        $this->db = $db ?? new Database();
    }
    
    public function loadActivePlugins()
    {
        $plugins = $this->db->query("SELECT * FROM plugins WHERE active = 1");
        
        foreach ($plugins as $plugin) {
            $pluginPath = BASE_PATH . '/plugins/' . $plugin['directory'] . '/init.php';
            
            if (file_exists($pluginPath)) {
                require_once $pluginPath;
                
                $className = '\\Plugins\\' . ucfirst($plugin['directory']) . '\\Plugin';
                
                if (class_exists($className)) {
                    $pluginInstance = new $className();
                    $pluginInstance->initialize();
                    $this->loadedPlugins[$plugin['directory']] = $pluginInstance;
                }
            }
        }
    }
    
    public function getPlugins()
    {
        return $this->db->query("SELECT * FROM plugins");
    }
    
    public function activatePlugin($id)
    {
        $this->db->query("UPDATE plugins SET active = 1 WHERE id = ?", [$id]);
    }
    
    public function deactivatePlugin($id)
    {
        $this->db->query("UPDATE plugins SET active = 0 WHERE id = ?", [$id]);
    }
    
    public function registerPlugin($directory, $name, $description, $version, $author)
    {
        $this->db->query(
            "INSERT INTO plugins (directory, name, description, version, author, active) 
             VALUES (?, ?, ?, ?, ?, 0)
             ON DUPLICATE KEY UPDATE name = ?, description = ?, version = ?, author = ?",
            [$directory, $name, $description, $version, $author, $name, $description, $version, $author]
        );
    }
}
