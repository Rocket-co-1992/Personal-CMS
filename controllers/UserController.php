<?php
namespace Controllers;

use Core\Auth;
use Core\TemplateManager;

class UserController
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
        if (!$this->auth->check('manage_users')) {
            header('Location: /admin');
            exit;
        }
    }
    
    public function index()
    {
        $users = $this->db->query("SELECT * FROM users");
        $data = [
            'page_title' => 'Manage Users',
            'users' => $users,
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/users/index.twig', $data);
    }
    
    public function create()
    {
        $roles = $this->db->query("SELECT * FROM roles");
        $data = [
            'page_title' => 'Create User',
            'roles' => $roles,
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/users/create.twig', $data);
    }
    
    public function store()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'author';
        
        // Validate inputs
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['form_error'] = 'All fields are required';
            header('Location: /admin/users/create');
            exit;
        }
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the user
        $this->db->query(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)",
            [$name, $email, $hashedPassword, $role]
        );
        
        header('Location: /admin/users');
        exit;
    }
    
    public function edit($params)
    {
        $id = $params['id'] ?? 0;
        $users = $this->db->query("SELECT * FROM users WHERE id = ? LIMIT 1", [$id]);
        
        if (empty($users)) {
            header('Location: /admin/users');
            exit;
        }
        
        $roles = $this->db->query("SELECT * FROM roles");
        $data = [
            'page_title' => 'Edit User',
            'edit_user' => $users[0],
            'roles' => $roles,
            'user' => $this->auth->currentUser()
        ];
        
        $this->templateManager->render('admin/users/edit.twig', $data);
    }
    
    public function update($params)
    {
        $id = $params['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'author';
        
        // Validate inputs
        if (empty($name) || empty($email)) {
            $_SESSION['form_error'] = 'Name and email are required';
            header('Location: /admin/users/edit/' . $id);
            exit;
        }
        
        // Update user
        if (!empty($password)) {
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $this->db->query(
                "UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?",
                [$name, $email, $hashedPassword, $role, $id]
            );
        } else {
            $this->db->query(
                "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?",
                [$name, $email, $role, $id]
            );
        }
        
        header('Location: /admin/users');
        exit;
    }
    
    public function delete($params)
    {
        $id = $params['id'] ?? 0;
        
        // Prevent deleting yourself
        if ($id == $this->auth->currentUser()['id']) {
            $_SESSION['delete_error'] = 'You cannot delete yourself';
            header('Location: /admin/users');
            exit;
        }
        
        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
        
        header('Location: /admin/users');
        exit;
    }
}
