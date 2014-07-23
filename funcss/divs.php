<?php

include_once( "funcs.php" );

function sendiv1( $cr1, $pr1, $cr2, $pr2, $am1 )
{
	//  1            2                               3                  4
	// 132 * 1.2 = 158.4, rounds up to a maximum of 159, cancontinue = true
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr2 );if ($check1 != "okay" ){ return $check1;}
	
	$check1 = check_string( "amount", $am1 );if ($check1 != "okay" ){ return $check1;}
	$am1 = trimtodp( $am1 );


	$q0 = myquery( "select productName, divisible from products1 where user1 = \"$cr1\" and productName = \"$pr1\" and status1 = \"okay\"" );
	$row1 = mysqli_fetch_row( $q0 );
	if($row1 == null )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$cr1 $pr1 not found";
		return $mess1;
	}
	
	$q0 = myquery( "select productName, divisible from products1 where user1 = \"$cr2\" and productName = \"$pr2\" and status1 = \"okay\"" );
	$row2 = mysqli_fetch_row( $q0 );
	if($row2 == null )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$cr2 $pr2 not found";
		return $mess1;
	}
	if($row2[1] == 0 )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$cr2 $pr2 can not contain decimal places and so can not be the second product in a trade";
		return $mess1;
	}

	include_once( "listtrades.php" );
	$var1 = showHowLess( $cr1, $pr1, $cr1 );
	$var2 = showHowMuch2( $cr2, $pr2, $cr1 );
	$var3 = $am1 * $var1;
	
	if( $var2 < $var3 )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$var1 * $am1 = $var3<br>you only have $var2 $cr2 $pr2";
		return $mess1;
	}
	
	$q1 = myquery( "select amount, who1 from scores1 where who1 != \"$cr1\" and creator = \"$cr1\" and product =\"$pr1\"" );

	$upamount = 0;
	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
		$amount = $rowa[0];
		$var4 = $amount * $am1;
//		echo "var4 : $var4 $rowa[1] <br>";
		$var6 = fmod( $var4, .001 );
	//	echo "var 5: $var4  var 6: $var6 <br>";
		
		if( $var6 != 0 )
		{
			$var7 = $var4 - $var6;
//			echo "var 7: $var7<br>";
			$var7 = $var7 + .001;
	//		echo "var 7: $var7<br>";

			$upamount = $upamount + $var7;
		}
		else
		{
			$upamount = $upamount + $var4;
		}
	}
	
//	echo "upamount $upamount <br>";
	
	if( $var2 < $upamount )
	{
		$mess1[0] = 'false';
		$mess1[1] = 1 * $var1 . " * $am1 = $var3<br>rounded up to a max of : $upamount<br>you only have $var2 $cr2 $pr2";
		return $mess1;
	}

	$mess1[0] = 'true';
	$mess1[1] = 1 * $var1 . " * $am1 = $var3<br>rounded up to a max of : $upamount<br>are you sure";
	$mess1[2] = $upamount;
	return $mess1;
}


function sendiv2( $cr1, $pr1, $cr2, $pr2, $am1, $prevmax )
{
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr2 );if ($check1 != "okay" ){ return $check1;}
	
	$check1 = check_string( "amount", $am1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $prevmax );if ($check1 != "okay" ){ return $check1;}

	$am1 = trimtodp( $am1 );
	$prevmax = trimtodp( $prevmax );


	$q0 = myquery( "select productName, divisible from products1 where user1 = \"$cr1\" and productName = \"$pr1\" and status1 = \"okay\"" );
	$row1 = mysqli_fetch_row( $q0 );
	if($row1 == null )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$cr1 $pr1 not found";
		return $mess1;
	}

	$q0 = myquery( "select productName, divisible from products1 where user1 = \"$cr2\" and productName = \"$pr2\" and status1 = \"okay\"" );
	$row2 = mysqli_fetch_row( $q0 );
	if($row2 == null )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$cr2 $pr2 not found";
		return $mess1;
	}
	if($row2[1] == 0 )
	{
		$mess1[0] = 'false';
		$mess1[1] = "$cr2 $pr2 can not contain decimal places and so can not be the second product in a trade";
		return $mess1;
	}
	
	include_once( "listtrades.php" );
	$var1 = showHowLess( $cr1, $pr1);
	$var2 = showHowMuch2( $cr2, $pr2, $cr1 );
	$var3 = $am1 * $var1;
	
	if ( $var3 > $var2 )
	{
		$mess1[0] = 'false';
		$mess1[1] = 1 * $var1 . " * $am1 = $var3<br>you only have $var2 $cr2 $pr2";
		return $mess1;
	}

	$q1 = myquery( "select amount, who1 from scores1 where who1 != \"$cr1\" and creator = \"$cr1\" and product =\"$pr1\"" );

	$upamount = 0;
	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
		$amount = $rowa[0];
		$var4 = $amount * $am1;
