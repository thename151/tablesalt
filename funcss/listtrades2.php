<?php
include_once( "funcs.php" );

function listdep2( $cr1, $pr1, $cr2, $pr2, $type )
{	
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr2 );if ($check1 != "okay" ){ return $check1;}
	
	$messa[0][0] = "okay";
	$messa[0][1] = 1;

	$q3 = myquery( "select
	divisible 
	from products1
	where profileName = \"$cr2\" and productName = \"$pr2\" " );
	$row4 = mysqli_fetch_row( $q3 );
	$divisible = $row4[0];
	if ( $divisible == 0 )
	{
		$messa[0][1] = 0;
	}
	
	$messa[1] = listdep( $cr1, $pr1, $cr2, $pr2, 1 );
	$messa[2] = listdep( $cr2, $pr2, $cr1, $pr1, 2 );
	
	return $messa;
}

function listdep( $cr1, $pr1, $cr2, $pr2, $type )
{
	$messa =null;
	$price = "price1";
	if( $type == 1 )
	{
		$price = "price2";
	}
	$result1 = myquery( "select
			stock, $price
			from salesactive2 where
			creator1 = \"$cr2\" and product1 = \"$pr2\" and
			creator2 = \"$cr1\" and product2 = \"$pr1\" and
			stock > 0
			order by price1"
			);

	$counter = 0;
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$messa[$counter][0] = $rowa[ 0 ];
		$messa[$counter][1] = $rowa[ 1 ];
#		echo "$counter : " . $messa[$counter][0] . " : " . $messa[$counter][1]. "<br>";
		$counter = $counter + 1;
	}
	
	return $messa;
}


function listtrades23( $startfrom, $results )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result1 = myquery( "select
			pvc1, pvp1, pvc2, pvp2, 
			price1, price2
			from pv5 
			order by  pvp2, pvc2, pvp1, pvc1 
			limit $startfrom, $results 
			" );

	$result5 = myquery( "select pvc1 from pv5" );

	$numrows = mysqli_num_rows( $result5 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$counter = 1;
	$messa[0][0] = "okay";
	$messa[0][1] = $numrows;

	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$messa[$counter][0] = $rowa[ 0 ];
		$messa[$counter][1] = $rowa[ 1 ];
		$messa[$counter][2] = $rowa[ 2 ];
		$messa[$counter][3] = $rowa[ 3 ];

		$row4 = (float)$rowa[ 4 ];
		$row5 = (float)$rowa[ 5 ];
		if( $row4 == 0 )
		{
			$row4 = "-";  //	$row4 = "0";
		}
		if( $row5 == 0 )
		{
			$row5 = "-";  //  $row5 = "&#8734";
		}
		$messa[$counter][4] = $row4;
		$messa[$counter][5] = $row5;

		$messa[$counter][6] = 1;
		
		$q3 = myquery( "select
		divisible 
		from products1
		where profileName = \"$rowa[2]\" and productName = \"$rowa[3]\" " );
		$row4 = mysqli_fetch_row( $q3 );
		$divisible = $row4[0];
		if ( $divisible == 0 )
		{
			$messa[$counter][6] = 0;
		}

		$counter = $counter + 1;
	}

	return $messa;
}


