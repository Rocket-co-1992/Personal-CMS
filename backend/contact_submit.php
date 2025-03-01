<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = sanitizeInput($_POST['message']);
    if ($name && $email && $message) {
        saveContactMessage($name, $email, $message);
        header('Location: ../frontend/index.html.twig');
        exit;
    } else {
        die('Invalid input');
    }
}
?>
