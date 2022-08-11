<?php
session_start();
unset($_SESSION['trader']);
header("Location:login.php");