function listtrades46( $startfrom, $results, $cr1, $pr1 )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}

	$result1 = myquery( "select
			pvc1, pvp1, pvc2, pvp2, price1, price2
			from pv5 where
			pvc1 = \"$cr1\" and pvp1 = \"$pr1\" or
			pvc2 = \"$cr1\" and pvp2 = \"$pr1\"
			order by  pvp2, pvc2, pvp1, pvc1
			limit $startfrom, $results" );

	$result5 = myquery( "select pvc1 from pv5 where
						pvc1 = \"$cr1\" and pvp1 = \"$pr1\" or
						pvc2 = \"$cr1\" and pvp2 = \"$pr1\"
					" );

	$numrows = mysqli_num_rows( $result5 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$counter = 1;
	$messa[0][0] = "okay";
	$messa[0][1] = $numrows;

	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$messa[$counter][0] = $rowa[ 0 ];
		$messa[$counter][1] = $rowa[ 1 ];
		$messa[$counter][2] = $rowa[ 2 ];
		$messa[$counter][3] = $rowa[ 3 ];
		$row4 = (float)$rowa[ 4 ];
		$row5 = (float)$rowa[ 5 ];
		if( $row4 == 0 )
		{
			$row4 = "-";  //	$row4 = "0";
		}
		if( $row5 == 0 )
		{
			$row5 = "-";  //  $row5 = "&#8734";
		}
		$messa[$counter][4] = $row4;
		$messa[$counter][5] = $row5;

		$messa[$counter][6] = 1;
		
		$q3 = myquery( "select
		divisible 
		from products1
		where profileName = \"$rowa[2]\" and productName = \"$rowa[3]\" " );
		$row4 = mysqli_fetch_row( $q3 );
		$divisible = $row4[0];
		if ( $divisible == 0 )
		{
			$messa[$counter][6] = 0;
		}

		 
		$counter = $counter + 1;
	}

	return $messa;
}

function listtrades64( $startfrom, $results, $cr2 )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}

	$result1 = myquery( "select
			pvc1, pvp1, pvc2, pvp2, price1, price2
			from pv5 where
			pvc1 = \"$cr2\" or
			pvc2 = \"$cr2\"
			order by  pvp2, pvc2, pvp1, pvc1
			limit $startfrom, $results" );

	$result5 = myquery( "select pvc1 from pv5
						 where pvc1 = \"$cr2\" or pvc2 = \"$cr2\"" );

	$numrows = mysqli_num_rows( $result5 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$counter = 1;
	$messa[0][0] = "okay";
	$messa[0][1] = $numrows;

	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$messa[$counter][0] = $rowa[ 0 ];
		$messa[$counter][1] = $rowa[ 1 ];
		$messa[$counter][2] = $rowa[ 2 ];
		$messa[$counter][3] = $rowa[ 3 ];
		$row4 = (float)$rowa[ 4 ];
		$row5 = (float)$rowa[ 5 ];
		if( $row4 == 0 )
		{
			$row4 = "-";  //	$row4 = "0";
		}
		if( $row5 == 0 )
		{
			$row5 = "-";  //  $row5 = "&#8734";
		}
		$messa[$counter][4] = $row4;
		$messa[$counter][5] = $row5;

		$messa[$counter][6] = 1;
		
		$q3 = myquery( "select
		divisible 
		from products1
		where profileName = \"$rowa[2]\" and productName = \"$rowa[3]\" " );
		$row4 = mysqli_fetch_row( $q3 );
		$divisible = $row4[0];
		if ( $divisible == 0 )
		{
			$messa[$counter][6] = 0;
		}

		 
		$counter = $counter + 1;
	}

	return $messa;
}

