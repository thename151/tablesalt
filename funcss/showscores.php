<?php
include( "funcs.php" );

function showscores( $name1 )
{
	include( "hilovalues.php" );
	$check1 = check_name( $name1, "name", $namelength );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	
	$result7 = myquery( "select productName from products1 where 
						 profileName = \"$name1\" and 
						 status1 = \"okay\"" );
	$mess1a = null;
	$i1 = 0;

	while( $row2 = mysqli_fetch_array($result7) )
	{
		$result9 = myquery( "select amount from scores1 where who1 = \"$name1\" and creator = \"$name1\" and product = \"$row2[0]\"" );

		$row3 = mysqli_fetch_row($result9);
		$amt2 = "";
		$amt3 = "";
		if( $row3[0] == null )
		{
			$amt2 = $hiscore;
// 			$amt2 = "unlimited";
			$amt3 = "zero";
		}
		else
		{
			$midscore = ( ($hiscore * 1000) - ($row3[0] * 1000 ) ) / 1000 ;
			$amt3 = "-" . $row3[0];
			$amt2 = $midscore;
		}

		$messa[0] = $name1;
		$messa[1] = $row2[0];
		$messa[2] = $amt2;
		$messa[3] = $amt3;
		
		$mess1a[$i1] = $messa;
		$messa = null;
		$i1++;
	}
	

	$result8 = myquery( "select creator, product, amount from scores1 where who1 = \"$name1\"" );
	while( $row = mysqli_fetch_array($result8) )
	{
		$amt = 0;
		$name4 = $row[0];
		if( $name1 != $name4 )
		{
			$messa[0] = $row[0];
			$messa[1] = $row[1];
			$messa[3] = "";
			$messa[2] = $row[2];

			$mess1a[$i1] = $messa;
			$messa = null;
			$i1++;
		}
	}
	return $mess1a;
}
?>