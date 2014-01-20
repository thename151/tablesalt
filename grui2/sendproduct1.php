<?php

$title1 = "send product";

include_once( "incs1.php" );


$cr1 = '';
$cr2 = '';
$pr1 = '';

if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
if (isset($_GET['cr2'])){ $cr2 = $_GET['cr2'];}else{$cr2 = "";}
if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}


$mess1 = '
<form action="sendproduct2.php"
method="POST">
<TABLE >

<tr class="trq"><td>amount</td><td><input type="text" name="amount1" maxlength="7"></td></tr>
<tr class="trq"><td>product creator</td><td><input type="text" name="pcrea" maxlength="25" value='.$cr1.'></td></tr>
<tr class="trq"><td>product</td><td><input type="text" name="product" maxlength="40" value='.$pr1.'></td></tr>
<tr class="trq"><td>to</td><td><input type="text" name="nameto" maxlength="25" value='.$cr2.'></td></tr>
<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
</TABLE >
</form>
';


// echo $head1 . $messli . $mess1 . $back1 . $foot1;

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