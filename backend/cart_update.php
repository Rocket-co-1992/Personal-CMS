<?php
require 'functions.php';
require 'cart_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    updateCartItem($id, $quantity);
    header('Location: cart.php');
    exit;
}
?>
