<?php
require 'functions.php';
require 'product_functions.php';
require 'settings_functions.php';

$shop_enabled = getSetting('shop_enabled');
if (!$shop_enabled) {
    header('Location: ../frontend/index.html.twig');
    exit;
}

$products = getProducts();
$currentTheme = getCurrentTheme();

echo $twig->render('shop.html.twig', [
    'products' => $products,
    'currentTheme' => $currentTheme
]);
?>
