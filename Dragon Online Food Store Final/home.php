<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
require('connect.php');

$qry = "SELECT * FROM PRODUCTS";
$send = oci_parse($conn, $qry);
oci_execute($send);
oci_fetch_all($send, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Dragon Online Food Store</title>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/fonts/ionicons.min.css">
	<link rel="stylesheet" href="assets/css/Footer-Basic.css">
	<link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
	<link rel="stylesheet" href="assets/css/Projects-Horizontal.css">
	<link rel="stylesheet" href="assets/css/styles1.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">

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
				<a class="btn btn-secondary ms-auto fas fa-sign-in-alt" role="button" href="login.php" style="margin: 0px;">&nbsp;Trader</a>
				<?php if ((isset($_SESSION['user']['CUSTOMER_USERNAME'])) && isset($_SESSION['user']['STATUS']) == 1) { ?>
					<a class="btn btn-danger ms-auto fas fa-sign-out-alt" role="button" href="customerLogout.php" style="margin: 4px;">&nbsp;Logout</a>
				<?php } else { ?>
					<a class="btn btn-secondary ms-auto fas fa-sign-in-alt" role="button" href="signin.php" style="margin: 4px;">&nbsp;Sign in</a>
				<?php } ?>
				<a class="btn btn-secondary fa fa-user" role="button" href="register.php" style="margin: 4px;">&nbsp;Register</a>
				<a class="btn btn-secondary fa fa-shopping-cart" role="button" href="cart.php" style="margin: 4px;">&nbsp;Cart <?= $cartCount ?></a>
			</div>
		</div>
	</nav>
	<!-- vertical menu start-->
	<div class="section-2">
		<div class="row">
			<div class="col-md-3">
				<div class="header-bottom blue-bg">
					<div class="main_container">
						<div class="container_wrapper">
							<div class="menu_wrapper">
								<div class="vertical_menu">
									<span>
										Categories
										<span id="cat_down_arrow"><i class="fa fa-angle-down"></i></span>
									</span>
									<nav>
										<ul class="vertical_menu_list menu-hidden">
											<li><a href="shop.php?category=1&min=&max=">Bakery</a></li>
											<li><a href="shop.php?category=2&min=&max=">Butcher</a></li>
											<li><a href="shop.php?category=3&min=&max=">Delicatessen</a></li>
											<li><a href="shop.php?category=4&min=&max=">Fishmonger</a></li>
											<li><a href="shop.php?category=5&min=&max=">Greengrocer</a></li>
											<li><a href="shop.php">All Products</a></li>
											<li><a href="#trending">Trending Products</a></li>
										</ul>
									</nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 d-none d-md-block">
				<div class="slidershow-container">
					<div class="slider_image">
						<img src="assets/img/55.jpg">
					</div>
					<div class="slider_image_next">
						<img>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!---featured sectiion strar-->
	<br id="trending">
	<br>
	<center style="margin-bottom: 50px; font-size: 20px;">T R E N D I N G</center>
	<section class="carousel">
		<div class="carousel__container">
			<?php $i = 0;
			foreach ($products as $product) {
				if ($i == 8) {
					break;
				}
				$i++; ?>
				<div class="carousel-item">
					<img class="carousel-item__img" src="<?= $product['PRODUCT_IMG1'] ?>">
					<div class="panel2">
						<a href="addcart.php?id=<?= $product['PRODUCT_ID'] ?>" class="fas fa-shopping-cart"></a>
					</div>
					<div class="info">
						<a>
							<h3><?= $product['PRODUCT_TITLE'] ?></h3>
						</a>
						<div class="stars">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
						</div>
						<strong class="price"><span class="mrp">&pound; <?= number_format(($product['PRODUCT_PRICE']) / 100, 2) ?></span></strong>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
	<div class="container about py-5">
		<div class="text-center">
			<h1>ABOUT US..</h1>
			<br><br>
			<p class="text-center">
				Dragon Online Food Store is a platform for customers to buy their desired food products from multiple traders.<br>			
				We hope to bring as much as fresh goods for our customer since the food quality is the utmost priority for us.<br>			
				Being based on Leeds, we want to help the local traders to sell their products.
			</p>
		</div>
		<a href="#">Read More<a>
	</div>
	<footer class="footer p-5">
		<div class="container footer-container">
			<div class="row">
				<div class="footer-col">
					<h4>company</h4>
					<ul class="footer-ul">
						<li><a href="#">about us</a></li>
						<li><a href="#">our services</a></li>
						<li><a href="#">privacy policy</a></li>
						<li><a href="#">affiliate program</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h4>get help</h4>
					<ul class="footer-ul">
						<li><a href="#">FAQ</a></li>
						<li><a href="#">shipping</a></li>
						<li><a href="#">returns</a></li>
						<li><a href="#">order status</a></li>
						<li><a href="#">payment options</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h4>online shop</h4>
					<ul class="footer-ul">
						<li><a href="#">watch</a></li>
						<li><a href="#">bag</a></li>
						<li><a href="#">shoes</a></li>
						<li><a href="#">dress</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h4>follow us</h4>
					<div class="social-links">
						<a href="#"><i class="fab fa-facebook-f"></i></a>
						<a href="#"><i class="fab fa-twitter"></i></a>
						<a href="#"><i class="fab fa-instagram"></i></a>
						<a href="#"><i class="fab fa-linkedin-in"></i></a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<footer class="footer-basic">
		<div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
		<p class="copyright">Dragon Online Food Store © 2020</p>
	</footer>
	</section>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>