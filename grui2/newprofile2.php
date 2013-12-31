<?php

$name3 = $_POST["namex"];
$pass1 = $_POST["pass1"];
$pass2 = $_POST["pass2"];

include( "../funcss/createprofile.php" );
$mess2 = createprofile($name3, $pass1, $pass2);

$name1 = "";
include( "stringz.php" );

echo $header1;
echo "new profile";
echo $header2;
echo $top1original;

echo $contentblank1;
echo $mess2;
echo $contentblank2;
echo $footer;

?>