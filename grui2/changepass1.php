<?php

$title1 = "change password";

include_once( "incs1.php" );

$mess1 = '
<form action="changepass2.php"
method="POST">
<TABLE >
<tr class="trq"><td>password</td><td><input type="text" name="pass1" maxlength="25"></td></tr>
<tr class="trq"><td>new pass</td><td><input type="text" name="pass2a" maxlength="25"></td></tr>
<tr class="trq"><td>new pass 2</td><td><input type="text" name="pass2b" maxlength="25"></td></tr>
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
echo '</body></html>';

?>