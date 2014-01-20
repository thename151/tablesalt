<?php

$title1 = "send comment";

include_once( "incs1.php" );

$cr1 = '';
$pr1 = '';

if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}

$mess3 = '<tr class="trq"><td></td><td><input type="text" name="pr1" maxlength="25" value="' . $pr1 . '"></td></tr>';
if ( $pr1 == '' )
{
	$mess3 = "";
}


$mess1 = '
<form action="sendcomment2.php"
method="POST">
<TABLE >
<tr class="trq"><td>send to</td><td><input type="text" name="nameto" maxlength="25" value="' . $cr1 . '"></td></tr>'
. $mess3 . 
'<tr class="trq"><td>comment</td><td><input type="text" name="messto" maxlength="500"></td></tr>
<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
</TABLE >
</form>
';

include( "stringz.php" );

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess1;
echo $content3blank2;
echo $footer;

?>