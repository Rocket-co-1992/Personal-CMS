<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'blog_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteBlogPost($_POST['id']);
    } else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        if ($id) {
            updateBlogPost($id, $title, $content);
        } else {
            createBlogPost($title, $content);
        }
    }
    header('Location: blog.php');
    exit;
}

$blogPosts = getBlogPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog</title>
</head>
<body>
    <h1>Manage Blog</h1>
    <form method="post">
        <input type="hidden" name="id" id="id">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="10" cols="50" required></textarea>
        <br>
        <button type="submit">Save Blog Post</button>
    </form>
    <h2>Existing Blog Posts</h2>
    <ul>
        <?php foreach ($blogPosts as $post): ?>
            <li>
                <h3><?php echo $post['title']; ?></h3>
                <p><?php echo $post['content']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    <button type="button" onclick="editBlogPost(<?php echo $post['id']; ?>, '<?php echo $post['title']; ?>', '<?php echo $post['content']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editBlogPost(id, title, content) {
            document.getElementById('id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('content').value = content;
        }
    </script>
</body>
</html>
