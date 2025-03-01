<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar um novo post no blog
function createBlogPost($title, $content) {
    global $pdo;
    $title = sanitizeInput($title);
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("INSERT INTO blog (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);
}

// Função para atualizar um post no blog
function updateBlogPost($id, $title, $content) {
    global $pdo;
    $title = sanitizeInput($title);
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("UPDATE blog SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $id]);
}

// Função para deletar um post no blog
function deleteBlogPost($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM blog WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os posts do blog
function getBlogPosts() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM blog");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
