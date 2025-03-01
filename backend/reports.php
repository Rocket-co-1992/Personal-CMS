<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'report_functions.php';

$reports = getReports();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reports</title>
</head>
<body>
    <h1>Manage Reports</h1>
    <h2>Existing Reports</h2>
    <ul>
        <?php foreach ($reports as $report): ?>
            <li>
                <h3><?php echo $report['report_type']; ?></h3>
                <p><?php echo $report['report_data']; ?></p>
                <p>Created at: <?php echo $report['created_at']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
