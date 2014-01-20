<?php

$title1 = "send message";

include_once( "incs1.php" );

$nameto = $_POST["nameto"];
$messto = $_POST["messto"];

include( "../funcss/sendmessage.php" );

$mess2 = sendmessage( $name1, $nameto, $messto );

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