<?php

$title1 = "set trade";

include_once( "incs1.php" );

$txno = $_POST["txno"];
$buysell = $_POST["buysell"];

$amount1 = $_POST["amount1"];
$pcrea1 = $_POST["cr1"];
$product1 = $_POST["pr1"];

$amount2 = $_POST["amount2"];
$pcrea2 = $_POST["cr2"];
$product2 = $_POST["pr2"];

include( "../funcss/settrade.php" );

// $mess2 = edittrade($name1, $txno, $howmany1, $crea1, $pname1, $howmany2, $crea2, $pname2)ttrade( $name1, $amount1, $pcrea1, $product1, $amount2, $pcrea2, $product2 );
$mess2 = edittrade( $amount1, $pcrea1, $product1,
 					$amount2, $pcrea2, $product2,
 					$buysell, $name1,  $txno );

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