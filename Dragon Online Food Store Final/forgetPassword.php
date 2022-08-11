<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
require('connect.php');
require('sendmail.php');

if(isset($_SESSION['user']['CUSTOMER_USERNAME'])){
  header('Location: /');
  exit();
}

$message="";

if (isset($_POST['submit'])) {
  $uname = $_POST['uname'];
  $email = $_POST['email'];

  $qry = "SELECT * FROM customer_reg WHERE CUSTOMER_USERNAME='$uname' AND CUSTOMER_EMAIL='$email' ";
  $send = oci_parse($conn, $qry);
  oci_execute($send);  
  $result = oci_fetch_assoc($send);

  if ($result) {
    $token = md5(RAND(2000, 4000));    

    $qry = "SELECT * FROM RESET_PASSWORD WHERE EMAIL='$email' ";
    $send = oci_parse($conn, $qry);
    oci_execute($send);  
    $result = oci_fetch_assoc($send);

    if($result){
      $qry = "UPDATE RESET_PASSWORD SET TOKEN='$token' , CREATED_AT= to_date(".date('Y-m-d').", 'YYYY/MM/DD')";
      $send = oci_parse($conn, $qry);
      oci_execute($send);  
      $result = oci_fetch_assoc($send);
    }
    else{
      $qry = "INSERT INTO RESET_PASSWORD(EMAIL, TOKEN) VALUES('$email', '$token')";
      $send = oci_parse($conn, $qry);
      oci_execute($send);      
    }

    $to = $email;
    $subject = "Reset Password";
    $msg = "Click <a href='http://localhost/assets2/resetPassword.php?email=$email&token=$token'>here</a> to reset your password.";   
    $sendMail = sendMail($to, $subject, $msg);    
    
    echo "<script> alert('Reset link has been sent.'); </script>";
  } else {
    $message = "User not found.";
  }    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DFOS - Forget Password</title>
  <link rel="stylesheet" href="assets/css/forgetPassword.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
  <link rel="stylesheet" href="assets/css/Footer-Basic.css">
  <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
  <link rel="stylesheet" href="assets/css/Projects-Horizontal.css">
  <link rel="stylesheet" href="assets/css/styles.css">
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
            <form class="d-flex input-group w-auto">
              <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
              <span class="input-group-text border-0" id="search-addon">
                <i class="fa fa-search"></i>
              </span>
            </form>
          </li>
        </ul><a class="btn btn-secondary ms-auto fa fa-sign-in" role="button" href="signin.php" style="margin: 0px;">&nbsp;Sign in</a><a class="btn btn-secondary fa fa-user" role="button" href="register.php" style="margin: 4px;">&nbsp;Register</a><a class="btn btn-secondary fa fa-shopping-cart" role="button" href="cart.php">&nbsp;Cart</a>
      </div>
    </div>
  </nav>
  <div class="wrapper">
    <div class="title">
      Forget Password
    </div>
    <form action="" method="POST">
      <div class="form">
        <input type="text" name="uname" placeholder="Username">
      </div>
      <div class="form">
        <input type="email" name="email" placeholder="Email">
      </div>
      <div class="text-center">
        <button name="submit" type="submit" class="btn btn-primary">Send Reset Link</button>
      </div>
      <br>
      <div class="text-center"> <?= $message ?>      
      </div>
    </form>
  </div>
  </div>
  <footer class="footer-basic">
    <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
    <p class="copyright">Dragon Online Food Store © 2020</p>
  </footer>
  </section>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>