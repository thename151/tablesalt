<?php

$title1 = "product";

include_once( "incs1.php" );
include '../funcss/productf.php';

$startfrom = '';
$results = '';
$cr1 = '';
$pr1 = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}

if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}

$mess2b = productdetail($cr1, $pr1);
$mess0 = "";

if( $mess2b[0] =="blank" )
{
	$mess0 = "$cr1 $pr1 not found";
}
else
{

$title1 = "product $cr1 $pr1";
	$mess0 = $mess2b[0] . ", " . $mess2b[1] . ", " . $mess2b[2];
	$mess0 = "<b>$cr1 $pr1</b><br><br>";
	$mess2a = "<tr><td>creator</td><td><a href=\"user.php?cr1=$cr1\">$cr1</a></td></tr>";
	$mess2a .= "<tr><td>product</td><td>$pr1</td></tr>";
	$mess2a .= "<tr><td>create date</td><td>$mess2b[2]</td></tr>";
	$mess2a .= "<tr><td>details</td><td>$mess2b[1]</td></tr>";

	$mess0 .= '<table class="blue">' . $mess2a . '</table>';
	

	$mess2c = '<a href="sendproduct1.php?
			cr1=' . $cr1 . '
			&pr1=' . $pr1 . '">send</a>';
	$mess2d = '<a href="settradeb3.php?am1=1
			&type1=buy
			&cr1=' . $cr1 . '
			&pr1=' . $pr1 . '"
			>buy</a>';
	$mess2e = '<a href="settradeb3.php?am1=1
			&type1=sell
			&cr1=' . $cr1 . '
			&pr1=' . $pr1 . '"
			>sell</a>';
	$mess2f = '<a href="listprices2.php?
			cr1=' . $cr1 . '
			&pr1=' . $pr1 . '"
			>prices</a>';
$mess2j = '<a href="sendcomment1.php?
			cr1=' . $cr1 . '
			&pr1=' . $pr1 . '"
			>place a comment</a>';

include '../funcss/readmessages.php';

$mess1 = readProductComments( $cr1, $pr1, $startfrom, $results );

$mess4 = "product.php?cr1=$cr1&pr1=$pr1&";

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

	$mess2g = "$mess2c<br>$mess2d<br>$mess2e<br>$mess2f";
	$mess2f = "<table><tr><td>$mess2c</td><td>$mess2d</td><td>$mess2e</td><td>$mess2f</td></table>";
		
	$mess0 .= '<br>' . $mess2g;
	$mess0 .= '<br>' . $mess2j;

	$mess0 .= "<br><br><br><b>comments : </b>";
	$mess0 .= "$displayResults<br>";

	$mess0 .= $mess2i . $mess3;
}

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