<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
    if (isset($_POST['delete'])) {
        deleteImage(sanitizeInput($_POST['id']));
    } else {
        $image = $_FILES['image'];
        uploadImage($image);
    }
    header('Location: gallery.php');
    exit;
}

$images = getImages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
</head>
<body>
    <h1>Manage Gallery</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" required>
        <br>
        <button type="submit">Upload</button>
    </form>
    <h2>Existing Images</h2>
    <ul>
        <?php foreach ($images as $image): ?>
            <li>
                <img src="<?php echo htmlspecialchars($image['path']); ?>" alt="Image">
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($image['id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
