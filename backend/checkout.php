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
$total = array_reduce($cartItems, function($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0);
$currentTheme = getCurrentTheme();

echo $twig->render('checkout.html.twig', [
    'total' => $total,
    'currentTheme' => $currentTheme
]);
?>
