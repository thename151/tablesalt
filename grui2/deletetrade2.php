<?php

$title1 = "remove trade";

include_once( "incs1.php" );

$traden = $_POST["traden"];
include( "../funcss/settrade.php" );

$mess2 = removetrade( $name1, $traden );
$mess2 = "$mess2<br><br><a href=\"listptrades1.php\">back</a>";
// $mess2 = "qwe" . $mess2 . "<a href='listptrades1.php'>back4</a>asd";

// echo $head1 . $messli . $mess2 . $back1 . $foot1;

include( 'stringz.php' );

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