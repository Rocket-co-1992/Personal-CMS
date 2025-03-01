<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';
require 'faq_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        deleteFaq($_POST['id']);
    } else {
        $id = $_POST['id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        if ($id) {
            updateFaq($id, $question, $answer);
        } else {
            createFaq($question, $answer);
        }
    }
    header('Location: faq.php');
    exit;
}

$faqs = getFaqs();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FAQ</title>
</head>
<body>
    <h1>Manage FAQ</h1>
    <form method="post">
        <input type="hidden" name="id" id="id">
        <label for="question">Question:</label>
        <input type="text" name="question" id="question" required>
        <br>
        <label for="answer">Answer:</label>
        <textarea name="answer" id="answer" rows="5" required></textarea>
        <br>
        <button type="submit">Save FAQ</button>
    </form>
    <h2>Existing FAQs</h2>
    <ul>
        <?php foreach ($faqs as $faq): ?>
            <li>
                <h3><?php echo $faq['question']; ?></h3>
                <p><?php echo $faq['answer']; ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
                    <button type="button" onclick="editFaq(<?php echo $faq['id']; ?>, '<?php echo $faq['question']; ?>', '<?php echo $faq['answer']; ?>')">Edit</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
    <script>
        function editFaq(id, question, answer) {
            document.getElementById('id').value = id;
            document.getElementById('question').value = question;
            document.getElementById('answer').value = answer;
        }
    </script>
</body>
</html>
