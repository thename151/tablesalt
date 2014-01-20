<?php

include_once( "funcs.php" );

function productdetail( $cr1, $pr1 )
{
	$result1 = myquery( "select
			detail, dateTime, status1
			from products1 where
			profileName = \"$cr1\" and productName = \"$pr1\" ");
	
	$messa ="";
	$messa[0] = "blank";
	
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		if( $rowa[2] == "removed" )
		{
			$messa[0] = "removed";
		}
		else
		{
			$messa[0] = "full";
			$messa[1] = $rowa[ 0 ];
			$messa[2] = $rowa[ 1 ];
		}
	}
	return $messa;
}

	
	
