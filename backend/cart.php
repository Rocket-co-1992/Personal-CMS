<?php
session_start();
require 'functions.php';
require 'cart_functions.php';
require 'settings_functions.php';

$shop_enabled = getSetting('shop_enabled');
if (!$shop_enabled) {
    header('Location: ../frontend/index.html.twig');
    exit;
}

$session_id = session_id();
$cartItems = getCartItems($session_id);
$currentTheme = getCurrentTheme();

echo $twig->render('cart.html.twig', [
    'cartItems' => $cartItems,
    'currentTheme' => $currentTheme
]);
?>
