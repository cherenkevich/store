<?php
require_once("functions.php");

// берём урл и смотрим на его части
$path = $_SERVER['REQUEST_URI'];
$path = explode("/", $path);

// читаем все данные
$data = get_data();

// читаем корзину
$cart = get_cart();

// подключаем нужный темплейт исходя из частей урла

if (!$path[1]) {
    require_once("pages/index.php");
    exit;
}

if ($path[1] == 'cart') {
    require_once("pages/cart.php");
    exit;
}

if ($path[1] == 'success') {
    require_once("pages/success.php");
    exit;
}

if ($path[1] == 'checkout') {
    require_once("pages/checkout.php");
    exit;
}

if ($path[1] == 'products' && $path[2]) {
    require_once("pages/product.php");
    exit;
}

header('location: /');