<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'event_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteEvent($_POST['id']);
    } else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $event_date = $_POST['event_date'];
        if ($id) {
            updateEvent($id, $title, $description, $event_date);
        } else {
            createEvent($title, $description, $event_date);
        }
    }
    header('Location: events.php');
    exit;
}

$events = getEvents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
</head>
<body>
    <h1>Manage Events</h1>
    <form method="post">
        <input type="hidden" name="id" id="id">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="5" required></textarea>
        <br>
        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" id="event_date" required>
        <br>
        <button type="submit">Save Event</button>
    </form>
    <h2>Existing Events</h2>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <h3><?php echo $event['title']; ?></h3>
                <p><?php echo $event['description']; ?></p>
                <p>Date: <?php echo $event['event_date']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                    <button type="button" onclick="editEvent(<?php echo $event['id']; ?>, '<?php echo $event['title']; ?>', '<?php echo $event['description']; ?>', '<?php echo $event['event_date']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editEvent(id, title, description, event_date) {
            document.getElementById('id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('event_date').value = event_date;
        }
    </script>
</body>
</html>
