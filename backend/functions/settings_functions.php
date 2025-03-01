<?php
require '../config.php';

// Função para obter uma configuração
function getSetting($name) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT value FROM settings WHERE name = ?");
    $stmt->execute([$name]);
    return $stmt->fetchColumn();
}

// Função para atualizar uma configuração
function updateSetting($name, $value) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO settings (name, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");
    $stmt->execute([$name, $value]);
}
?>
