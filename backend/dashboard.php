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
        <li><a href="products.php">Manage Products</a></li>
        <li><a href="categories.php">Manage Categories</a></li>
        <li><a href="orders.php">Manage Orders</a></li>
        <li><a href="cart.php">View Cart</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="blog.php">Manage Blog</a></li>
        <li><a href="events.php">Manage Events</a></li>
        <li><a href="faq.php">Manage FAQ</a></li>
        <li><a href="reports.php">Manage Reports</a></li>
        <li><a href="notifications.php">View Notifications</a></li>
        <li><a href="seo.php">Manage SEO</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
