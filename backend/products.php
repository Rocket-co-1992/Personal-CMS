<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'product_functions.php';
require 'category_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteProduct($_POST['id']);
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_FILES['image'];
        $category_id = $_POST['category_id'];
        if ($id) {
            updateProduct($id, $name, $description, $price, $image, $category_id);
        } else {
            createProduct($name, $description, $price, $image, $category_id);
        }
    }
    header('Location: products.php');
    exit;
}

$products = getProducts();
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
</head>
<body>
    <h1>Manage Products</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="5" required></textarea>
        <br>
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" required>
        <br>
        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image">
        <br>
        <button type="submit">Save Product</button>
    </form>
    <h2>Existing Products</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="button" onclick="editProduct(<?php echo $product['id']; ?>, '<?php echo $product['name']; ?>', '<?php echo $product['description']; ?>', '<?php echo $product['price']; ?>', '<?php echo $product['category_id']; ?>', '<?php echo $product['image']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editProduct(id, name, description, price, category_id, image) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
            document.getElementById('category_id').value = category_id;
            // Handle image upload separately if needed
        }
    </script>
</body>
</html>
