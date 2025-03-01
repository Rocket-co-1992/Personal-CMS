<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar um novo produto
function createProduct($name, $description, $price, $image, $category_id) {
    global $pdo;
    $name = sanitizeInput($name);
    $description = sanitizeInput($description);
    $price = sanitizeInput($price);
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $targetFile);
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $targetFile, $category_id]);
}

// Função para atualizar um produto
function updateProduct($id, $name, $description, $price, $image, $category_id) {
    global $pdo;
    $name = sanitizeInput($name);
    $description = sanitizeInput($description);
    $price = sanitizeInput($price);
    if ($image['name']) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $targetFile);
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $targetFile, $category_id, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $category_id, $id]);
    }
}

// Função para deletar um produto
function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os produtos
function getProducts() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
