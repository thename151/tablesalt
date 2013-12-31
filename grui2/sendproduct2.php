<?php

$title1 = "send product";

include_once( "incs1.php" );

$pcrea = $_POST["pcrea"];
$product = $_POST["product"];
$amount1 = $_POST["amount1"];
$nameto = $_POST["nameto"];

include( "../funcss/sendproduct.php" );

$mess2 = sendproductbalance( $name1, $pcrea, $product, $amount1, $nameto, "ordinary" );

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