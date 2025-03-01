<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para adicionar um item ao carrinho
function addToCart($product_id, $quantity, $session_id) {
    global $pdo;
    $product_id = sanitizeInput($product_id);
    $quantity = sanitizeInput($quantity);
    $session_id = sanitizeInput($session_id);
    $stmt = $pdo->prepare("INSERT INTO cart_items (product_id, quantity, session_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
    $stmt->execute([$product_id, $quantity, $session_id]);
}

// Função para atualizar a quantidade de um item no carrinho
function updateCartItem($id, $quantity) {
    global $pdo;
    $id = sanitizeInput($id);
    $quantity = sanitizeInput($quantity);
    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    $stmt->execute([$quantity, $id]);
}

// Função para remover um item do carrinho
function removeCartItem($id) {
    global $pdo;
    $id = sanitizeInput($id);
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os itens do carrinho
function getCartItems($session_id) {
    global $pdo;
    $session_id = sanitizeInput($session_id);
    $stmt = $pdo->prepare("SELECT cart_items.*, products.name, products.price, products.image FROM cart_items JOIN products ON cart_items.product_id = products.id WHERE session_id = ?");
    $stmt->execute([$session_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para limpar o carrinho
function clearCart($session_id) {
    global $pdo;
    $session_id = sanitizeInput($session_id);
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE session_id = ?");
    $stmt->execute([$session_id]);
}
?>