//		echo "var4 : $var4 $rowa[1] <br>";
		$var6 = fmod( $var4, .001 );
	//	echo "var 5: $var4  var 6: $var6 <br>";
		
		if( $var6 != 0 )
		{
			$var7 = $var4 - $var6;
//			echo "var 7: $var7<br>";
			$var7 = $var7 + .001;
	//		echo "var 7: $var7<br>";

			$upamount = $upamount + $var7;
		}
		else
		{
			$upamount = $upamount + $var4;
		}
	}
	
	if ( $upamount > $var2 )
	{
		$mess1[0] = 'false';
		$mess1[1] = 1 * $var1 . " * $am1 = $var3<br>rounded up to a max of : $upamount<br>you only have $var2 $cr2 $pr2";
		return $mess1;
	}

	
	$epsilon = 0.001;
	$diff = abs( $upamount - $prevmax );
	
	if ( !($diff <= $epsilon) && ( $upamount > $prevmax ) )
	{
		$mess1[0] = 'true';
		$mess1[1] = 1 * $var1 . " * $am1 = $var3<br>rounded up to a max of : $upamount<br>are you sure!! : $upamount > $prevmax";
		$mess1[2] = $upamount;
		return $mess1;
	}

	$date1 = date("y-m-d H:i:s",time());

	//insert to divlog2 usr1 usr2 p1 p2 rate would(var3)
	my2query( "INSERT INTO divtotal
			   ( cr1, pr1, cr2, pr2, rate, wouldsend, datetime )
			     values
	    	   ( \"$cr1\", \"$pr1\", \"$cr2\", \"$pr2\", \"$am1\", \"$var3\", \"$date1\" )" );

	//maindivno = get topid from divlog2 

	$q1 = myquery( "select uniqueX from divtotal order by uniqueX desc limit 1" );
	$row = mysqli_fetch_row( $q1 );
	$maindivno = $row[0];

	$q2 = myquery( "select amount, who1 from scores1 where who1 != \"$cr1\" and creator = \"$cr1\" and product =\"$pr1\"" );

	$baltable = "";
	$eachamount = "";
	$counter = 0;
	
	$total = 0;
	while( $rowb = mysqli_fetch_array( $q2 ) )
	{
		$wouldsend = 0;
		$doessend = 0;
		$amount = $rowb[0];
		$var10 = $amount * $am1;
//		echo "var4 : $var4 $rowa[1] <br>";
		$var11 = fmod( $var4, .001 );
//		echo "var 5: $var4  var 6: $var6 <br>";
		
		$var14 = $var10;
			
		if( $var11 != 0 )
		{
			$wouldsend = $var11;
			$var12 = $var10 - $var11;
			$var13 = $var11 * 1000000;
			$xr = rand ( 1 , 1000 );

			if( $var13 > $xr )
			{
				$doessend = 0.001;
				$var12 = $var12 + 0.001;
			}
			$var14 = $var12;
		}
		$total = $total + $var14;

		my2query( "INSERT INTO divs
     			   ( totalx, user, amount, wouldsend, doessend )
					values
					( \"$maindivno\", \"$rowb[1]\", \"$var14\", \"$var11\", \"$doessend\" )" );
					
		$baltable[$counter] = $rowb[1];
		$eachamount[$counter] = $var14;
		$counter = $counter + 1;
	}

	include_once( "sendproduct.php" );
	$send = sendprDiv1($cr1, $cr2, $pr2, $total );

	$count2 = 0;
	while ( $count2 < $counter )
	{
		$send = sendprDiv2( $baltable[$count2], $cr2, $pr2, $eachamount[$count2] );
		$count2 = $count2 +1;
	}

	include_once ("balance4.php");
	updateStock( $cr2, $pr2, $cr1 );

	foreach ($baltable as $value)
	{
//		echo "$value <br>";
		newSendDiv( $cr2, $pr2, $value );
	}

   //insert to divlog2 does(total)
	my2query( "update divtotal set
				doessend = \"$total\"
				where uniqueX = \"$maindivno\"" );

	$mess1[0] = 'false';
	$mess1[1] = "dividends sent";
	return $mess1;	
}


function listdivs( $startfrom, $results )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	 
	$result4 = myquery( "select 
	 cr1, 	pr1, 	cr2,	pr2,
	 rate, 	doessend, 	datetime
	 from divtotal 
	 order by datetime desc limit $startfrom, $results " );
	
	$result5 = myquery( "select uniqueX from divtotal " );

	$numrows = mysqli_num_rows( $result5 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;

	while ($result_row = mysqli_fetch_row(($result4)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[6]));
		$time1 = date( "H:i:s", strtotime($result_row[6] ) );
	
		$messa[0] = $result_row[0];       #amount
		$messa[1] = $result_row[1];       #creator
		$messa[2] = $result_row[2];       #product
		$messa[3] = $result_row[3];       #product
		$messa[4] = $result_row[4];       #product
	
		$messa[5] = $date1;
		$messa[6] = $time1;
	
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}

function listdivs2( $startfrom, $results, $cr1, $pr1 )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}

	$result4 = myquery( "select 
	 cr1, 	pr1, 	cr2,	pr2,
	 rate, 	doessend, 	datetime
	 from divtotal 
	 where
	 cr1 = \"$cr1\" and pr1 = \"$pr1\" or
	 cr2 = \"$cr1\" and pr2 = \"$pr1\"
	 order by datetime desc limit $startfrom, $results " );
	
	$result5 = myquery( "select uniqueX from divtotal 
	 where
	 cr1 = \"$cr1\" and pr1 = \"$pr1\" or
	 cr2 = \"$cr1\" and pr2 = \"$pr1\" " );

	$numrows = mysqli_num_rows( $result5 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result4)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[6]));
		$time1 = date( "H:i:s", strtotime($result_row[6] ) );
	
		$messa[0] = $result_row[0];       #amount
		$messa[1] = $result_row[1];       #creator
		$messa[2] = $result_row[2];       #product
		$messa[3] = $result_row[3];       #product
		$messa[4] = $result_row[4];       #product
	
		$messa[5] = $date1;
		$messa[6] = $time1;
	
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}



