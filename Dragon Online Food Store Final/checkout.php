<?php
require('customerSessionCheck.php');
require('connect.php');

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);

$qry = "SELECT * FROM timeslots";
$send = oci_parse($conn, $qry);
oci_execute($send);
oci_fetch_all($send, $slots, null, null, OCI_FETCHSTATEMENT_BY_ROW);

$total = $_GET['total'];

//Set variables for paypal form
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; 
//Test PayPal API URL
$paypal_email = 'sb-3qonb6626083@business.example.com';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DFOS - Cart</title>
  <link rel="stylesheet" href="assets/css/checkout.css">
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
            <form class="d-flex input-group w-auto">
              <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
              <span class="input-group-text border-0" id="search-addon">
                <i class="fa fa-search"></i>
              </span>
            </form>
          </li>
        </ul>
        <?php if (isset($_SESSION['user']['CUSTOMER_USERNAME'])) { ?>
          <a class="btn btn-danger ms-auto fa fa-sign-out" role="button" href="customerLogout.php" style="margin: 0px;">&nbsp;Logout</a>
        <?php } else { ?>
          <a class="btn btn-secondary ms-auto fa fa-sign-in" role="button" href="signin.php" style="margin: 0px;">&nbsp;Sign in</a>
        <?php } ?>
        <a class="btn btn-secondary fa fa-user" role="button" href="register.php" style="margin: 4px;">&nbsp;Register</a>
        <a class="btn btn-secondary fa fa-shopping-cart" role="button" href="cart.php">&nbsp;Cart <?= $cartCount ?> </a>
      </div>
    </div>
  </nav>
  <section>
  <form action="<?php echo $paypal_url; ?>" method="POST">
    <div class="wrapper text-center">
      <div class="title">
        <u>Check Out</u>
      </div>      
        <div class="form">
          <label><b>Select Timeslot:</b>
          <select class="form-select" name="custom">
            <?php foreach ($slots as $slot) { ?>
              <option value="<?= $slot['SLOT_ID'] ?>"><?= $slot['SLOT_NAME'] ?></option>
            <?php } ?>
          </select>
        </div>        
        <div class="wrapper">
          <div class="title">
            <u>Select Payment Method</u>
          </div>
          <div>
            <label><b>Total Amount: &pound; </b></label>
            <span><b><?= number_format($total/100,2) ?></b></span>
          </div>
          <br>
          <div>
            <label for="fname"><b>(Accepted Cards)</b></label>
            <div>
              <button class="btn btn-no-border"><i class="fa fa-money fa-5x"></i></button>
              <button class="btn btn-no-border"><i class="fa fa-cc-mastercard fa-4x" style="color:rgb(134, 29, 38);"></i></button>
              	<!-- Paypal business test account email id so that you can collect the payments. -->
                <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">			
                <!-- Buy Now button. -->
                <input type="hidden" name="rm" value="2">
                <input type="hidden" name="cmd" value="_xclick">			
                <!-- Details about the item that buyers will purchase. -->                
                <input type="hidden" name="item_name" value="dragonOFS">
                <input type="hidden" name="item_number" value="101">
                <input type="hidden" name="amount" value="<?= $total/100 ?>">
                <input type="hidden" name="currency_code" value="GBP">			
                <!-- URLs -->
                <input type='hidden' name='cancel_return' value='http://localhost/assets2/sandbox/cancel.php'>
                <input type='hidden' name='return' value='http://localhost/assets2/sandbox/success.php'>						
                <!-- payment button. -->              
              <button type="submit" class="btn btn-no-border"><i class="fa fa-cc-paypal fa-4x" style="color:rgb(23, 30, 117);"></i></button>
            </div>
            <br>
          </div>
        </div>     
      </div>
    </form>
    </section>
    <footer class="footer-basic">
      <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
      <p class="copyright">Dragon Online Food Store © 2020</p>
    </footer> 
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>