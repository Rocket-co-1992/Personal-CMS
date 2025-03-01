<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'category_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteCategory($_POST['id']);
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        if ($id) {
            updateCategory($id, $name);
        } else {
            createCategory($name);
        }
    }
    header('Location: categories.php');
    exit;
}

$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
</head>
<body>
    <h1>Manage Categories</h1>
    <form method="post">
        <input type="hidden" name="id" id="id">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <button type="submit">Save Category</button>
    </form>
    <h2>Existing Categories</h2>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <h3><?php echo $category['name']; ?></h3>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    <button type="button" onclick="editCategory(<?php echo $category['id']; ?>, '<?php echo $category['name']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editCategory(id, name) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
        }
    </script>
</body>
</html>
