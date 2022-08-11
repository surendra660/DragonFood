<?php
session_start();
if (!isset($_SESSION['trader'])) {
    header("Location: login.php");
}