<?php

//echo "here2<br>";

if($mess1[0][0] == "okay" )
{
//	echo "here3<br>";
	$displayResults = $mess1;
	
	$endfrom = $startfrom + $results;

	if( $endfrom > $mess1[0][1] )
	{
		$endfrom = $mess1[0][1];
	}

	$startfrom1 = $startfrom + 1;
	$mess3 = "";

	if($mess1[0][1] != 0 )
	{
		$displayResults = "displaying results $startfrom1 to $endfrom of " . $mess1[0][1] . "<br>";
		$nextvar = "";
		if( $endfrom < $mess1[0][1] )
		{
			$nextvar = "next";
		}
		$mess3 = addcontrol( $startfrom, $results, $mess1[0][1], $mess4, $nextvar );
	}
}



function addcontrol( $startfrom, $results, $numrows, $adrres, $nextvar )
{
	if($startfrom >= $numrows)
	{
		$startfrom = $numrows - $results;
	}
		
	$x1 = $startfrom - $results;
	$x2 = $startfrom + $results;

	if( $x1 < 0 )
	{
		$x1 = 0;
	}
	
	if($x2 >= $numrows)
	{
		$x2 = $startfrom;
	}

	$mess1 = '<center><div id="prenex">';
	$mess1 .= '<div id="pre">';

	if( $startfrom >= 1 )
	{
		$mess1 .= "<a href='";
		$mess1 .= $adrres;
		$mess1 .= "startfrom=";
		$mess1 .= $x1;
		$mess1 .= "&results=";
		$mess1 .= $results;
		$mess1 .= "'>previous</a>";
	}
	
	$mess1 .= "</div>";
	$mess1 .= '<div id="nex">';

	if( $nextvar == "next" )
	{
		$mess1 .= "<a href='";
		$mess1 .= $adrres;
		$mess1 .= "startfrom=";
		$mess1 .= $x2;
		$mess1 .= "&results=";
		$mess1 .= $results;
		$mess1 .= "'>next</a>";
	}
	
	$mess1 .= "</div>";
	$mess1 .= "</div></center>";

	$rrr = $startfrom + $numrows;
	return $mess1;
}
?>
