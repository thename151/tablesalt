<?php

$title1 = "user";

include_once( "incs1.php" );
include '../funcss/productf.php';

$startfrom = '';
$results = '';
$cr1 = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

//$mess2b = productdetail($cr1, $pr1);

$mess0 = "";

$title1 = "user $cr1";

$mess0 = "<b>$cr1</b><br><br>";


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
$mess2j = '<a href="sendcomment1.php?
			cr1=' . $cr1 . '"
			>place comment</a>';

include '../funcss/readmessages.php';

$mess1 = readUserComments( $cr1, $startfrom, $results );

$mess4 = "user.php?cr1=$cr1&";

include_once( "incs3.php" );

$mess2i = "";

for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
{
	$mess2i .= "<table><tr><td>";

	$mess2i .= "from : ";
	$mess2i .= '<a href="user.php?cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a>';
	$mess2i .= "</td><td>";
	

	$mess2i .= $mess1[$i2][1];
	$mess2i .= "</td><td>";
	$mess2i .= $mess1[$i2][0];

	$mess2i .= "</td></tr>";
	$mess2i .= "</table>";

	$mess2i .= $mess1[$i2][3] . "<br><br>";
	
	
	
}

$mess2 = $displayResults . "<br>";

$mess0 .= "$mess2c<br>$mess2d<br>$mess2e<br><br>$mess2f<br>$mess2g<br>$mess2j";
// $mess0 .= "<br><br><br><h2>comments</h2>";
// $mess0 .= "<br>$displayResults<br>$mess2i$mess3";


	$mess0 .= "<br><br><br><b>comments : </b>";
	$mess0 .= "$displayResults<br>";

	$mess0 .= $mess2i . $mess3;


include( "stringz.php" );

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess0;
echo $content3blank2;
echo $footer;


?>