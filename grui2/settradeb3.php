<?php

$title1 = "set trade";

include_once( "incs1.php" );

$cr1 = "";
$pr1 = "";

$cr2 = "";
$pr2 = "";

$am1 = "1";
$type1 = "sell";

if (isset($_GET['cr1'])) $cr1 = $_GET['cr1'];
if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];
if (isset($_GET['cr2'])) $cr2 = $_GET['cr2'];
if (isset($_GET['pr2'])) $pr2 = $_GET['pr2'];

if (isset($_GET['am1'])) $am1 = $_GET['am1'];
if (isset($_GET['type1'])) $type1 = $_GET['type1'];

$selected1 = "";
$selected2 = "";

if( $type1 == "buy" )
{
	$selected1 = "selected";
}
else
{
	$selected2 = "selected";
}

$mess2 = '
<form action="settradeb2.php"
method="POST">
<TABLE >
<tr class="trq">

<td></td>
<td>amount</td>
<td>creator</td>
<td>product</td><td></td>
</tr>
		
<tr class="trq">
<td>
		
<select name="buysell">
  <option value="sell" '. $selected2 .'>sell</option>
  <option value="buy" '. $selected1 .'>buy</option>
</select>
		
</td>
<td><input type="text" name="amount1" maxlength="25" value="1"></td>
<td><input type="text" name="cr1" maxlength="25" value="' . $cr1 . '"</td>
<td><input type="text" name="pr1" maxlength="25"value="' . $pr1 . '"</td><td></td></tr>
		
		
<tr class="trq">
<td>for</td>
<td><input type="text" name="amount2" maxlength="25" value="' . $am1 . '"></td>
<td><input type="text" name="cr2" maxlength="25"value="' . $cr2 . '"</td>
<td><input type="text" name="pr2" maxlength="25"value="' . $pr2 . '"</td>
<td>each</td></tr>
		
<tr class="trq"><td></td><td><input type="submit" value="send"></td><td></td><td></td><td></td></tr>
		

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