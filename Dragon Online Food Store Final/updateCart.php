<?php
require('customerSessionCheck.php');
require('connect.php');

$cart = $_SESSION['user']['cart']??[];
$pid = $_GET['id'];
$quantity = $_GET['quantity'];
$cart[$pid]['quantity'] = $quantity;

$_SESSION['user']['cart'] = $cart;
header('Location:'.$_SERVER['HTTP_REFERER']);

?>
