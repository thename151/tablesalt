<?php

$title1 = "list profiles";

include_once( "incs1.php" );

include '../funcss/listusers.php';


$startfrom = '';
$results = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}


$mess1 = listusers2( $startfrom, $results );
$mess4 = "listprofiles.php?";
include_once( "incs3.php" );

$mess2 = $displayResults . "<br>";

for( $i2 = 1; $i2 < sizeof( $mess1 ); $i2++ )
{
	$mess2 .= '<a href="user.php?cr1=' . $mess1[$i2] . '">'.$mess1[$i2].' </a><br>';//      $mess1[ $i2 ]. "<br>";
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