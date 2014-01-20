<?php

$title1 = "delete product";

include_once( "incs1.php" );

$prd1 = $_GET['prd1'];


$mess2 = 'delete product ? ' . $prd1 . '<br>';

$yes1 = '
<form action="deleteproduct2.php" method="POST">
<TABLE >
<tr><td>password</td><td><input type="text" name="pass1" maxlength="25"></td></tr>
<input type="hidden" name="pname" value="' . $prd1 . '">
<tr><td></td><td><input type="submit" value="delete"></td></tr>
</TABLE >
</form>
';


$no1 = '<a href="listpproducts1.php?startfrom=0&results=5">don\'t delete</a>';
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