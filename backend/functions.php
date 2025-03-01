<?php
require 'config.php';

// Função para obter conteúdo de uma seção
function getSectionContent($section) {
    global $pdo;
    $section = sanitizeInput($section);
    $stmt = $pdo->prepare("SELECT content FROM sections WHERE name = ?");
    $stmt->execute([$section]);
    return $stmt->fetchColumn();
}

// Função para atualizar o conteúdo de uma seção
function updateSectionContent($section, $content) {
    global $pdo;
    $section = sanitizeInput($section);
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("UPDATE sections SET content = ? WHERE name = ?");
    $stmt->execute([$content, $section]);
}

// Função para autenticar usuário
function authenticateUser($username, $password) {
    global $pdo;
    $username = sanitizeInput($username);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

// Função para criar um novo usuário
function createUser($username, $password, $role) {
    global $pdo;
    $username = sanitizeInput($username);
    $password = password_hash($password, PASSWORD_BCRYPT);
    $role = sanitizeInput($role);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
}

// Função para obter todos os usuários
function getUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT username, role FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para atualizar o tema atual
function updateTheme($theme) {
    global $pdo;
    $theme = sanitizeInput($theme);
    $stmt = $pdo->prepare("UPDATE settings SET value = ? WHERE name = 'theme'");
    $stmt->execute([$theme]);
}

// Função para obter o tema atual
function getCurrentTheme() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT value FROM settings WHERE name = 'theme'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Função para salvar um tema
function saveTheme($name, $cssContent, $structure) {
    global $pdo;
    $name = sanitizeInput($name);
    $cssContent = sanitizeInput($cssContent);
    $structure = sanitizeInput($structure);
    $stmt = $pdo->prepare("INSERT INTO themes (name, css_content, structure) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE css_content = VALUES(css_content), structure = VALUES(structure)");
    $stmt->execute([$name, $cssContent, $structure]);
}

// Função para obter todos os temas
function getThemes() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT name FROM themes");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter a estrutura de um tema
function getThemeStructure($name) {
    global $pdo;
    $name = sanitizeInput($name);
    $stmt = $pdo->prepare("SELECT structure FROM themes WHERE name = ?");
    $stmt->execute([$name]);
    return $stmt->fetchColumn();
}

// Função para validar e sanitizar entradas
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Função para validar um email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Função para criar uma nova notícia
function createNews($title, $content, $url) {
    global $pdo;
    $title = sanitizeInput($title);
    $content = sanitizeInput($content);
    $url = sanitizeInput($url);
    $stmt = $pdo->prepare("INSERT INTO news (title, content, url) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $url]);
}

// Função para atualizar uma notícia
function updateNews($id, $title, $content, $url) {
    global $pdo;
    $id = sanitizeInput($id);
    $title = sanitizeInput($title);
    $content = sanitizeInput($content);
    $url = sanitizeInput($url);
    $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ?, url = ? WHERE id = ?");
    $stmt->execute([$title, $content, $url, $id]);
}

// Função para gerar um token CSRF
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Função para validar um token CSRF
function validateCsrfToken($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Função para obter todas as notícias
function getNews() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, title, content, url FROM news");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter todas as mensagens de contato
function getContactMessages() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT name, message FROM contact");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para salvar uma mensagem de contato
function saveContactMessage($name, $email, $message) {
    global $pdo;
    $name = sanitizeInput($name);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $message = sanitizeInput($message);
    $stmt = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);
}

// Função para atualizar uma mensagem de contato
function updateContactMessage($id, $name, $email, $message) {
    global $pdo;
    $id = sanitizeInput($id);
    $name = sanitizeInput($name);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $message = sanitizeInput($message);
    $stmt = $pdo->prepare("UPDATE contact SET name = ?, email = ?, message = ? WHERE id = ?");
    $stmt->execute([$name, $email, $message, $id]);
}

// Função para deletar uma mensagem de contato
function deleteContactMessage($id) {
    global $pdo;
    $id = sanitizeInput($id);
    $stmt = $pdo->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para fazer upload de uma imagem
function uploadImage($image) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename(sanitizeInput($image["name"]));
    move_uploaded_file($image["tmp_name"], $targetFile);
}

// Função para obter todas as imagens
function getImages() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT path FROM gallery");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para deletar uma imagem da galeria
function deleteImage($id) {
    global $pdo;
    $id = sanitizeInput($id);
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para adicionar um novo membro da equipe
function addTeamMember($name, $role, $image) {
    global $pdo;
    $name = sanitizeInput($name);
    $role = sanitizeInput($role);
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename(sanitizeInput($image["name"]));
    move_uploaded_file($image["tmp_name"], $targetFile);
    $stmt = $pdo->prepare("INSERT INTO teams (name, role, image) VALUES (?, ?, ?)");
    $stmt->execute([$name, $role, $targetFile]);
}

// Função para obter todos os membros da equipe
function getTeamMembers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT name, role, image FROM teams");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para atualizar um membro da equipe
function updateTeamMember($id, $name, $role, $image) {
    global $pdo;
    $id = sanitizeInput($id);
    $name = sanitizeInput($name);
    $role = sanitizeInput($role);
    if ($image['name']) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename(sanitizeInput($image["name"]));
        move_uploaded_file($image["tmp_name"], $targetFile);
        $stmt = $pdo->prepare("UPDATE teams SET name = ?, role = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $role, $targetFile, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE teams SET name = ?, role = ? WHERE id = ?");
        $stmt->execute([$name, $role, $id]);
    }
}

// Função para deletar um membro da equipe
function deleteTeamMember($id) {
    global $pdo;
    $id = sanitizeInput($id);
    $stmt = $pdo->prepare("DELETE FROM teams WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para criar um novo comentário
function createComment($content) {
    global $pdo;
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("INSERT INTO comments (content) VALUES (?)");
    $stmt->execute([$content]);
}

// Função para atualizar um comentário
function updateComment($id, $content) {
    global $pdo;
    $id = sanitizeInput($id);
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("UPDATE comments SET content = ? WHERE id = ?");
    $stmt->execute([$content, $id]);
}

// Função para deletar um comentário
function deleteComment($id) {
    global $pdo;
    $id = sanitizeInput($id);
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os comentários
function getComments() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, content FROM comments");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
