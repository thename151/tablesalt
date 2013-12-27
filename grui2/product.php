<?php

$title1 = "product";

include_once( "incs1.php" );
include '../funcss/productf.php';

$cr1 = '';
$pr1 = '';

if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}

$mess2b = productdetail($cr1, $pr1);
$mess2 = "";

if( $mess2b[0] =="blank" )
{
	$mess2 = "blunk";
}
else
{

$title1 = "product $cr1 $pr1";
	$mess2 = $mess2b[0] . ", " . $mess2b[1] . ", " . $mess2b[2];
	$mess2 = "<b>$cr1 $pr1</b><br><br>";
	$mess2a = "<tr><td>creator</td><td><a href=\"user.php?cr1=$cr1\">$cr1</a></td></tr>";
	$mess2a .= "<tr><td>product</td><td>$pr1</td></tr>";
	$mess2a .= "<tr><td>create date</td><td>$mess2b[2]</td></tr>";
	$mess2a .= "<tr><td>details</td><td>$mess2b[1]</td></tr>";

	$mess2 .= '<table class="blue">' . $mess2a . '</table>';
	

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
			
	$mess2g = "$mess2c<br>$mess2d<br>$mess2e<br>$mess2f";
	$mess2f = "<table><tr><td>$mess2c</td><td>$mess2d</td><td>$mess2e</td><td>$mess2f</td></table>";

		
	$mess2 .= '<br>' . $mess2g;
	
}

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