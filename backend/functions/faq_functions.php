<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar uma nova pergunta no FAQ
function createFaq($question, $answer) {
    global $pdo;
    $question = sanitizeInput($question);
    $answer = sanitizeInput($answer);
    $stmt = $pdo->prepare("INSERT INTO faq (question, answer) VALUES (?, ?)");
    $stmt->execute([$question, $answer]);
}

// Função para atualizar uma pergunta no FAQ
function updateFaq($id, $question, $answer) {
    global $pdo;
    $question = sanitizeInput($question);
    $answer = sanitizeInput($answer);
    $stmt = $pdo->prepare("UPDATE faq SET question = ?, answer = ? WHERE id = ?");
    $stmt->execute([$question, $answer, $id]);
}

// Função para deletar uma pergunta no FAQ
function deleteFaq($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM faq WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todas as perguntas do FAQ
function getFaqs() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM faq");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
