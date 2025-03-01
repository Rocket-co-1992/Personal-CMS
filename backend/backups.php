<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'backup_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        createBackup();
    } elseif (isset($_POST['restore'])) {
        $filename = $_POST['filename'];
        restoreBackup($filename);
    }
    header('Location: backups.php');
    exit;
}

$backups = getBackups();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Backups</title>
</head>
<body>
    <h1>Manage Backups</h1>
    <form method="post">
        <button type="submit" name="create">Create Backup</button>
    </form>
    <h2>Existing Backups</h2>
    <ul>
        <?php foreach ($backups as $backup): ?>
            <li>
                <p><?php echo $backup['filename']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="filename" value="<?php echo $backup['filename']; ?>">
                    <button type="submit" name="restore">Restore</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
