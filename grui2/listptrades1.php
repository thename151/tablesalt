<?php

$title1 = "list profile's trades";

include_once( "incs1.php" );

include '../funcss/listtrades.php';

$mess1 = listprofilestrades($name1);
$mess2 = "";
// $mess2 = "<tr><td>1</td><td>offered</td><td></td>
// 		  <td></td><td></td><td>wanted</td><td></td><td>9</td></tr>";

$sizemess = sizeof($mess1);

for( $i2 = 0; $i2 < $sizemess; $i2++ )
{
	$mess31 = 1 * $mess1[$i2][2];
	$mess32 = 1 * $mess1[$i2][3];
	$mess4 = $mess1[$i2][0];
	
	$mess2 .= "<tr><td><a href='deletetrade1.php?trd1=". $mess4 ."'>delete</a></td>";
	$mess2 .= "<td><a href='edittrade1.php?txno=". $mess1[$i2][0] ."'> ". $mess1[$i2][0] . "</a></td>";
	
	$mess2 .= "<td>" . $mess1[$i2][1] . "</td>";
	$mess2 .= "<td>$mess31</td>";

//	$mess2 .= "<td>" . $mess1[$i2][4] . "</td>";
	$mess2 .= '<td><a href="user.php?cr1=' . $mess1[$i2][4] . '">'.$mess1[$i2][4].' </a> </td>';
	
	$mess2 .= '<td> <a href="product.php?
			&cr1=' . $mess1[$i2][4] . '			
			&pr1=' . $mess1[$i2][5] . '"">' . $mess1[$i2][5] . '</a> </td>';
	$mess2 .= "<td>  for  </td>";
	$mess2 .= "<td>$mess32</td>";

//	$mess2 .= "<td>" . $mess1[$i2][6] . "</td>";
	$mess2 .= '<td><a href="user.php?cr1=' . $mess1[$i2][6] . '">'.$mess1[$i2][6].' </a> </td>';
	
	$mess2 .= '<td> <a href="product.php?
			&cr1=' . $mess1[$i2][6] . '			
			&pr1=' . $mess1[$i2][7] . '"">' . $mess1[$i2][7] . '</a> </td>';
}

if( $sizemess == 0 )
{
	$mess2 = "there are no trades";
}

// <a href="settrade1.php">add trade</a><br>



$mess2 = "<table>" . $mess2 . "</table>";
// echo $head1 . $messli . $mess2 . $back1 . $foot1;
$mess2 .= '<br><center><a href="settradeb3.php?am1=1&type1=sell&cr1=&pr1=&cr2=&pr2=">add trade</a><br></center><br>';

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