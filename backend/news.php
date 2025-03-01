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
        deleteNews($_POST['id']);
    } else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $url = $_POST['url'];
        if ($id) {
            updateNews($id, $title, $content, $url);
        } else {
            createNews($title, $content, $url);
        }
    }
    header('Location: news.php');
    exit;
}

$newsList = getNews();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
</head>
<body>
    <h1>Manage News</h1>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <input type="hidden" name="id" id="id">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="10" cols="50" required></textarea>
        <br>
        <label for="url">URL:</label>
        <input type="text" name="url" id="url" required>
        <br>
        <button type="submit">Save News</button>
    </form>
    <h2>Existing News</h2>
    <ul>
        <?php foreach ($newsList as $news): ?>
            <li>
                <h3><?php echo $news['title']; ?></h3>
                <p><?php echo $news['content']; ?></p>
                <p><a href="<?php echo $news['url']; ?>" target="_blank"><?php echo $news['url']; ?></a></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                    <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
                    <button type="button" onclick="editNews(<?php echo $news['id']; ?>, '<?php echo $news['title']; ?>', '<?php echo $news['content']; ?>', '<?php echo $news['url']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editNews(id, title, content, url) {
            document.getElementById('id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('content').value = content;
            document.getElementById('url').value = url;
        }
    </script>
</body>
</html>
