<?php

$title1 = "delete product";

include_once( "incs1.php" );

// $prd1 = $_POST['prd1'];

$pname = $_POST["pname"];
$pass1 = $_POST["pass1"];

include( "../funcss/deleteproduct.php" );

$mess2 = deleteproduct( $name1, $pass1, $pname );

include( 'stringz.php' );

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
