<?php
require('customerSessionCheck.php');
require('connect.php');

$cart = $_SESSION['user']['cart']??[];
$pid = $_GET['id'];
$qty = $_GET['quantity']??1;

$qry = "SELECT * FROM products WHERE PRODUCT_ID='$pid'";
$send = oci_parse($conn, $qry);
oci_execute($send);
$product = oci_fetch_assoc($send);
$product += ['quantity'=>$qty];
$cart += [$pid=>$product];

$_SESSION['user']['cart'] = $cart;
header('Location:'.$_SERVER['HTTP_REFERER']);

?>