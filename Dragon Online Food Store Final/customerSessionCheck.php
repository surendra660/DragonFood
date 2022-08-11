<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
if (!isset($_SESSION['user']['CUSTOMER_USERNAME'])){   
    header("Location: signin.php");
    exit();
    }

