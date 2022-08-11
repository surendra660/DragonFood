<?php $conn = oci_connect('admin', 'Ujjwal!123', '//localhost/xe');
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
} else {
   //print "hello";
}
