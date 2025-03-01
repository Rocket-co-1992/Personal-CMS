<?php
require '../config.php';
require 'sanitize_functions.php';

// Função para adicionar um novo membro da equipe
function addTeamMember($name, $role, $image) {
    $name = sanitizeInput($name);
    $role = sanitizeInput($role);
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $targetFile);

    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO teams (name, role, image) VALUES (?, ?, ?)");
    $stmt->execute([$name, $role, $targetFile]);
}

// Função para atualizar um membro da equipe
function updateTeamMember($id, $name, $role, $image) {
    global $pdo;
    $name = sanitizeInput($name);
    $role = sanitizeInput($role);
    if ($image['name']) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $targetFile);
        $stmt = $pdo->prepare("UPDATE teams SET name = ?, role = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $role, $targetFile, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE teams SET name = ?, role = ? WHERE id = ?");
        $stmt->execute([$name, $role, $id]);
    }
}

// Função para deletar um membro da equipe
function deleteTeamMember($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM teams WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todos os membros da equipe
function getTeamMembers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, name, role, image FROM teams");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
