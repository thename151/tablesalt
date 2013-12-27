<?php

$title1 = "send message";

include_once( "incs1.php" );

$cr1 = '';
if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

$mess1 = '
<form action="sendmessage2.php"
method="POST">
<TABLE >
<tr class="trq"><td>send to</td><td><input type="text" name="nameto" maxlength="25" value="' . $cr1 . '"></td></tr>
<tr class="trq"><td>message</td><td><input type="text" name="messto" maxlength="500"></td></tr>
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
echo '</body></html>';

?>