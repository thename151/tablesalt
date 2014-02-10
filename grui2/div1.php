<?php

$title1 = "send dividend";

include_once( "incs1.php" );

$pr1 = "";

if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];

include( "../funcss/sendproduct.php" );

//~ echo "qwe<br>";
//~ $mess2 = sendprDiv2( "userc", "usera", "usd", "5" );
//~ echo "asd<br>";


// <td colspan = "2">

$mess2 = '
<form action="div2.php"
method="POST">
<TABLE >
<tr class="trq">

<td></td>
<td>amount</td>
<td>creator</td>
<td>product</td>
</tr>

<tr class="trq">

<td></td>

<td>
to the holder of every 1
</td>

<td>'.$name1.'</td>
<td><input type="text" name="pr1" maxlength="25"value="' . $pr1 . '"</td></tr>
		
<tr class="trq">
<td>send</td>
<td><input type="text" name="am1" maxlength="25" value="1"</td>
<td><input type="text" name="cr2" maxlength="25"</td>
<td><input type="text" name="pr2" maxlength="25"</td>
</tr>
		
<tr class="trq"><td></td><td><input type="submit" value="send"></td><td></td><td></td></tr>
		
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
echo $mess2;
echo $content3blank2;
echo $footer;


?>
