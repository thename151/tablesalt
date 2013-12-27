<?php

$title1 = "list profile's products";

include_once( "incs1.php" );

include '../funcss/listproducts.php';

$startfrom = '';
$results = '';

if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}


$mess1 = listprofilesproducts($name1, $startfrom, $results );
$mess4 = "listpproducts1.php";

include_once( "incs3.php" );

$mess2a = "";

for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
{
	$mess2a .= "<tr>";
	$mess2a .= "<td><a href='deleteproduct1.php?prd1=".$mess1[$i2][2] ."'>delete</a></td>";
	$mess2a .= '<td> <a href="product.php?
			&cr1=' . $name1 . '			
			&pr1=' . $mess1[$i2][2] . '"">' . $mess1[$i2][2] . '</a> </td>';
	$mess2a .= "<td>" . $mess1[$i2][0] . "</td>";
	$mess2a .= "<td>" . $mess1[$i2][1] . "</td>";

	$mess2a .= "<td>" . $mess1[$i2][3] . "</td>";
	$mess2a .= "</tr>";
}


$mess2 .= "<center><table border=0>" . $mess2a .  "</table></center>";
$mess2 .= "<br>" . $mess3 . "<br>";

$mess2 .= '<br><center><a href="createproduct1.php">add product</a></center><br>';

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