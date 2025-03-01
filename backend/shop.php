<?php
require 'functions.php';
require 'product_functions.php';

$products = getProducts();
$currentTheme = getCurrentTheme();

echo $twig->render('shop.html.twig', [
    'products' => $products,
    'currentTheme' => $currentTheme
]);
?>
