<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar um novo evento
function createEvent($title, $description, $event_date) {
    global $pdo;
    $title = sanitizeInput($title);
    $description = sanitizeInput($description);
    $event_date = sanitizeInput($event_date);
    $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $event_date]);
}

// Função para atualizar um evento
function updateEvent($id, $title, $description, $event_date) {
    global $pdo;
    $title = sanitizeInput($title);
    $description = sanitizeInput($description);
    $event_date = sanitizeInput($event_date);
    $stmt = $pdo->prepare("UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?");
    $stmt->execute([$title, $description, $event_date, $id]);
}

// Função para deletar um evento
function deleteEvent($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os eventos
function getEvents() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM events");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
