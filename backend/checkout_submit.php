<?php
require 'functions.php';
require 'order_functions.php';
require 'cart_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = sanitizeInput($_POST['customer_name']);
    $customer_email = filter_var($_POST['customer_email'], FILTER_VALIDATE_EMAIL);
    $total = sanitizeInput($_POST['total']);
    if ($customer_name && $customer_email && $total) {
        createOrder($customer_name, $customer_email, $total, 'Pending');
        $session_id = session_id();
        clearCart($session_id);
        header('Location: ../frontend/index.html.twig');
        exit;
    } else {
        die('Invalid input');
    }
}
?>
