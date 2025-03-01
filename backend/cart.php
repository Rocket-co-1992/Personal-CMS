<?php
session_start();
require 'functions.php';
require 'cart_functions.php';

$session_id = session_id();
$cartItems = getCartItems($session_id);
$currentTheme = getCurrentTheme();

echo $twig->render('cart.html.twig', [
    'cartItems' => $cartItems,
    'currentTheme' => $currentTheme
]);
?>