function listdivs3( $startfrom, $results, $cr2 )
{
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result4 = myquery( "select 
	 cr1, 	pr1, 	cr2,	pr2,
	 rate, 	doessend, 	datetime
	 from divtotal
	 where
	 cr1 = \"$cr2\" or
	 cr2 = \"$cr2\" 
	 order by datetime desc limit $startfrom, $results " );
	
	$result5 = myquery( "select uniqueX from divtotal
	 where
	 cr1 = \"$cr2\" or
	 cr2 = \"$cr2\"" );

	$numrows = mysqli_num_rows( $result5 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result4)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[6]));
		$time1 = date( "H:i:s", strtotime($result_row[6] ) );
	
		$messa[0] = $result_row[0];       #amount
		$messa[1] = $result_row[1];       #creator
		$messa[2] = $result_row[2];       #product
		$messa[3] = $result_row[3];       #product
		$messa[4] = $result_row[4];       #product
	
		$messa[5] = $date1;
		$messa[6] = $time1;
	
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}




function countdivs1( $cr1, $pr1 )
{
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}

	$result5 = myquery( "select uniqueX from divtotal
	 where
	 cr1 = \"$cr1\" and pr1 = \"$pr1\" or
	 cr2 = \"$cr1\" and pr2 = \"$pr1\" " );
	$numrows = mysqli_num_rows( $result5 );

	return $numrows;
}

function countdivs2( $cr2 )
{
	$check1 = check_string( "username", $cr2 );if ($check1 != "okay" ){ return $check1;}
	$result5 = myquery( "select uniqueX from divtotal
	 where
	 cr1 = \"$cr2\" or
	 cr2 = \"$cr2\"" );
	$numrows = mysqli_num_rows( $result5 );

	return $numrows;
}

?>
