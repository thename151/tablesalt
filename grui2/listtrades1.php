<?php

$title1 = "list trades";

include_once( "incs1.php" );
include '../funcss/listtrades3.php';


$mess1 = listtrades();
$mess2 = "";

for( $i2 = 0; $i2 < sizeof($mess1); $i2++ )
{
	$mess2 .= "<tr><td>" . $mess1[$i2][0] . "</td>";
	$mess2 .= "<td>" . (float)number_format($mess1[$i2][1],3) . "</td>";
	$mess2 .= "<td>" . $mess1[$i2][2] . "</td>";
	$mess2 .= "<td>" . $mess1[$i2][3] . "</td>";
	$mess2 .= '<td class="blue">for</td>';
	$mess2 .= "<td>" . (float)number_format($mess1[$i2][4],3) . "</td>";
	$mess2 .= "<td>" . $mess1[$i2][5] . "</td>";
	$mess2 .= "<td>" . $mess1[$i2][6] . "</td>";
	
	$mess2 .= "<td>each</td></tr>";
}

$mess2 = '<table class="blue">' . $mess2 . '</table>';
// echo $head1 . $messli . $mess2 . $back1 . $foot1;

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