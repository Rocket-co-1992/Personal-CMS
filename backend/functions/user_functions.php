<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para autenticar usuário
function authenticateUser($username, $password) {
    global $pdo;
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
?>
