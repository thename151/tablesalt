<?php
include_once( "funcs.php" );


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


function showHowMuch2( $cr1, $pr1, $user )
{
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $user );if ($check1 != "okay" ){ return $check1;}


	$q1 = myquery( "select amount from scores1 where who1 = \"$user\" and creator = \"$cr1\" and product =\"$pr1\"" );

	$row = mysqli_fetch_row($q1);
	
	include( "hilovalues.php" );

	if( $row != null )
	{
		if ( $user == $cr1 )
		{
			$var1 = 1000 * $hiscore;
			$var2 = 1000 * $row[0];
			
			$var3 = $var1- $var2;
			$var4 = $var3 / 1000;

			return $var4;
			
			//~ echo "here 5 $var3 <br>";
			//~ echo "here 6 $var4 <br>";
			//~ 
			//~ $availbl = $hiscore - $row[0];
			 //~ echo"avalable $availbl<br>";
			//~ return $availbl;
		}
		
		return $row[0];
	}
	
	if( $user == $cr1 )
	{
		echo "here 1 $hiscore<br>";
		return $hiscore;
	}
	return 0;
}


function showHowLess( $cr1, $pr1 )
{
//	echo "qwewq:( $cr1, $pr1 )<br>";
	$q1 = myquery( "select amount from scores1 where who1 = \"$cr1\" and creator = \"$cr1\" and product =\"$pr1\"" );
	$row = mysqli_fetch_row($q1);
	
	include( "hilovalues.php" );
		
	if( $row != null )
	{
			return $row[0];
	}
		
	return "product not found";
}




function listuserstrades( $name1 )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}

	$result7 = myquery( "select 
			uniqueX, amount1, type1,
			creator1,product1, creator2,product2,
			price1,price2, keeptrade
			from sales3 where user = \"$name1\"" );

	$mess1[0][0] = "okay";
	$i1 = 1;

	while( $lst = mysqli_fetch_array( $result7 ) )
	{
		$messa[0] = $lst[0];
		$messa[1] = $lst[2];
		$messa[2] = $lst[1];
		$messa[8] = $lst[9];
			
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

function listdep2mask( $cr1, $pr1, $cr2, $pr2, $type )
{	
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr2 );if ($check1 != "okay" ){ return $check1;}
	
//	echo "$cr1, $pr1, $cr2, $pr2, $type<br>";
	
	$cr1 = unmaskcr( $cr1 );
	$cr2 = unmaskcr( $cr2 );
	$pr1 = unmaskpr( $pr1 );
	$pr2 = unmaskpr( $pr2 );

	return listdep2( $cr1, $pr1, $cr2, $pr2, $type );
}

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
	where user1 = \"$cr2\" and productName = \"$pr2\" " );
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


function listtrades23( $startfrom, $results, $hide )
{
//	echo "list 23<br>";
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
		if( $hide == "hide" )
		{
			$rowa[ 0 ] = maskcr( $rowa[ 0 ] );
			$rowa[ 1 ] = maskpr( $rowa[ 1 ] );
			$rowa[ 2 ] = maskcr( $rowa[ 2 ] );//"user-" . 
			$rowa[ 3 ] = maskpr( $rowa[ 3 ] );//"product-" . 
		}
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
		where user1 = \"$rowa[2]\" and productName = \"$rowa[3]\" " );
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
		where user1 = \"$rowa[2]\" and productName = \"$rowa[3]\" " );
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
		where user1 = \"$rowa[2]\" and productName = \"$rowa[3]\" " );
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



?>
