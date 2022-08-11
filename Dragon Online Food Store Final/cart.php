<?php
require('customerSessionCheck.php');
require('connect.php');

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DOFS - Cart</title>
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/Projects-Horizontal.css">
    <link rel="stylesheet" href="js/script.js">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="#"><img src="Logo.png" width="60" height="60"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link  active" href="home.php">Home</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="traderRegister.php">Be a Seller</a></li>
                    <li class="nav-item">
                        <form class="d-flex input-group w-auto" action="shop.php">
                            <input name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button class="input-group-text border-0" id="search-addon">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </li>
                </ul>
                <?php if (isset($_SESSION['user']['CUSTOMER_USERNAME'])) { ?>
                    <a class="btn btn-danger ms-auto fa fa-sign-out" role="button" href="customerLogout.php" style="margin: 0px;">&nbsp;Logout</a>
                <?php } else { ?>
                    <a class="btn btn-secondary ms-auto fa fa-sign-in" role="button" href="signin.php" style="margin: 0px;">&nbsp;Sign in</a>
                <?php } ?>
                <a class="btn btn-secondary fa fa-user" role="button" href="register.php" style="margin: 4px;">&nbsp;Register</a>
                <a class="btn btn-secondary fa fa-shopping-cart" role="button" href="cart.php">&nbsp;Cart <?= $cartCount ?></a>
            </div>
        </div>
    </nav>
    <!-----cart iteam detalis-->

    <div class="small-container cart-page">
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $total = 0;
            foreach ($cart as $product_id => $product) {
                $subtotal = ($product['PRODUCT_PRICE'] * $product['quantity']);
                $total += $subtotal;
            ?>
                <tr>
                    <td>
                        <div class="cart-info">
                            <img src="<?= $product['PRODUCT_IMG1'] ?>">
                            <div>
                                <p><?= $product['PRODUCT_TITLE'] ?></p>
                                <small>Price: &pound; <?= number_format(($product['PRODUCT_PRICE']) / 100, 2) ?></small>
                                <br>
                                <button class="btn3" onclick="window.location.replace('deleteCart.php?id=<?= $product_id ?>');" id="remove"><i class="fa fa-trash"></i>Remove</button>
                            </div>
                        </div>
                    </td>
                    <td><input type="number" value="<?= $product['quantity'] ?>" data-product-id="<?= $product_id ?>" onchange="updateCart(this)" max=20 min=1></td>
                    <td>&pound; <?= number_format($subtotal / 100, 2) ?></td>
                </tr>
            <?php } ?>
        </table>

        <div class="total-price">
            <table>
                <tr>
                    <td>Total</td>
                    <td>&pound; <?= number_format($total / 100, 2) ?></td>
                </tr>
            </table>
        </div>
        <div class="button1">
            <button class="btn1" onclick="event.preventDefault();window.location.href='checkout.php?total=<?= $total ?>';">Continue to checkout</button>
        </div>
    </div>
    <footer class="footer-basic">
        <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
        <p class="copyright">Dragon Online Food Store © 2020</p>
    </footer>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        function updateCart(obj) {
            var productID = $(obj).data('productId');
            var quantity = $(obj).val();
            window.location.replace("updateCart.php?id=" + productID + "&quantity=" + quantity);
        }
    </script>
</body>

</html>