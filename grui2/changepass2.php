<?php

$title1 = "change password";

include_once( "incs1.php" );

$pass1 = $_POST["pass1"];
$pass2a = $_POST["pass2a"];
$pass2b = $_POST["pass2b"];

include( "../funcss/changepass.php" );

$mess1 = changepass( $name1, $pass1, $pass2a, $pass2b );

include( "stringz.php" );

echo 'things1';

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess1;
echo $content3blank2;
echo $footer;
echo '</body></html>';

?>