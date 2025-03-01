<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar uma nova configuração de SEO
function createSeo($page, $title, $description, $keywords) {
    global $pdo;
    $page = sanitizeInput($page);
    $title = sanitizeInput($title);
    $description = sanitizeInput($description);
    $keywords = sanitizeInput($keywords);
    $stmt = $pdo->prepare("INSERT INTO seo (page, title, description, keywords) VALUES (?, ?, ?, ?)");
    $stmt->execute([$page, $title, $description, $keywords]);
}

// Função para atualizar uma configuração de SEO
function updateSeo($id, $page, $title, $description, $keywords) {
    global $pdo;
    $page = sanitizeInput($page);
    $title = sanitizeInput($title);
    $description = sanitizeInput($description);
    $keywords = sanitizeInput($keywords);
    $stmt = $pdo->prepare("UPDATE seo SET page = ?, title = ?, description = ?, keywords = ? WHERE id = ?");
    $stmt->execute([$page, $title, $description, $keywords, $id]);
}

// Função para deletar uma configuração de SEO
function deleteSeo($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM seo WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todas as configurações de SEO
function getSeo() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM seo");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
