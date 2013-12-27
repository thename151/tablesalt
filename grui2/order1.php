<?php

$title1 = "order";

include_once( "incs1.php" );

$cr1 = "";
$pr1 = "";

$cr2 = "";
$pr2 = "";

$am1 = "";

if (isset($_GET['cr1'])) $cr1 = $_GET['cr1'];
if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];
if (isset($_GET['cr2'])) $cr2 = $_GET['cr2'];
if (isset($_GET['pr2'])) $pr2 = $_GET['pr2'];

if (isset($_GET['am1'])) $am1 = $_GET['am1'];

$mess2 = '
<form action="order2.php"
method="POST">
<TABLE >
<tr class="trq">
<td>buy</td>
<td><input type="text" name="amount1" maxlength="7" value="1"></td>
<td>' . $cr1 . '</td>
<td>' . $pr1 . '</td></tr>
		
<tr class="trq">
<td>for</td>
<td><input type="text" name="amount2" maxlength="7" value="' . $am1 . '"></td>
<td>' . $cr2 . '</td>
<td>' . $pr2 . '</td>

		
<input type="hidden" name="cr1" value="' . $cr1 . '">
<input type="hidden" name="pr1" value="' . $pr1 . '">
<input type="hidden" name="cr2" value="' . $cr2 . '">
<input type="hidden" name="pr2" value="' . $pr2 . '">
				
<td>each</td></tr>
		

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
echo $mess2;
echo $content3blank2;
echo $footer;
echo '</body></html>';


?>