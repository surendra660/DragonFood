<?php
session_start();
require('connect.php');

$message = '';

if (isset($_POST['submit'])) {
   $username = $_POST['username'];
   $password = $_POST['password'];

   $login = "SELECT * FROM admin_login";
   $stm = oci_parse($conn, $login);
   oci_execute($stm);
   
   while ($row = oci_fetch_assoc($stm)) {
      if ($username == $row['ADMIN_USERNAME'] && $password == $row['ADMIN_PASSWORD']) {
         $_SESSION['admin'] = $row;
         header("Location:dashboard.php");
      } else {
         $login = "SELECT * FROM trader_reg";
         $stm = oci_parse($conn, $login);
         oci_execute($stm);
         while ($row = oci_fetch_assoc($stm)) {
            if ($username == $row['TRADER_USERNAME'] && $password == $row['TRADER_PASSWORD']) {               
               $_SESSION['trader'] = $row;
               header("Location:dashboardTrader.php");
            } else {
               $message = "Username and Password do not match";
            }
         }
      }
   }
   oci_close($conn);
}
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Login Page</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="assets/logincss/normalize.css">
   <link rel="stylesheet" href="assets/logincss/bootstrap.min.css">
   <link rel="stylesheet" href="assets/logincss/font-awesome.min.css">
   <link rel="stylesheet" href="assets/logincss/themify-icons.css">
   <link rel="stylesheet" href="assets/logincss/pe-icon-7-filled.css">
   <link rel="stylesheet" href="assets/logincss/flag-icon.min.css">
   <link rel="stylesheet" href="assets/logincss/cs-skin-elastic.css">
   <link rel="stylesheet" href="assets/logincss/style.css">
   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body class="bg-dark">
   <div class="sufee-login d-flex align-content-center flex-wrap">
      <div class="container">
         <div class="login-content">
            <div class="login-form mt-150">
               <form method="post">
                  <div class="form-group">
                     <label>Username</label>
                     <input type="text" name="username" class="form-control" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password" class="form-control" placeholder="Password" required>
                  </div>
                  <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
               </form>
               <div class="field_error"><?php echo $message ?></div>
            </div>
         </div>
      </div>
   </div>
   <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
   <script src="assets/js/popper.min.js" type="text/javascript"></script>
   <script src="assets/js/plugins.js" type="text/javascript"></script>
   <script src="assets/js/main.js" type="text/javascript"></script>
</body>

</html>