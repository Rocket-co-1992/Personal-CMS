<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: auth.php');
    exit;
}

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $themeName = sanitizeInput($_POST['theme_name']);
    $cssContent = $_POST['css_content'];
    $structure = $_POST['structure'];
    saveTheme($themeName, $cssContent, $structure);
    header('Location: theme_builder.php');
    exit;
}

$themes = getThemes();
$selectedTheme = isset($_GET['theme']) ? $_GET['theme'] : '';
$themeStructure = $selectedTheme ? getThemeStructure($selectedTheme) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Builder</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #theme-builder {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #theme-preview {
            width: 100%;
            height: 300px;
            border: 1px solid #ddd;
            margin-bottom: 1em;
        }
        .draggable {
            width: 100px;
            height: 100px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: move;
        }
    </style>
</head>
<body>
    <h1>Theme Builder</h1>
    <form method="post">
        <label for="theme_name">Theme Name:</label>
        <input type="text" name="theme_name" id="theme_name" value="<?php echo $selectedTheme; ?>" required>
        <br>
        <label for="css_content">CSS Content:</label>
        <textarea name="css_content" id="css_content" rows="10" cols="50" required></textarea>
        <br>
        <input type="hidden" name="structure" id="structure" value="<?php echo htmlspecialchars($themeStructure); ?>">
        <button type="submit">Save Theme</button>
    </form>
    <h2>Existing Themes</h2>
    <ul>
        <?php foreach ($themes as $theme): ?>
            <li><a href="?theme=<?php echo $theme['name']; ?>"><?php echo $theme['name']; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div id="theme-builder">
        <div id="theme-preview"><?php echo $themeStructure; ?></div>
        <div class="draggable">Header</div>
        <div class="draggable">Footer</div>
        <div class="draggable">Content</div>
    </div>
    <a href="dashboard.php">Back to Dashboard</a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $(".draggable").draggable({
                helper: "clone",
                revert: "invalid"
            });

            $("#theme-preview").droppable({
                accept: ".draggable",
                drop: function(event, ui) {
                    var element = ui.helper.clone();
                    $(this).append(element);
                }
            });

            $("form").on("submit", function() {
                var structure = $("#theme-preview").html();
                $("#structure").val(structure);
            });
        });
    </script>
</body>
</html>
