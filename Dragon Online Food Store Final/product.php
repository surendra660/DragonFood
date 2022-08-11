<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
require('connect.php');

$product_id = $_GET['id'];

$sql = "SELECT * FROM PRODUCTS WHERE PRODUCT_ID = '$product_id'";
$sql2 = "SELECT * FROM PRODUCTS ORDER BY CREATED_ON";

$send = oci_parse($conn, $sql);
oci_execute($send);
$currentProduct = oci_fetch_assoc($send);

$send = oci_parse($conn, $sql2);
oci_execute($send);
oci_fetch_all($send, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DFOS - Shop</title>
  <link rel="stylesheet" href="assets/css/contact.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
  <link rel="stylesheet" href="assets/css/Footer-Basic.css">
  <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
  <link rel="stylesheet" href="assets/css/Projects-Horizontal.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/product.css">
  <link rel="stylesheet" href="assets/js/script.js">
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
  <div class="card-wrapper">
    <div class="card">
      <!-- card left -->
      <div class="product-imgs">
        <div class="img-dis">
          <div class="img-showcase">
            <img src="<?= $currentProduct['PRODUCT_IMG1'] ?>" alt="product image" width="100">
          </div>
        </div>
        <div class="img-select">
          <div class="img-item">
            <a href="#" data-id="1">
              <img src="<?= $currentProduct['PRODUCT_IMG1'] ?>" alt="product image" width="100">
            </a>
          </div>
          <div class="img-item">
            <a href="#" data-id="2">
              <img src="<?= $currentProduct['PRODUCT_IMG2'] ?>" alt="product image" width="100">
            </a>
          </div>
        </div>
      </div>
      <!-- card right -->
      <div class="product-content">
        <h2 class="product-title"><?= $currentProduct['PRODUCT_TITLE'] ?></h2>

        <div class="product-detail">
          <h2>about this item: </h2>
          <p><b><?= $currentProduct['PRODUCT_DESC'] ?></b></p>
        </div>

        <div class="product-price">
          <!-- <p class = "last-price">Old Price: <span>$257.00</span></p> if discounted then use it -->
          <p class="new-price">Price: &pound; <span><?= number_format(($currentProduct['PRODUCT_PRICE'] / 100), 2) ?></span></p>
        </div>

        <div class="product-rating">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
        <form action="addcart.php">
          <div class="purchase-info">
            <input type="hidden" name="id" value="<?= $currentProduct['PRODUCT_ID'] ?>">
            <input name="quantity" type="number" min="1" max="<?= $currentProduct['PRODUCT_QTY'] ?>" value="1">
            <button class="btn btn-danger btn-lg">Add to Cart</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <section class="projects-horizontal">
    <div class="container">
      <!-- <div class="intro">
        <h2 class="text-center">Related Items</h2>
      </div> -->
      <div class="row projects">
        <?php foreach ($products as $product) { ?>
          <div class="col-sm-6 item">
            <div class="row">
              <div class="col-md-12 col-lg-5"><a href="product.php?id=<?= $product['PRODUCT_ID'] ?>"><img class="img-fluid" src="<?= $product['PRODUCT_IMG1'] ?>"></a></div>
              <div class="col">
                <h3 class="name"><?= $product['PRODUCT_TITLE'] ?></h3>
                <p class="description"><?= $product['PRODUCT_DESC'] ?></p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
  </section>

  <footer class="footer-basic">
    <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
    <p class="copyright">Dragon Online Food Store © 2020</p>
  </footer>
  </section>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>