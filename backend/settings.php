<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'settings_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shop_enabled = isset($_POST['shop_enabled']) ? '1' : '0';
    updateSetting('shop_enabled', $shop_enabled);
    header('Location: settings.php');
    exit;
}

$shop_enabled = getSetting('shop_enabled');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
</head>
<body>
    <h1>Settings</h1>
    <form method="post">
        <label for="shop_enabled">Enable Shop:</label>
        <input type="checkbox" name="shop_enabled" id="shop_enabled" <?php echo $shop_enabled ? 'checked' : ''; ?>>
        <br>
        <button type="submit">Save Settings</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
