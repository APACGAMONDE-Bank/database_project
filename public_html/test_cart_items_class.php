<?php
// vars for error info
require_once 'header.php';
require_once 'php_tools.php';

$_SESSION['cart_items'] = new SessionCartItems();


$_SESSION['cart_items']->addToCart('1111111111');
$_SESSION['cart_items']->addToCart('2222222222');
print_r($_SESSION['cart_items']->getCartItemsAssociativeArray());

echo '<br>';
$_SESSION['cart_items']->updateQuantity('2222222222', 4);
print_r($_SESSION['cart_items']->getCartItemsAssociativeArray());

$_SESSION['cart_items']->removeFromCart('1111111111');
echo '<br>';
print_r($_SESSION['cart_items']->getCartItemsAssociativeArray());

$_SESSION['cart_items']->addToCart('3333333333');
var_dump($_SESSION['cart_items']->getArrayOfAssociativeArraysOfCartItems());



?>