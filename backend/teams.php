<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteTeamMember($_POST['id']);
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $role = $_POST['role'];
        $image = $_FILES['image'];
        if ($id) {
            updateTeamMember($id, $name, $role, $image);
        } else {
            addTeamMember($name, $role, $image);
        }
    }
    header('Location: teams.php');
    exit;
}

$teamMembers = getTeamMembers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teams</title>
</head>
<body>
    <h1>Manage Teams</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="role">Role:</label>
        <input type="text" name="role" id="role" required>
        <br>
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image">
        <br>
        <button type="submit">Save Team Member</button>
    </form>
    <h2>Existing Team Members</h2>
    <ul>
        <?php foreach ($teamMembers as $member): ?>
            <li>
                <img src="<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>">
                <h3><?php echo $member['name']; ?></h3>
                <p><?php echo $member['role']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                    <button type="button" onclick="editTeamMember(<?php echo $member['id']; ?>, '<?php echo $member['name']; ?>', '<?php echo $member['role']; ?>', '<?php echo $member['image']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editTeamMember(id, name, role, image) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('role').value = role;
            // Handle image upload separately if needed
        }
    </script>
</body>
</html>
