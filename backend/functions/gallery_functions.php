<?php
require '../config.php';

// Função para fazer upload de uma imagem
function uploadImage($image) {
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $targetFile);

    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO gallery (path) VALUES (?)");
    $stmt->execute([$targetFile]);
}

// Função para deletar uma imagem da galeria
function deleteImage($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
}

// Função para obter todas as imagens
function getImages() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, path FROM gallery");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
