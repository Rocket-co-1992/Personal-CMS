<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'seo_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteSeo($_POST['id']);
    } else {
        $id = $_POST['id'];
        $page = $_POST['page'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $keywords = $_POST['keywords'];
        if ($id) {
            updateSeo($id, $page, $title, $description, $keywords);
        } else {
            createSeo($page, $title, $description, $keywords);
        }
    }
    header('Location: seo.php');
    exit;
}

$seoSettings = getSeo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage SEO</title>
</head>
<body>
    <h1>Manage SEO</h1>
    <form method="post">
        <input type="hidden" name="id" id="id">
        <label for="page">Page:</label>
        <input type="text" name="page" id="page" required>
        <br>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="5" required></textarea>
        <br>
        <label for="keywords">Keywords:</label>
        <textarea name="keywords" id="keywords" rows="3" required></textarea>
        <br>
        <button type="submit">Save SEO Settings</button>
    </form>
    <h2>Existing SEO Settings</h2>
    <ul>
        <?php foreach ($seoSettings as $seo): ?>
            <li>
                <h3><?php echo $seo['page']; ?></h3>
                <p>Title: <?php echo $seo['title']; ?></p>
                <p>Description: <?php echo $seo['description']; ?></p>
                <p>Keywords: <?php echo $seo['keywords']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $seo['id']; ?>">
                    <button type="button" onclick="editSeo(<?php echo $seo['id']; ?>, '<?php echo $seo['page']; ?>', '<?php echo $seo['title']; ?>', '<?php echo $seo['description']; ?>', '<?php echo $seo['keywords']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editSeo(id, page, title, description, keywords) {
            document.getElementById('id').value = id;
            document.getElementById('page').value = page;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('keywords').value = keywords;
        }
    </script>
</body>
</html>
