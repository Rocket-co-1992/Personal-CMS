<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

$messages = getContactMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact Messages</title>
</head>
<body>
    <h1>Manage Contact Messages</h1>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li><?php echo sanitizeInput($message['name']); ?>: <?php echo sanitizeInput($message['message']); ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
