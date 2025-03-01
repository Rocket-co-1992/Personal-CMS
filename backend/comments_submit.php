<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = sanitizeInput($_POST['content']);
    if ($content) {
        createComment($content);
        header('Location: ../frontend/index.html.twig');
        exit;
    } else {
        die('Invalid input');
    }
}
?>
