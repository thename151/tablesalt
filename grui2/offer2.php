<?php

$title1 = "offer";

include_once( "incs1.php" );

$amount1 = $_POST["amount1"];
$pcrea1 = $_POST["cr1"];
$product1 = $_POST["pr1"];

$amount2 = $_POST["amount2"];
$pcrea2 = $_POST["cr2"];
$product2 = $_POST["pr2"];

include( "../funcss/settrade.php" );

$mess2 = settradeb( $name1, $amount1, $pcrea1, $product1, $amount2, $pcrea2, $product2, "offer" );

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