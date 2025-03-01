<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteContactMessage($_POST['id']);
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        updateContactMessage($id, $name, $email, $message);
    }
    header('Location: contact_messages.php');
    exit;
}

$messages = getContactMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
</head>
<body>
    <h1>Contact Messages</h1>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li>
                <strong><?php echo $message['name']; ?> (<?php echo $message['email']; ?>):</strong>
                <p><?php echo $message['message']; ?></p>
                <form method="post" style="display:inline;"></form>
                    <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                    <button type="button" onclick="editMessage(<?php echo $message['id']; ?>, '<?php echo $message['name']; ?>', '<?php echo $message['email']; ?>', '<?php echo $message['message']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <form method="post" id="editForm" style="display:none;">
        <input type="hidden" name="id" id="id">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" required></textarea>
        <br>
        <button type="submit">Save Message</button>
    </form>
    <script>
        function editMessage(id, name, email, message) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('message').value = message;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>
