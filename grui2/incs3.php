<?php

$endfrom = $startfrom + $results;
if( $endfrom > $mess1[0] )
{
	$endfrom = $mess1[0];
}

$startfrom1 = $startfrom + 1;
$mess3 = "";

$mess2 = "there are no resullts";

if($mess1[0] != 0 )
{
	$mess2 = "displaying results $startfrom1 to $endfrom of " . $mess1[0] . "<br>";
	$mess3 = addcontrol( $startfrom, $results, $mess1[0], $mess4 );
}
//$mess2 .= "<br>" . $mess3 . "<br><br>";
$mess2 .= "<br>";



function addcontrol( $startfrom, $results, $numrows, $adrres )
{
	if($startfrom >= $numrows)
	{
		$startfrom = $numrows - $results;
	}
		
	$mess2 = $startfrom - $results;
	$mess3 = $startfrom + $results;

	if( $mess2 < 0 )
	{
		$mess2 = 0;
	}
	
	if($mess3 >= $numrows)
	{
		$mess3 = $startfrom;
	}

	$mess1 = "<a href='";
	$mess1 .= $adrres;
	$mess1 .= "?startfrom=";
	$mess1 .= $mess2;
	$mess1 .= "&results=";
	$mess1 .= $results;
	$mess1 .= "'>previous</a>";

	$mess1 .= " ";

	$mess1 .= "<a href='";
	$mess1 .= $adrres;
	$mess1 .= "?startfrom=";
	$mess1 .= $mess3;
	$mess1 .= "&results=";
	$mess1 .= $results;
	$mess1 .= "'>next</a>";

	return $mess1;
}
?>