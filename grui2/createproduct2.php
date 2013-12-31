<?php

$title1 = "create product";

include_once( "incs1.php" );

$pname = $_POST["pname"];
$pdetail = $_POST["pdetail"];

include( "../funcss/createproduct.php" );

$mess2 = createproduct( $name1, $pname, $pdetail );

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