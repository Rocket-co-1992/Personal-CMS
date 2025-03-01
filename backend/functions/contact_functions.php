<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para salvar uma mensagem de contato
function saveContactMessage($name, $email, $message) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);
}

// Função para atualizar uma mensagem de contato
function updateContactMessage($id, $name, $email, $message) {
    global $pdo;
    $name = sanitizeInput($name);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $message = sanitizeInput($message);
    $stmt = $pdo->prepare("UPDATE contact SET name = ?, email = ?, message = ? WHERE id = ?");
    $stmt->execute([$name, $email, $message, $id]);
}

// Função para deletar uma mensagem de contato
function deleteContactMessage($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todas as mensagens de contato
function getContactMessages() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, name, email, message FROM contact");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
