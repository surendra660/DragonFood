<?php
require('connect.php');
session_start();
$message = '';
if (isset($_POST['submit'])) {
   $username = $_POST['username'];
   $password = $_POST['password'];

   if (!empty($username) && !empty($password)) {
      $login = "SELECT * FROM customer_reg";
      $stm = oci_parse($conn, $login);
      oci_execute($stm);
      while ($row = oci_fetch_assoc($stm)) {
         if ($username == $row['CUSTOMER_USERNAME'] && $password == $row['CUSTOMER_PASSWORD']) {
            $_SESSION['username'] = $username;
            header("Location:home.php");
         } else {
            $message = "Username and Password do not match";
         }
      }
   }
   oci_close($conn);
}
?>


