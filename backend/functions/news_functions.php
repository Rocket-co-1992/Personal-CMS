<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar uma nova notícia
function createNews($title, $content) {
    global $pdo;
    $title = sanitizeInput($title);
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("INSERT INTO news (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);
}

// Função para atualizar uma notícia
function updateNews($id, $title, $content) {
    global $pdo;
    $title = sanitizeInput($title);
    $content = sanitizeInput($content);
    $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $id]);
}

// Função para deletar uma notícia
function deleteNews($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todas as notícias
function getNews() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, title, content FROM news");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
