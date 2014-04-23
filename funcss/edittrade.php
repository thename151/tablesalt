<?php
include( "funcs.php" );

function gettrade( $name1, $txno )
{
	$result7 = myquery( "select
			amount1,
			creator1, product1,
			creator2, product2,
			price1, price2, type1, keeptrade
			from sales3 where user = \"$name1\" and uniqueX = \"$txno\"" );
	
	$messa = null;

	while( $lst = mysqli_fetch_array( $result7 ) )
	{
		$messa[0] = $lst[0];
		$messa[1] = $lst[1];
		$messa[2] = $lst[2];
		$messa[3] = $lst[3];
		$messa[4] = $lst[4];
		$messa[6] = $lst[7];
		$messa[7] = $lst[8];
		
		$messa[5] = " $lst[5] sdgdg";
	
		if( $lst[7] == "sell" )
		{
			$messa[5] = $lst[5];
		}
		if( $lst[7] == "buy" )
		{
			$messa[5] = $lst[6];
		}
	}
	
	return $messa;
}
