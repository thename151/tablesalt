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



#$mess1 = readmessages( $name1, $startfrom, $results );
$mess4 = "readmessages1.php";

include_once( "incs3.php" );

for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
{
	$mess2 .= $mess1[$i2][0] . "<br>" . $mess1[$i2][1] . "<br>from : ";
	$mess2 .= '<a href="user.php?cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a>';
	$mess2 .= '<br>to : <a href="user.php?cr1=' . $mess1[$i2][3] . '">'.$mess1[$i2][3].' </a><br>';
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
echo '</body></html>';

?>