<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar uma nova categoria
function createCategory($name) {
    global $pdo;
    $name = sanitizeInput($name);
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
}

// Função para atualizar uma categoria
function updateCategory($id, $name) {
    global $pdo;
    $name = sanitizeInput($name);
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);
}

// Função para deletar uma categoria
function deleteCategory($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todas as categorias
function getCategories() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
