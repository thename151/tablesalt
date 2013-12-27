<?php

$title1 = "set trade";

include_once( "incs1.php" );

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
  <option value="sell">sell</option>
  <option value="buy">buy</option>
</select>
		
</td>
<td><input type="text" name="amount1" maxlength="25" value="1"></td>
<td><input type="text" name="cr1" maxlength="25"</td>
<td><input type="text" name="pr1" maxlength="25"</td><td></td></tr>
		
		
<tr class="trq">
<td>for</td>
<td><input type="text" name="amount2" maxlength="25" value="1"></td>
<td><input type="text" name="cr2" maxlength="25"</td>
<td><input type="text" name="pr2" maxlength="25"</td>
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
echo '</body></html>';


?>