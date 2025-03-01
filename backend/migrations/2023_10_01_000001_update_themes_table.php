<?php
require '../config.php';

try {
    $pdo->exec("ALTER TABLE themes ADD COLUMN structure TEXT");
    echo "Column 'structure' added to 'themes' table successfully.";
} catch (PDOException $e) {
    echo "Error adding column: " . $e->getMessage();
}
?>
