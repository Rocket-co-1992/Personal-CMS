<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: auth.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['user']['username']; ?></h1>
    <ul>
        <li><a href="content.php">Manage Content</a></li>
        <li><a href="news.php">Manage News</a></li>
        <li><a href="gallery.php">Manage Gallery</a></li>
        <li><a href="teams.php">Manage Teams</a></li>
        <li><a href="themes.php">Manage Themes</a></li>
        <li><a href="users.php">Manage Users</a></li>
        <li><a href="contact_messages.php">View Contact Messages</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
