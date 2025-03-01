<?php
require '../config.php';

// Função para criar uma nova notificação
function createNotification($user_id, $message) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $stmt->execute([$user_id, $message]);
}

// Função para obter notificações de um usuário
function getUserNotifications($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para marcar uma notificação como lida
function markNotificationAsRead($id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE notifications SET read_at = NOW() WHERE id = ?");
    $stmt->execute([$id]);
}
?>
