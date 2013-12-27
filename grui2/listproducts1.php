<?php
$title1 = "list products";

include_once( "incs1.php" );

include '../funcss/listproducts.php';

$startfrom = '';
$results = '';
$cr1 = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

$mess1 = "";

#echo "qq $cr1 ww";

if( $cr1 != "")
{
	$mess1 = listproducts2($cr1, $startfrom, $results );
	$title1 = "list $cr1 products";
}
else
{
	$mess1 = listproducts( $startfrom, $results );
}

$mess4 = "listproducts1.php";

include_once( "incs3.php" );

$mess2a = "";

for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
{
//	$mess2a .= "<tr><td>" . $mess1[$i2][4] . "</td>";

	$mess2a .= '<tr><td><a href="user.php?cr1=' . $mess1[$i2][4] . '">'.$mess1[$i2][4].' </a> </td>';
	$mess2a .= '<td> <a href="product.php?
			&cr1=' . $mess1[$i2][4] . '			
			&pr1=' . $mess1[$i2][2] . '"">' . $mess1[$i2][2] . '</a> </td>';
	$mess2a .= "<td>" . $mess1[$i2][0] . "</td>";
	$mess2a .= "<td>" . $mess1[$i2][1] . "</td>";
	$mess2a .= "<td>" . $mess1[$i2][3] . "</td>";

	$mess2a .= "</tr>";
}

$mess2 .= "<center><table border=0>" . $mess2a .  "</table></center>";
$mess2 .= "<br>" . $mess3 . "<br>";

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
echo '</body></html>';



?>