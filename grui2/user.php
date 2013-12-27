<?php

$title1 = "user";

include_once( "incs1.php" );
include '../funcss/productf.php';

$cr1 = '';

if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

//$mess2b = productdetail($cr1, $pr1);
$mess2 = "";


$title1 = "user $cr1";

$mess2 = "<b>$cr1</b><br><br>";


$mess2c = '<a href="sendproduct1.php?
			cr2=' . $cr1 . '">send to</a>';
$mess2d = '<a href="listproducts1.php?
			cr1=' . $cr1 . '"
			>products</a>';
$mess2e = '<a href="listprices2.php?
			cr2=' . $cr1 . '"
			>prices</a>';
$mess2f = '<a href="sendmessage1.php?
			cr1=' . $cr1 . '"
			>send message</a>';
$mess2g = '<a href="readmessages1.php?
			cr1=' . $cr1 . '"
			>read messages</a>';
			

$mess2 .= "$mess2c<br>$mess2d<br>$mess2e<br><br>$mess2f<br>$mess2g";
	

include( "stringz.php" );

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess2;
echo $content3blank2;
echo $footer;
echo '</body></html>';


?>