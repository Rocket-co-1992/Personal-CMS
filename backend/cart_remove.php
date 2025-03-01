<?php
require 'functions.php';
require 'cart_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    removeCartItem($id);
    header('Location: cart.php');
    exit;
}
?>
