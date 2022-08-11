<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
require('connect.php');
session_start();
$message = '';

if (isset($_SESSION['user']['CUSTOMER_USERNAME'])) {
    header('Location: home.php');
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $login = "SELECT * FROM customer_reg";
        $stm = oci_parse($conn, $login);
        oci_execute($stm);
        while ($row = oci_fetch_assoc($stm)) {
            if ($username == $row['CUSTOMER_USERNAME'] && $password == $row['CUSTOMER_PASSWORD']) {
                if ($row['STATUS'] == 0) {
                    header('Location:emailnotverified.php');
                } else {
                    $_SESSION['user'] = $row;
                    header("Location:home.php");
                }
            } else {
                $message = "Username and Password do not match";
            }
        }
    }
    oci_close($conn);
}

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DFOS - Login</title>
    <link rel="stylesheet" href="assets/css/signin.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/Projects-Horizontal.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="js/script.js">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="#"><img src="logo.png" width="60" height="60"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
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
    <div class="center">
        <div class="header">
            Login
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="Username">
            <input id="pswrd" name="password" type="password" placeholder="Password">
            <button class="form-btn" name='submit' type="submit">Sign In</button>
            <button class="form-btn" onclick="event.preventDefault(); location.href='register.php'">Register</button>
            <?php echo $message . "<br><br>" ?>
            <a href="forgetPassword.php">Forget Password?</a>
            <br>
            <br>
        </form>
        <br>
    </div>
    <footer class="footer-basic">
        <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
        <p class="copyright">Dragon Online Food Store © 2020</p>
    </footer>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>