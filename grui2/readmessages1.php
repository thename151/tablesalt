<?php

$title1 = "read messages";

include_once( "incs1.php" );

include '../funcss/readmessages.php';

$startfrom = '';
$results = '';
$cr1 = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

if( $cr1 != "" )
{
	$mess1 = readmessagesfew( $name1, $startfrom, $results, $cr1 );
	$title1 = "read $cr1 messages";
}	
else
{
	$mess1 = readmessages( $name1, $startfrom, $results );
}

$mess4 = "readmessages1.php?";

include_once( "incs3.php" );

$mess2 = $displayResults . "<br>";

for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
{	
	$type = "message";
	$product = "";
		
	if( $mess1[$i2][5] == "user" || $mess1[$i2][5] == "product" )
	{
		$type = "comment";
	}

	if( $mess1[$i2][6] != "" )
	{
		$product = '<a href="product.php?cr1=' . $mess1[$i2][2] . '&pr1=' . $mess1[$i2][6] . '">'.$mess1[$i2][6].' </a>';
	}
	

	$mess2 .= "<table><tr><td>";
	$mess2 .= $type . "</td><td>";

	$mess2 .= "from : ";
	$mess2 .= '<a href="user.php?cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a>';
	$mess2 .= "</td><td>";
	
	$mess2 .= 'to : <a href="user.php?cr1=' . $mess1[$i2][3] . '">'.$mess1[$i2][3].' </a><br>';
	$mess2 .= " $product";
	$mess2 .= "</td><td>";



	$mess2 .= $mess1[$i2][1] . "</td><td>";
	$mess2 .= $mess1[$i2][0];

	$mess2 .= "</td></tr>";
	$mess2 .= "</table>";

	$mess2 .= $mess1[$i2][4] . "<br><br>";
}

$mess2 .= "<br>" . $mess3 . "<br>";

// echo $head1 . $messli . $mess2 . $back1 . $foot1;

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

?>