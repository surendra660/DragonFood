<?php
/*call the FPDF library*/
require('fpdf/fpdf.php');
require('connect.php');

/*A4 width : 219mm*/
$oid = $_GET['id'];

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$qry1 = "SELECT * 
FROM PAYMENTS WHERE ORDER_ID=$oid";
$send = oci_parse($conn, $qry1);
oci_execute($send);
$payment=oci_fetch_assoc($send);

$qry2 = "SELECT * 
FROM ORDERS 
INNER JOIN CUSTOMER_REG ON CUSTOMER_REG.CUSTOMER_REG_ID=ORDERS.CUSTOMER_REG_ID
WHERE ORDER_ID=$oid";
$send = oci_parse($conn, $qry2);
oci_execute($send);
$order=oci_fetch_assoc($send);

$qry3 = "SELECT * 
FROM ORDER_PRODUCT
INNER JOIN PRODUCTS ON PRODUCTS.PRODUCT_ID=ORDER_PRODUCT.PRODUCT_ID
WHERE ORDER_ID=$oid";
$send = oci_parse($conn, $qry3);
oci_execute($send);
oci_fetch_all($send, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);


/*set font to arial, bold, 14pt*/
$pdf->SetFont('Arial','B',20);

/*Cell(width , height , text , border , end line , [align] )*/

$pdf->Cell(71 ,10,'',0,0);
$pdf->Image('logo.png',80,10,30,30);
$pdf->Cell(59 ,10,'',0,1);

$pdf->SetFont('Arial','B',15);
$pdf->Cell(71 ,5,'DOFS',0,0);
$pdf->Cell(59 ,5,'',0,0);
$pdf->Cell(59 ,5,'Details',0,1);

$pdf->SetFont('Arial','',10);

$pdf->Cell(130 ,5,'Assembly Street',0,0);
$pdf->Cell(25 ,5,'Customer ID:',0,0);
$pdf->Cell(34 ,5,$order['CUSTOMER_REG_ID'],0,1);

$pdf->Cell(130 ,5,'Leeds',0,0);
$pdf->Cell(25 ,5,'Invoice Date:',0,0);
$pdf->Cell(34 ,5,date_format(date_create_from_format("d-M-y h.i.s.u A", $order['ORDER_DATE']), 'Y-m-d'),0,1);

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Invoice No:',0,0);
$pdf->Cell(34 ,5,$oid,0,1);

$pdf->SetFont('Arial','B',15);
$pdf->Cell(130 ,5,'Bill To:',0,0);
$pdf->Cell(59 ,5,'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(189 ,10,'',0,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(130 ,5,$order['CUSTOMER_FNAME']." ".$order['CUSTOMER_LNAME'],0,0);
$pdf->Cell(59 ,5,'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(189 ,10,'',0,1);
$pdf->SetFont('Arial','',14);

$pdf->Cell(130 ,0,$order['CUSTOMER_EMAIL'],0,0);
$pdf->Cell(59 ,5,'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(189 ,10,'',0,1);

$pdf->Cell(50 ,10,'',0,1);

$pdf->SetFont('Arial','B',10);
/*Heading Of the table*/
$pdf->Cell(10 ,6,'Sl',1,0,'C');
$pdf->Cell(100 ,6,'Description',1,0,'C');
$pdf->Cell(23 ,6,'Qty',1,0,'C');
$pdf->Cell(30 ,6,'Unit Price',1,0,'C');
// $pdf->Cell(20 ,6,'Sales Tax',1,0,'C');
$pdf->Cell(25 ,6,'Subtotal',1,1,'C');/*end of line*/
/*Heading Of the table end*/
$pdf->SetFont('Arial','',10);
$i = 1;

foreach ($products as $product){	
	$pdf->Cell(10 ,6,$i,1,0);
	$pdf->Cell(100 ,6,$product['PRODUCT_TITLE'],1,0);
	$pdf->Cell(23 ,6,$product['QUANTITY'],1,0,'R');
	$pdf->Cell(30 ,6,number_format($product['PRODUCT_PRICE']/100,2),1,0,'R');
	// $pdf->Cell(20 ,6,'100.00',1,0,'R');
	$pdf->Cell(25 ,6,number_format($product['QUANTITY']*number_format($product['PRODUCT_PRICE']/100,2),2),1,1,'R');
	$i++;
} 

$pdf->Cell(118 ,6,'',0,0);
$pdf->Cell(15 ,6,'Total',0,0);
$pdf->Cell(55 ,6,chr(163)." ".number_format($payment['AMOUNT']/100,2),1,1,'R');

$pdf->Output();

?>