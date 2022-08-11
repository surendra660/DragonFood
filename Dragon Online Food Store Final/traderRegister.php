<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
if (isset($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
  unset($_SESSION['errors']);
}

if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']);
}

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DFOS - Be a Seller</title>
  <link rel="stylesheet" href="assets/css/traderRegister.css">
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
          <li class="nav-item"><a class="nav-link active" href="traderRegister.php">Be a Seller</a></li>
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
  <div class="wrapper">
    <form method="POST" action="insertTrader.php" enctype="multipart/form-data">
      <?php
      if (isset($message)) {
        echo "<div class='text-center alert alert-" . $message['color'] . "'><b>" . $message['message'] . "</b></div><br>";
      }
      ?>
      <div class="title">
        Trader's Registration
      </div>
      <div class="form">
        <span class="error"><?php if (isset($errors['un'])) {
                              echo $errors['un'];
                            }
                            ?></span>
        <input type="text" name="uname" placeholder="Username">
        <span class="error"><?php if (isset($errors['pa'])) {
                              echo $errors['pa'];
                            }
                            ?></span>
        <input type="password" name="password" placeholder="Password">
        <span class="error"><?php if (isset($errors['fn'])) {
                              echo $errors['fn'];
                            }
                            ?></span>
        <input type="text" name="fullname" placeholder="Contact Person's Full Name">
        <span class="error"><?php if (isset($errors['e'])) {
                              echo $errors['e'];
                            }
                            ?></span>
        <input type="text" name="email" placeholder="Email">
        <span class="error"><?php if (isset($errors['pn'])) {
                              echo $errors['pn'];
                            }
                            ?></span>
        <input type="text" name="phoneNumber" placeholder="Phone No">
      </div>
      <br>
      <div class="title">
        Address
      </div>
      <div class="form">
        <span class="error"><?php if (isset($errors['s'])) {
                              echo $errors['s'];
                            }
                            ?></span>
        <input type="text" name="street" placeholder="Street Adress">
        <span class="error"><?php if (isset($errors['d'])) {
                              echo $errors['d'];
                            }
                            ?></span>

        <input type="text" name="district" placeholder="District">

      </div>
      <div class="form">
        <span class="error"><?php if (isset($errors['ct'])) {
                              echo $errors['ct'];
                            }
                            ?></span>
        <input type="text" name="city" placeholder="City">
        <span class="error"><?php if (isset($errors['p'])) {
                              echo $errors['p'];
                            }
                            ?></span>

        <input type="text" name="province" placeholder="Province">

      </div>
      <br>
      <div class="inputfield terms">
        <label class="check">
          <input type="checkbox" name="termsandcondition">
          <span class="checkmark">
            I accept the terms and conditions
          </span>
        </label>
        <span class="error"><?php if (isset($errors['t'])) {
                              echo $errors['t'];
                            }
                            ?></span>
      </div>
      <br>
      <div class="inputfield">
        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
      </div>
    </form>
  </div>
  <footer class="footer-basic">
    <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
    <p class="copyright">Dragon Online Food Store © 2020</p>
  </footer>
  </section>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>