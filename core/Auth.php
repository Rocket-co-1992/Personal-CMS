<?php
namespace Core;

class Auth
{
    private $db;
    
    public function __construct($db = null)
    {
        global $db;
        $this->db = $db ?? new Database();
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function login($email, $password)
    {
        $users = $this->db->query("SELECT * FROM users WHERE email = ? LIMIT 1", [$email]);
        
        if (empty($users)) {
            return false;
        }
        
        $user = $users[0];
        
        if (password_verify($password, $user['password'])) {
            // Store user in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            
            return true;
        }
        
        return false;
    }
    
    public function logout()
    {
        // Unset all session variables
        $_SESSION = [];
        
        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
    }
    
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
    
    public function currentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        $users = $this->db->query("SELECT * FROM users WHERE id = ? LIMIT 1", [$_SESSION['user_id']]);
        return $users[0] ?? null;
    }
    
    public function hasRole($role)
    {
        return $this->isLoggedIn() && $_SESSION['user_role'] === $role;
    }
    
    public function check($permission)
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        $role = $_SESSION['user_role'];
        $permissions = $this->db->query(
            "SELECT p.name 
             FROM permissions p 
             JOIN role_permissions rp ON p.id = rp.permission_id 
             JOIN roles r ON rp.role_id = r.id 
             WHERE r.name = ?",
            [$role]
        );
        
        foreach ($permissions as $perm) {
            if ($perm['name'] === $permission) {
                return true;
            }
        }
        
        return false;
    }
}
