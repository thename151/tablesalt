<?php

$title1 = "delete trade";

include_once( "incs1.php" );

$trd1 = $_GET['trd1'];


$mess2 = 'delete trade ?<br>';

$yes1 = '
<form action="deletetrade2.php" method="POST">
<input type="hidden" name="traden" value="' . $trd1 . '">
<input type="submit" value="delete">
</form>
';


$no1 = '<a href="listptrades1.php?startfrom=0&results=5">don\'t delete</a>';
// $no1 = 'no';

$mess2 .= $yes1.'<br>'.$no1.'';
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