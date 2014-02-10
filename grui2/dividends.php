<?php
$title1 = "read log";

include_once( "incs1.php" );

include '../funcss/divs.php';

$startfrom = '';
$results = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}

$mess1 = listdivs( $name1, $startfrom, $results );
$mess4 = "dividends.php?";

include_once( "incs3.php" );

$mess2 = $displayResults . "<br>";

$mess2a = "";

for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
{
	$var1 = $mess1[$i2][4] * 1;
	$mess2a .= "<tr><td>" . $var1 . "</td>";

	$mess2a .= '<td><a href="user.php?cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a></td>';
	$mess2a .= '<td>
	 <a href="product.php?
			&cr1=' . $mess1[$i2][2] . '			
			&pr1=' . $mess1[$i2][3] . '"">' . $mess1[$i2][3] . '</a> 
	</td>';
	$mess2a .= '<td> to each </a> </td>';

	$mess2a .= '<td><a href="user.php?cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a></td>';
	$mess2a .= '<td>
	 <a href="product.php?
			&cr1=' . $mess1[$i2][0] . '			
			&pr1=' . $mess1[$i2][1] . '"">' . $mess1[$i2][1] . '</a> 
	</td>';
	
	$mess2a .= '<td>'.$mess1[$i2][5].' </a> </td>';
	
	$mess2a .= "<td>" . $mess1[$i2][6] . "</td></tr>";
}

$mess2 .= "<table>" . $mess2a . "</table>";
$mess2 .= "<br>" . $mess3 . "<br>";

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
