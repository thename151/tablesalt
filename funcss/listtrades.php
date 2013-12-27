<?php
include_once( "funcs.php" );

function listtrades()
{
	$result7 = myquery( "select
 	amount1,
 	creator1,product1,creator2,product2,
 	price1,  price2,  user,    type1
			from sales3 order by product1" );
	$mess1 = null;
	$i1 = 0;

	while( $lst = mysqli_fetch_array( $result7 ) )
	{
		$name1 = $lst[ 7 ];
		$crea1 = $lst[ 1 ];
		$pname1 = $lst[ 2 ];
		if( $lst[ 8 ] == "sell")
		{
			$amount = $lst[ 0 ];
			// $amt2 = showhowmuch( $name1, $crea1, $pname1, $amount );
			// $amt3 = $amt2 * $lst[5];
		}
		if( $lst[ 8 ] == "buy")
		{
			$amount = $lst[ 0 ] * $lst[ 6 ];
			// $amt2 = showhowmuch( $name1, $crea1, $pname1, $amount );
			// $amt3 = $amt2 * $lst[5];
		}

		$amt2 = showhowmuch( $name1, $crea1, $pname1, $amount );
// 		echo "$amt2, $name1<br>";
		$amt3 = $amt2 * $lst[5];
#		$amt4 = 1 / $lst[7];
		
		if( $amt2 != 0 )
		{
#			$messa[0] = $lst[ 1 ];
			$messa[0] = (float)$amt2;
			$messa[1] = $lst[1];
			$messa[2] = $lst[2];
#			$messa[3] = (float)$lst[4];
			$messa[3] = (float)$amt3;
			$messa[4] = $lst[3];
			$messa[5] = $lst[4];
			
			$messa[6] = (float)$lst[5];
			$messa[7] = (float)$lst[6];
				
			$mess1 [$i1] = $messa;
			$messa = null;
			$i1++;
		}
	}
	return $mess1;
}


function showhowmuch( $name1, $crea1, $pname1, $amount )
{
	$result2 = myquery( "select amount from scores1 where who1 = \"$name1\" and creator = \"$crea1\" and product =\"$pname1\"" );
	$row = mysqli_fetch_row($result2);
	if( $row[ 0 ] != null )
	{
		if ( $name1 == $crea1 )
		{
			include( "hilovalues.php" );
			$availbl = $hiscore - $row[0];
			if( $availbl > $amount )
			{
				return $amount;
			}
			return $availbl;
		}
		
		if( $row[0] > $amount )
		{
// 			echo "<br>he2re . $row[0] . $amount<br>";
			return $amount;
		}
		else
		{
// 			echo "<br>he3re . $row[0] . $amount<br>";
			return $row[0];
		}
	}
	if( $name1 == $crea1 )
	{
		return $amount;
	}
//  	echo "he $name1 re<br>";
	return 0;
}


function listprofilestrades( $name1 )
{
	$result7 = myquery( "select 
			uniqueX, amount1, type1,
			creator1,product1, creator2,product2,
			price1,price2
			from sales3 where user = \"$name1\"" );
	$mess1 = null;
	$i1 = 0;

	while( $lst = mysqli_fetch_array( $result7 ) )
	{
		$messa[0] = $lst[0];
		$messa[1] = $lst[2];
		$messa[2] = $lst[1];
		
		if( $lst[2] == "sell" )
		{
			$messa[4] = $lst[3];
			$messa[5] = $lst[4];
			
			$messa[6] = $lst[5];
			$messa[7] = $lst[6];

			$messa[3] = $lst[7];
		}

		if( $lst[2] == "buy" )
		{
			$messa[4] = $lst[5];
			$messa[5] = $lst[6];
			
			$messa[6] = $lst[3];
			$messa[7] = $lst[4];
			
			$messa[3] = $lst[8];
		}

		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}

?>