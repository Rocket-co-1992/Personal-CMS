<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteComment($_POST['id']);
    } else {
        $id = $_POST['id'];
        $content = $_POST['content'];
        if ($id) {
            updateComment($id, $content);
        } else {
            createComment($content);
        }
    }
    header('Location: comments.php');
    exit;
}

$comments = getComments();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments</title>
</head>
<body>
    <h1>Manage Comments</h1>
    <form method="post">
        <input type="hidden" name="id" id="id">
        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="5" required></textarea>
        <br>
        <button type="submit">Save Comment</button>
    </form>
    <h2>Existing Comments</h2>
    <ul>
        <?php foreach ($comments as $comment): ?>
            <li>
                <p><?php echo $comment['content']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                    <button type="button" onclick="editComment(<?php echo $comment['id']; ?>, '<?php echo $comment['content']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editComment(id, content) {
            document.getElementById('id').value = id;
            document.getElementById('content').value = content;
        }
    </script>
</body>
</html>
