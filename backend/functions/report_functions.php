<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para criar um novo relatório
function createReport($report_type, $report_data) {
    global $pdo;
    $report_type = sanitizeInput($report_type);
    $report_data = sanitizeInput($report_data);
    $stmt = $pdo->prepare("INSERT INTO reports (report_type, report_data) VALUES (?, ?)");
    $stmt->execute([$report_type, $report_data]);
}

// Função para obter todos os relatórios
function getReports() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM reports");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
