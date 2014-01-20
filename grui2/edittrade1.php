<?php

$title1 = "edit trade";

include_once( "incs1.php" );
include( "../funcss/edittrade.php" );

$txno = $_GET['txno'];

$mess2 = gettrade( $name1, $txno );

$mess30 = '
<option selected value="sell">sell</option>
<option value="buy">buy</option>
';


if( $mess2[6] == "buy")
{
	$mess30 = '
  	<option value="sell">sell</option>
  	<option selected value="buy">buy</option>
	';
	$cs = $mess2[1];
	$ps = $mess2[2];
	
	$mess2[1] = $mess2[3];
	$mess2[2] = $mess2[4];
	
	$mess2[3] = $cs;
	$mess2[4] = $ps;
}

$mess3 = '
<form action="edittrade2.php"
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
		
<select name="buysell">;'.$mess30.'
  value=buy
</select>
		
</td>
<td><input type="text" name="amount1" maxlength="25" value="'.$mess2[0].'"></td>
<td><input type="text" name="cr1" maxlength="25" value="'.$mess2[1].'"</td>
<td><input type="text" name="pr1" maxlength="25" value="'.$mess2[2].'"</td><td></td></tr>


<tr class="trq">
<td>for</td>
<td><input type="text" name="amount2" maxlength="25" value="'.$mess2[5].'"</td>
<td><input type="text" name="cr2" maxlength="25" value="'.$mess2[3].'"</td>
<td><input type="text" name="pr2" maxlength="25" value="'.$mess2[4].'"</td>
<td>each</td></tr>

<input type="hidden" name="txno" value="' . $txno . '">
<tr class="trq"><td></td><td><input type="submit" value="send"></td><td></td><td></td><td></td></tr>
		

</TABLE >
</form>
';

$mess4 = "
		<br><center>
		<a href=\"edittrade3.php?tdn=$txno\">or</a>
		</center>
";
$mess3 .= $mess4;

include( "stringz.php" );

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess3;
echo $content3blank2;
echo $footer;


?>