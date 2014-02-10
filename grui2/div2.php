<?php

$title1 = "send dividend";

include_once( "incs1.php" );

$pr1 = '';
$cr2 = '';
$pr2 = '';
$am1 = '';

if (isset($_POST['pr1'])){ $pr1 = $_POST['pr1'];}else{$pr1 = "";}
if (isset($_POST['cr2'])){ $cr2 = $_POST['cr2'];}else{$cr2 = "";}
if (isset($_POST['pr2'])){ $pr2 = $_POST['pr2'];}else{$pr2 = "";}
if (isset($_POST['am1'])){ $am1 = $_POST['am1'];}else{$am1 = "";}

#echo "$name1, $pr1, $cr2, $pr2, $am1";

include( "../funcss/divs.php" );

$var1a = sendiv1( $name1, $pr1, $cr2, $pr2, $am1 );

$var2 = $var1a[1];

if( $var1a[0] == 'true' )
{
	$var2 .= '
	<form action="div3.php" method="POST">
	<TABLE>
	
	<input type="hidden" name="pr1" value="' . $pr1 . '">
	<input type="hidden" name="cr2" value="' . $cr2 . '">
	<input type="hidden" name="pr2" value="' . $pr2 . '">
	<input type="hidden" name="am1" value="' . $am1 . '">
	<input type="hidden" name="prevmax" value="' . $var1a[2] . '">
	
	<tr></tr><td><input type="submit" value="send"></td></tr>
	</TABLE >
	</form>
	';
}

$mess2 = "$var2";

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
