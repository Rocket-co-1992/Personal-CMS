<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para obter conteúdo de uma seção
function getSectionContent($section) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT content FROM sections WHERE name = ?");
    $stmt->execute([$section]);
    return $stmt->fetchColumn();
}

// Função para atualizar o conteúdo de uma seção
function updateSectionContent($section, $content) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE sections SET content = ? WHERE name = ?");
    $stmt->execute([$content, $section]);
}
?>
