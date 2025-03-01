<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar um novo pedido
function createOrder($customer_name, $customer_email, $total, $status) {
    global $pdo;
    $customer_name = sanitizeInput($customer_name);
    $customer_email = sanitizeInput($customer_email);
    $total = sanitizeInput($total);
    $status = sanitizeInput($status);
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, total, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$customer_name, $customer_email, $total, $status]);
}

// Função para atualizar um pedido
function updateOrder($id, $status) {
    global $pdo;
    $status = sanitizeInput($status);
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

// Função para deletar um pedido
function deleteOrder($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os pedidos
function getOrders() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
