<?php

$title1 = "show scores";

include_once( "incs1.php" );

include '../funcss/showscores.php';

$mess1 = showscores($name1);
$mess2 = "";

for( $i2 = 0; $i2 < sizeof($mess1); $i2++ )
{
#	$mess2 .= $mess1[$i2][0] . "~" . $mess1[$i2][1] . ", " . $mess1[$i2][2] . "<br>";
	
#	"$mess1[$i2][0]~$mess1[$i2][1],"
	
#	$mess2 .= "<td></td><td></td><td></td>";
	$mess3f = "";
	$mess2f = "";
	
		// echo $mess1[$i2][1] ."  " . $mess1[$i2][3]. " <br>";
	if( $mess1[$i2][3] < 0 )
	{
		$mess3f = (float)$mess1[$i2][3];
	} 
	if( $mess1[$i2][2] != 0 )
	{
		$mess2f = (float)$mess1[$i2][2];
	}
	if( $mess1[$i2][3] == "zero" )
	{
		$mess3f = "0";
	}

	$mess2 .= '<tr><td><a href="user.php?cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a> </td>';
	$mess2 .= '<td> <a href="product.php?
			&cr1=' . $mess1[$i2][0] . '			
			&pr1=' . $mess1[$i2][1] . '"">' . $mess1[$i2][1] . '</a> </td>';
	$mess2 .= "<td>" . $mess2f . "</td>";
	$mess2 .= "<td><center>" . $mess3f . "</center></td></tr>";
	
}
$mess2 = "<center><table>" . $mess2 . "</table></center>";

// echo $head1 . $messli . $mess2 . $back1 . $foot1;

if( sizeof($mess1)== 0 )
{
	$mess2 = "no score";
}
else 
{
	$mess2 = "<center><table>" . $mess2 . "</table></center>";
}


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