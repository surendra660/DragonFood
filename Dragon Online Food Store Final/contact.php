<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
include('connect.php');
$errors = array();
if (isset($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
  unset($_SESSION['errors']);
}

if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']);
}

if (isset($_POST['submit'])) {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $inquiry = $_POST['message'];
  $reason = $_POST['reason'];

  //fullname
  if (!empty($fullname)) {
    if (preg_match("/^[A-Za-z ]+$/", $fullname)) {
      $fullname = $fullname;
    } else {
      $errors['fn'] = "Full Name must be alphabet only.";
    }
  } else {
    $errors['fn'] = "Full Name is required";
  }

  //email
  if (!empty($email)) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email = $email;
    } else {
      $errors['e'] = "Invalid email format";
    }
  } else {
    $errors['e'] = "Email is required";
  }

  //contact number
  if (!empty($mobile)) {
    $pattern = "/^(0|[1-9][0-9]*)$/";
    if (preg_match($pattern, $mobile)) {
      if (strlen($mobile) == 10) {
        $mobile = $mobile;
      } else {
        $errors['m'] = "Moible number must be of 10 digits";
      }
    } else {
      $errors['m'] = "Mobile number must be numeric";
    }
  } else {
    $errors['m'] = "Mobile number is required";
  }

  //message
  if (!empty($inquiry)) {
    $inquiry = $inquiry;
  } else {
    $errors['i'] = "Required";
  }

  //reason
  if (!empty($reason) && $reason != "") {
    $reason = $reason;
  } else {
    $errors['r'] = "Required";
  }

  //insert
  if (count($errors) == 0) {

    $insert = 'INSERT INTO inquiry_reg (inquiry_name, inquiry_mobile, inquiry_email, inquiry_reason, inquiry_message)' .
      'VALUES (:fullname, :mobile, :email, :reason, :inquiry)';

    $send = oci_parse($conn, $insert);

    oci_bind_by_name($send, ':fullname', $fullname);
    oci_bind_by_name($send, ':mobile', $mobile);
    oci_bind_by_name($send, ':email', $email);
    oci_bind_by_name($send, ':reason', $reason);
    oci_bind_by_name($send, ':inquiry', $inquiry);

    $result = oci_execute($send);

    if (!$result) {
      $message = ['message' => "Error inserting data: " . oci_error($send)['message'], 'color' => "danger"];
    } else {
      $message = ['message' => "Inquiry registerred successfully", 'color' => "success"];
    }
    $_SESSION['message'] = $message;
  } else {
    $_SESSION['errors'] = $errors;
  }
  header('Location: contact.php');
}

$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOFS - Contact</title>
  <link rel="stylesheet" href="assets/css/Contact.css">
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
          <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
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
        <!-- <a class="btn btn-secondary ms-auto fa fa-sign-in" role="button" href="signin.php" style="margin: 0px;">&nbsp;Sign in</a> -->
        <a class="btn btn-secondary fa fa-user" role="button" href="register.php" style="margin: 4px;">&nbsp;Register</a>
        <a class="btn btn-secondary fa fa-shopping-cart" role="button" href="cart.php">&nbsp;Cart <?= $cartCount ?></a>
      </div>
    </div>
  </nav>
  <div class="wrapper">
    <div class="title">
      Contact
    </div>
    <div class="form">
      <?php
      if (isset($message)) {
        echo "<div class='text-center alert alert-" . $message['color'] . "'><b>" . $message['message'] . "</b></div><br>";
      }
      ?>
      <form class="text-center" action="" method="POST">
        <div class="error"><?php if (isset($errors['r'])) {
                              echo $errors['r'];
                            }
                            ?></div>
        <div class="inputfield">
          <label>Reason :</label>
          <select name="reason" required>
            <option value="">--Choose--</option>
            <option value="R1">REASONS 1</option>
            <option value="R2">REASONS 2</option>
            <option value="R3">REASONS 3</option>
            <option value="R4">REASONS 4</option>
          </select>
        </div>
        <span class="error"><?php if (isset($errors['fn'])) {
                              echo $errors['fn'];
                            }
                            ?></span>
        <div class="inputfield">
          <label>Full Name :</label>
          <input type="text" name="fullname" class="input" required>
        </div>
        <span class="error"><?php if (isset($errors['m'])) {
                              echo $errors['m'];
                            }
                            ?></span>
        <div class="inputfield">
          <label>Mobile :</label>
          <input type="text" name="mobile" class="input" required>
        </div>
        <span class="error"><?php if (isset($errors['e'])) {
                              echo $errors['e'];
                            }
                            ?></span>
        <div class="inputfield">
          <label>Email :</label>
          <input type="text" name="email" class="input" required>
        </div>
        <span class="error"><?php if (isset($errors['i'])) {
                              echo $errors['i'];
                            }
                            ?></span>
        <div class="inputfield">
          <label>Message :</label>
          <textarea class="textarea" name="message" required></textarea>
        </div>
        <div class="button">
          <button class="btn btn-primary " name="submit" type="submit" value="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
  <footer class="footer-basic">
    <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
    <p class="copyright">Dragon Online Food Store © 2020</p>
  </footer>
  </section>
  <!-- <script src="assets/bootstrap/js/bootstrap.min.js"></script> -->
</body>

</html>