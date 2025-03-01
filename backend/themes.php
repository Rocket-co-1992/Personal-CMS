<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'];
    updateTheme($theme);
    header('Location: themes.php');
    exit;
}

$themes = array_merge(['theme1', 'theme2', 'theme3', 'theme4', 'business', 'portfolio', 'education', 'healthcare'], array_column(getThemes(), 'name'));
$currentTheme = getCurrentTheme();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Themes</title>
</head>
<body>
    <h1>Manage Themes</h1>
    <form method="post">
        <label for="theme">Select Theme:</label>
        <select name="theme" id="theme">
            <?php foreach ($themes as $theme): ?>
                <option value="<?php echo $theme; ?>" <?php echo $theme === $currentTheme ? 'selected' : ''; ?>>
                    <?php echo ucfirst($theme); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Update Theme</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
