<?php
require('connect.php');

if (isset($_GET['id'])) {

    $deleteID = $_GET['id'];
    $sql = "DELETE FROM trader_reg WHERE TRADER_REG_ID=$deleteID";

    $send = oci_parse($conn, $sql);
    oci_execute($send);

    if (oci_num_rows($send) > 0) {

        //If yes , return to calling page(stored in the server variables)
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        // print error message
        echo "Error in query: $sql. " . oci_error($send);
        exit;
    }
} else {
    header("Location:adminManageTrader.php");
}
