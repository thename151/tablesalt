<?php
include_once( "funcs.php" );
function listtrades()
{
	$result1 = myquery( "select
			type1, stock,
			creator1, product1, creator2, product2,
			price1, price2
			from sales3 where stock > 0
			order by dateTime desc" );

	$counter = 0;
	$messa = "";
		
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{	
		if( $rowa[ 0 ] == "sell" )
		{
			$messa[$counter][0] = $rowa[ 0 ];
			$messa[$counter][1] = $rowa[ 1 ];
			$messa[$counter][2] = $rowa[ 2 ];
			$messa[$counter][3] = $rowa[ 3 ];
			$messa[$counter][4] = $rowa[ 6 ];
			$messa[$counter][5] = $rowa[ 4 ];
			$messa[$counter][6] = $rowa[ 5 ];
		}
		else
		{
			$messa[$counter][0] = $rowa[ 0 ];
			$messa[$counter][1] = $rowa[ 1 ] * $rowa[ 6 ];
			$messa[$counter][2] = $rowa[ 4 ];
			$messa[$counter][3] = $rowa[ 5 ];
			$messa[$counter][4] = $rowa[ 7 ];
			$messa[$counter][5] = $rowa[ 2 ];
			$messa[$counter][6] = $rowa[ 3 ];
		}
		// $row4 = (float)$rowa[ 4 ];
		// $row5 = (float)$rowa[ 5 ];
		// if( $row4 == 0 )
		// {
			// $row4 = "-";  //	$row4 = "0";
		// }
		// if( $row5 == 0 )
		// {
			// $row5 = "-";  //  $row5 = "&#8734";
		// }
		// $messa[$counter][4] = $row4;
		// $messa[$counter][5] = $row5;
		 
		$counter = $counter + 1;
	}

	return $messa;
}


?>