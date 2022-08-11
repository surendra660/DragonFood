<?php
require('customerSessionCheck.php');
require('connect.php');

$cart = $_SESSION['user']['cart']??[];
$pid = $_GET['id'];

unset($cart[$pid]);

$_SESSION['user']['cart'] = $cart;
header('Location:'.$_SERVER['HTTP_REFERER']);

?>