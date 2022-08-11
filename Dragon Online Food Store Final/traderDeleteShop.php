<?php
require('traderSessionCheck.php');
require('connect.php');

if(isset($_GET['id'])) {
    $sid = $_GET['id'];
    $qry = "DELETE FROM shop WHERE SHOP_ID='$sid' ";
    $send = oci_parse($conn, $qry);
    oci_execute($send);

    if (oci_num_rows($send) > 0) {

        //If yes , return to calling page(stored in the server variables)
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        // print error message
        echo "Error in query: $sql. " . oci_error($send);
        exit;
    }
}else {
    header("Location:traderAddShop.php");
}