/*

function listtrades22()
{
	$result1 = myquery( "select
			pvc1, pvp1, pvc2, pvp2, price1, price2
			from pv5" );

	$counter = 0;
	$messa = "";
		
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$messa[$counter][0] = $rowa[ 0 ];
		$messa[$counter][1] = $rowa[ 1 ];
		$messa[$counter][2] = $rowa[ 2 ];
		$messa[$counter][3] = $rowa[ 3 ];
		$row4 = (float)$rowa[ 4 ];
		$row5 = (float)$rowa[ 5 ];
		if( $row4 == 0 )
		{
			$row4 = "-";  //	$row4 = "0";
		}
		if( $row5 == 0 )
		{
			$row5 = "-";  //  $row5 = "&#8734";
		}
		$messa[$counter][4] = $row4;
		$messa[$counter][5] = $row5;
		 
		$counter = $counter + 1;
	}

	return $messa;
}

function listtrades20()
{

// list1 = select product1, product2 from sales
	$result1 = myquery( "select
			creator1,product1,creator2,product2
			from sales3" );

// while ( list1 )

	$lengthlist = 0;
	$listpairsp1 = "";
	$listpairsp2 = "";
	$listpairsc1 = "";
	$listpairsc2 = "";
	
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		$done = false;
		$counter = 0;
		
		while ( ( $counter < $lengthlist ) && ( $done == false ) )
		{
			if( $listpairsp1[$counter] == $rowa[1] && 
				$listpairsp2[$counter] == $rowa[3] && 
				$listpairsc1[$counter] == $rowa[0] && 
				$listpairsc2[$counter] == $rowa[2] )
			{
				// echo "pair $listpairsp1[$counter] == $rowa[1] && $listpairsp2[$counter] == $rowa[3]<br>";
			//  pair already on the list
				$done = true;
			}
			$counter = $counter + 1;
	    }
		if( $done == false )
		{
			//add pair product1/product2 to the list
			$listpairsp1[ $lengthlist ] = $rowa[1];
			$listpairsp2[ $lengthlist ] = $rowa[3];
			$listpairsc1[ $lengthlist ] = $rowa[0];
			$listpairsc2[ $lengthlist ] = $rowa[2];
			$lengthlist = $lengthlist + 1;
		}

		$done = false;
		$counter = 0;
		
		while ( ( $counter < $lengthlist ) && ( $done == false ) )
		{
			if( $listpairsp1[$counter] == $rowa[3] && 
				$listpairsp2[$counter] == $rowa[1] &&
				$listpairsc1[$counter] == $rowa[2] && 
				$listpairsc2[$counter] == $rowa[0] )
			{
				// echo "pair $listpairsp1[$counter] == $rowa[1] && $listpairsp2[$counter] == $rowa[3]<br>";
			//  pair already on the list
				$done = true;
			}
			$counter = $counter + 1;
	    }
		if( $done == false )
		{
			//add pair product1/product2 to the list
			$listpairsp1[ $lengthlist ] = $rowa[3];
			$listpairsp2[ $lengthlist ] = $rowa[1];
			$listpairsc1[ $lengthlist ] = $rowa[2];
			$listpairsc2[ $lengthlist ] = $rowa[0];
			$lengthlist = $lengthlist + 1;
		}
	}
	
	$counter = 0;
	$listpairsa = "";
	$listpairsb = "";
	$messa = "";
	while ( $counter < $lengthlist )
	{
		$listpairsb[$counter] = 
		findhib( $listpairsc1[ $counter ], $listpairsp1[ $counter ], 
			 	 $listpairsc2[ $counter ], $listpairsp2[ $counter ] );
		$listpairsa[$counter] = 
		findloa( $listpairsc1[ $counter ], $listpairsp1[ $counter ], 
			 	 $listpairsc2[ $counter ], $listpairsp2[ $counter ] );

//		echo $listpairsc1[ $counter ] ."  " . $listpairsp1[ $counter ] . " / " . 
//			 $listpairsc2[ $counter ] ."  " . $listpairsp2[ $counter ] . "   " .
//			 $listpairsb[ $counter ] ."  " . $listpairsa[ $counter ] . "<br>";

		$messa[$counter][0] = $listpairsc1[ $counter ];
		$messa[$counter][1] = $listpairsp1[ $counter ];
		$messa[$counter][2] = $listpairsc2[ $counter ];
		$messa[$counter][3] = $listpairsp2[ $counter ];
		$messa[$counter][4] = $listpairsb[ $counter ];
		$messa[$counter][5] = $listpairsa[ $counter ];
		 
		$counter = $counter + 1;
	}
	return $messa;
}


*/

function findhib( $cr1, $pr1, $cr2, $pr2 )
{
	$result1 = myquery( "select
						 price1,price2
						 from sales3 where 
						 creator1 = \"$cr2\" and product1 = \"$pr2\" and
						 creator2 = \"$cr1\" and product2 = \"$pr1\"
						 order by price1" );

	$rowa = mysqli_fetch_array( $result1 );
	if( $rowa[ 1 ] == null )
	{
		return "-";
	}
	else
	{
		return 1 * $rowa[1];
	}
}

function findloa( $cr1, $pr1, $cr2, $pr2 )
{
	$result1 = myquery( "select
						 price1,price2
						 from sales3 where 
						 creator1 = \"$cr1\" and product1 = \"$pr1\" and
						 creator2 = \"$cr2\" and product2 = \"$pr2\"
						 order by price1" );

	$rowa = mysqli_fetch_array( $result1 );
	if( $rowa[ 0 ] == null )
	{
		return "-";
	}
	else
	{
		return 1 * $rowa[0];
	}
}


function listtrades()
{
	$result7 = myquery( "select
			amount1,creator1,product1,amount2,creator2,product2,price1,price2,user
			from sales2 order by product1" );
	$mess1 = null;
	$i1 = 0;

	while( $lst = mysqli_fetch_array( $result7 ) )
	{
		$name1 = $lst[ 8 ];
		$crea1 = $lst[ 1 ];
		$pname1 = $lst[ 2 ];
		$amount = $lst[ 0 ];
		$amt2 = showhowmuch( $name1, $crea1, $pname1, $amount );
		// 		echo "$amt2, $name1<br>";
		$amt3 = $amt2 * $lst[6];
		#		$amt4 = 1 / $lst[7];

		if( $amt2 != 0 )
		{
			#			$messa[0] = $lst[ 1 ];
			$messa[0] = (float)$amt2;
			$messa[1] = $lst[1];
			$messa[2] = $lst[2];
			#			$messa[3] = (float)$lst[4];
			$messa[3] = (float)$amt3;
			$messa[4] = $lst[4];
			$messa[5] = $lst[5];
				
			$messa[6] = (float)$lst[6];
			$messa[7] = (float)$lst[7];

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

?>
