<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['2fa'])) {
    header('Location: auth.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    if (validate2FACode($code)) {
        unset($_SESSION['2fa']);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid 2FA code';
    }
}

function validate2FACode($code) {
    // Implementar a lógica de validação do código 2FA aqui
    return $code === '123456'; // Exemplo de código estático para fins de demonstração
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
</head>
<body>
    <h1>Two-Factor Authentication</h1>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="code">2FA Code:</label>
        <input type="text" name="code" id="code" required>
        <br>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
