<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
    $section = $_POST['section'];
    $content = $_POST['content'];
    updateSectionContent($section, $content);
    header('Location: content.php');
    exit;
}

$sections = ['slider', 'teams', 'news', 'gallery', 'contact'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content</title>
</head>
<body>
    <h1>Manage Content</h1>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <label for="section">Section:</label>
        <select name="section" id="section">
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo $section; ?>"><?php echo ucfirst($section); ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="10" cols="50"></textarea>
        <br>
        <button type="submit">Update Content</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
