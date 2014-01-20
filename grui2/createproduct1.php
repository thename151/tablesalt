<?php

$title1 = "create product";

include_once( "incs1.php" );

$mess1 = '
<form action="createproduct2.php"
method="POST">
<TABLE >
<tr class="trq"><td>product name</td><td><input type="text" name="pname" maxlength="25"></td></tr>
<tr class="trq"><td>details</td><td><input type="text" name="pdetail" maxlength="500"></td></tr>
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