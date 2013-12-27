<?php

include_once( "funcs.php" );

function productdetail( $cr1, $pr1 )
{
	$result1 = myquery( "select
			detail, dateTime
			from products1 where
			profileName = \"$cr1\" and productName = \"$pr1\" and
			status1 = \"okay\""
			);
	
	$messa ="";
	$messa[0] = "blank";
	
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$messa[0] = "full";
		$messa[1] = $rowa[ 0 ];
		$messa[2] = $rowa[ 1 ];
	}
	return $messa;
}

	
	