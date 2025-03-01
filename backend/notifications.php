<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'notification_functions.php';

$user_id = $_SESSION['user']['id'];
$notifications = getUserNotifications($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    markNotificationAsRead($id);
    header('Location: notifications.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
</head>
<body>
    <h1>Notifications</h1>
    <ul>
        <?php foreach ($notifications as $notification): ?>
            <li>
                <p><?php echo $notification['message']; ?></p>
                <p>Created at: <?php echo $notification['created_at']; ?></p>
                <?php if (!$notification['read_at']): ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
                        <button type="submit">Mark as Read</button>
                    </form>
                <?php else: ?>
                    <p>Read at: <?php echo $notification['read_at']; ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
