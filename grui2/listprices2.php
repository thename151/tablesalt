<?php

$title1 = "list prices";

include_once( "incs1.php" );
include '../funcss/listtrades2.php';

$startfrom = '';
$results = '';
$cr1 = '';
$pr1 = '';
$cr2 = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}
if (isset($_GET['cr2'])){ $cr2 = $_GET['cr2'];}else{$cr2 = "";}

$mess1 = "";

if(( $cr1 != "") && ($pr1 != "") )
{
	$mess1 = listtrades46($startfrom, $results, $cr1, $pr1 );
	$title1 = "list $cr1 $pr1 prices";
}
else
{
	if( $cr2 != "" )
	{	
		$mess1 = listtrades64($startfrom, $results, $cr2 );
		$title1 = "list $cr2 prices";
	}	
	else
	{
		$mess1 = listtrades23($startfrom, $results);
	}
}

$mess2a = "";
$mess4 = "listprices2.php?";

include_once( "incs3.php" );

$mess2 = $displayResults . "<br>";
$th1 = '';

$sz = sizeof($mess1);
if ( $sz < 2 )
{
	$mess2a =  "no prices";
	$sz = -1;
}
else
{
	$th1 = '
        <tr><td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>bid</td>
        <td>ask</td></tr>';
}

$x1 = $startfrom;
$mess2 .= $mess1[0][0];

for( $i2 = 1; $i2 < $sz; $i2++ )
{
//	$mess2a .= "<tr><td>" . $mess1[$i2][0] . "</td>";

	$mess2a .= '<tr><td><a href="user.php?cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a> </td>';

//	$mess2a .= "<td>" . $mess1[$i2][1] . "</td>";
	$mess2a .= '<td> <a href="product.php?
			cr1=' . $mess1[$i2][0] . '			
			&pr1=' . $mess1[$i2][1] . '">' . $mess1[$i2][1] . '</a> </td>';
	$mess2a .= '<td> <a href="market.php?
			&cr1=' . $mess1[$i2][0] . '			
			&pr1=' . $mess1[$i2][1] . '			
			&cr2=' . $mess1[$i2][2] . '			
			&pr2=' . $mess1[$i2][3] . '">/</a> </td>';
//	$mess2a .= "<td>" . $mess1[$i2][2] . "</td>";
	
	$mess2a .= '<td><a href="user.php?cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a> </td>';

	
	
//	$mess2a .= "<td>" . $mess1[$i2][3] . "</td>";
	$mess2a .= '<td> <a href="product.php?
			&cr1=' . $mess1[$i2][2] . '			
			&pr1=' . $mess1[$i2][3] . '">' . $mess1[$i2][3] . '</a> </td>';


	$mess2a .= '<td> <a href="settradeb3.php?am1=' . $mess1[$i2][4] . '
			&type1=sell
			&cr1=' . $mess1[$i2][0] . '
			&pr1=' . $mess1[$i2][1] . '
			&cr2=' . $mess1[$i2][2] . '
			&pr2=' . $mess1[$i2][3] . '"
			> ' . $mess1[$i2][4] . '</a>  </td>';
	
	$mess2a .= '<td> <a href="settradeb3.php?am1=' . $mess1[$i2][5] . '
			&type1=buy
			&cr1=' . $mess1[$i2][0] . '			
			&pr1=' . $mess1[$i2][1] . '			
			&cr2=' . $mess1[$i2][2] . '			
			&pr2=' . $mess1[$i2][3] . '"			
			> ' . $mess1[$i2][5] . '</a>  </td>';
			
	$mess2a .= '</tr>';
	
// 	$mess2 .= "<td>" . $mess1[$i2][5] . "</td>
}


// $mess2 = "<table>" . $th1 . $mess2 . "</table>";


 $mess2 .= '<table class="blue">' . $th1 . $mess2a . '</table>';
$mess2 .= "<br>" . $mess3 . "<br>";
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


?>