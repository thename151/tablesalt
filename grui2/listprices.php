<?php

$title1 = "list prices";

include_once( "incs1.php" );
include '../funcss/listtrades2.php';

$mess1 = listtrades20();
$mess2 = "";

for( $i2 = 0; $i2 < sizeof($mess1); $i2++ )
{
	$mess2 .= "<tr><td>" . $mess1[$i2][0] . "</td>";
	$mess2 .= "<td>" . $mess1[$i2][1] . "</td>";
	$mess2 .= "<td> / </td>";
	$mess2 .= "<td>" . $mess1[$i2][2] . "</td>";
	$mess2 .= "<td>" . $mess1[$i2][3] . "</td>";
	$mess2 .= '<td> <a href="offer1.php?am1=' . $mess1[$i2][4] . '
			&cr1=' . $mess1[$i2][0] . '
			&pr1=' . $mess1[$i2][1] . '
			&cr2=' . $mess1[$i2][2] . '
			&pr2=' . $mess1[$i2][3] . '"
			> ' . $mess1[$i2][4] . '</a>  </td>';
	
	$mess2 .= '<td> <a href="order1.php?am1=' . $mess1[$i2][5] . '
			&cr1=' . $mess1[$i2][0] . '			
			&pr1=' . $mess1[$i2][1] . '			
			&cr2=' . $mess1[$i2][2] . '			
			&pr2=' . $mess1[$i2][3] . '"			
			> ' . $mess1[$i2][5] . '</a>  </td></tr>';
	
// 	$mess2 .= "<td>" . $mess1[$i2][5] . "</td>
			
			
}
$th1 = '
        <tr><td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>bid</td>
        <td>ask</td></tr>';

$mess2 = '<table class="blue">' . $th1 . $mess2 . '</table>';
// echo $head1 . $messli . $mess2 . $back1 . $foot1;

// (float)number_format($mess1[$i2][3],3)



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