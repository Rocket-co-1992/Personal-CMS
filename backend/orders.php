<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'order_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteOrder($_POST['id']);
    } else {
        $id = $_POST['id'];
        $status = $_POST['status'];
        updateOrder($id, $status);
    }
    header('Location: orders.php');
    exit;
}

$orders = getOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
</head>
<body>
    <h1>Manage Orders</h1>
    <h2>Existing Orders</h2>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                <strong><?php echo $order['customer_name']; ?> (<?php echo $order['customer_email']; ?>):</strong>
                <p>Total: $<?php echo $order['total']; ?></p>
                <p>Status: <?php echo $order['status']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Processing" <?php echo $order['status'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="Completed" <?php echo $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <button type="submit">Update</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
