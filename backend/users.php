<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_BCRYPT);
    $role = sanitizeInput($_POST['role']);
    createUser($username, $password, $role);
    header('Location: users.php');
    exit;
}

$users = getUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
    <h1>Manage Users</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="editor">Editor</option>
        </select>
        <br>
        <button type="submit">Create User</button>
    </form>
    <h2>Existing Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo htmlspecialchars($user['username']); ?> (<?php echo htmlspecialchars($user['role']); ?>)</li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
