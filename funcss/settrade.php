<?php

include( "funcs.php" );

function removetrade( $name1, $traden )
{
	$check1 = removetrade2( $name1, $traden );

	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$result2 = myquery( "select * from sales3 where uniqueX = \"$traden\" and user = \"$name1\"" );

	$row = mysqli_fetch_row( $result2 );
	if($row != null )
	{
		myquery( "delete from sales3 where uniqueX = \"$traden\"" );
		myquery( "delete from salesactive where saleId = \"$traden\"" );
		return "trade deleted";
	}
	else
	{
		return "that profile's trade does not exist!";
	}
	return $mess1;
}

function removetrade2( $name1, $traden )
{
	include( "hilovalues.php" );

	$check1 = check_name( $name1, "name", $namelength );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	return check_number( $traden, 0, 100000 );
}

function edittrade( $amount,  $crea1, $pname1,
					$price,   $crea2, $pname2,
					$buysell, $name1, $txno )
{
	//check inputs
	if( ( $crea1 == $crea2 ) && ( $pname1 == $pname2 ) )
	{
		return "too many names are the same";
	}

	include( "hilovalues.php" );

	$check1 = check_name( $name1, "name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_number( $amount, $loscore, $hiscore );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_number( $price, $loscore, $hiscore );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $crea1, "name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $crea2, "name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $pname1, "product name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $pname2, "product name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	if( $buysell == "buy" || $buysell == "sell" )
	{
		return edittrade20( $amount,  $crea1, $pname1,
						    $price,   $crea2, $pname2,
						    $buysell, $name1, $txno );
	}
	return "unknown";
}

function edittrade20( $amount,  $crea1, $pname1,
			  		  $price,   $crea2, $pname2,
					  $buysell, $name1, $txno )
{
	$result4 = myquery( "select productName from products1 where 
						 profileName = \"$crea1\" and 
						 productName = \"$pname1\" and 
						 status1 = \"okay\"" );
	$row = mysqli_fetch_row( $result4 );

	if($row == null )
	{
		return "not found";#"product does not exist";
	}
	# product exists
	# does crea2-pname2 exist

	$result5 = myquery( "select productName from products1 where 
						 profileName = \"$crea2\" and 
						 productName = \"$pname2\" and 
						 status1 = \"okay\"" );
	$row2 = mysqli_fetch_row( $result5 );
	if($row2 == null )
	{
		return "not found";#product does not exist";
	}

	# enter sale
	$date1 = date("y-m-d H:i:s",time());

	include( "hilovalues.php" );
	$check1 = check_number( $amount, $loscore, $hiscore );

	if( $check1 != "is valid" )
	{
		return "sale not added : price too big";
	}

	$check1 = check_number( $price, $loscore, $hiscore );

	if( $check1 != "is valid" )
	{
		return "sale not added : price too small";
	}
	
	$price1 = 0;
	$price2 = 0;

	if( $buysell == "sell")
	{
		$price1 = $price;
		$price2 = 1 / $price;
	}
	if( $buysell == "buy")
	{
		$price1 = 1 / $price;
		$price2 = $price;

		$crea3 = $crea1;
		$crea1 = $crea2;
		$crea2 = $crea3;
			
		$pname3 = $pname1;
		$pname1 = $pname2;
		$pname2 = $pname3;
	}

	my2query( "update sales3 set
	amount1 = \"$amount\",

	creator1 = \"$crea1\",
	product1 = \"$pname1\",

	creator2 = \"$crea2\",
	product2 = \"$pname2\",

	price1 = \"$price1\",
	price2 = \"$price2\",

	type1 = \"$buysell\",
	stock = \"0\"
	where uniqueX = \"$txno\"" );

	$mess1 = "sale edited";

//	include_once( "balance2.php" );
//	$mess1b = balance( $crea1, $pname1,
//	         		   $crea2, $pname2 );
//	$mess1 .= "<br>$mess1b";

//	return $mess1;

	// echo " $name1, $crea1, $pname1<br> ";
	
	// include_once( "balance3.php" );
	// addstock( $name1, $crea1, $pname1 );
	
	
	include_once( "balance4.php" );

	myquery( "delete from salesactive where saleId = \"$txno\"" );
		
	newSale( $crea1, $pname1,
			 $crea2, $pname2, $name1 );
	
	return $mess1;
}

function settradeb( $name1, $amount, $crea1,  $pname1,
					$price, $crea2,  $pname2, $buysell )
{
	//check inputs
	if( ( $crea1 == $crea2 ) && ( $pname1 == $pname2 ) )
	{
		return "too many names are the same";
	}

	include( "hilovalues.php" );

	$check1 = check_name( $name1, "name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_number( $amount, $loscore, $hiscore );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_number( $price, $loscore, $hiscore );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $crea1, "name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $crea2, "name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $pname1, "product name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	$check1 = check_name( $pname2, "product name", $namelength );
	if( $check1 != "is valid" )	{
		return $check1;
	}
	if( $buysell == "buy" || $buysell == "sell" )
	{
		return settradeb2( $name1, $amount, $crea1, $pname1,
				$price, $crea2, $pname2, $buysell );
	}
	return "unknown";
}

function settradeb2( $name1, $amount, $crea1, $pname1,
		$price, $crea2, $pname2, $buysell )
{
	$result4 = myquery( "select productName from products1 where profileName = \"$crea1\" and productName = \"$pname1\" and status1 = \"okay\"" );
	$row = mysqli_fetch_row( $result4 );
	if($row == null )
	{
		return "not found";#product does not exist";
	}
	# product exists
	# does crea2-pname2 exist

	$result5 = myquery( "select productName from products1 where profileName = \"$crea2\" and productName = \"$pname2\" and status1 = \"okay\"" );
	$row2 = mysqli_fetch_row( $result5 );
	if($row2 == null )
	{
		return "not found";#"product does not exist";
	}


//		echo "order";
		//buy
		//buy 10e for 1.4d each

		$amount1 = $amount;

		$price1 = 0;
		$price2 = 0;
		$type1 = "";

		if( $buysell == "sell")
		{
			$price1 = $price;
			$price2 = 1 / $price;
			$type1 = "sell";
		}
		
		if( $buysell == "buy")
		{
	//		echo "$pname1 $pname2<br>";
			$price1 = 1 / $price;
			$price2 = $price;
			$type1 = "buy";
	
	//		echo "set tradeb : $pname1 $pname2 $price1 $price2<br>";
			
			$crea3 = $crea1;
			$crea1 = $crea2;
			$crea2 = $crea3;
			
			$pname3 = $pname1;
			$pname1 = $pname2;
			$pname2 = $pname3;
		}
		
		include( "hilovalues.php" );
		$check1 = check_number( $amount1, $loscore, $hiscore );
		if( $check1 != "is valid" )
		{
			return "sale not added : amount, price too big";
		}
		
		$date1 = date("y-m-d H:i:s",time());
		
		my2query( "INSERT INTO sales3
		( type1, amount1, creator1, product1, creator2, product2, price1, price2, user, dateTime )
		VALUES
		( \"$type1\", \"$amount1\", 
	      \"$crea1\", \"$pname1\",
		  \"$crea2\", \"$pname2\",
		  \"$price1\", \"$price2\", \"$name1\", \"$date1\" ) " );
		
		$mess1 = "sale added";

// 		include_once( "balance2.php" );
		
// 		balance( $crea1, $pname1,
// 		$crea2, $pname2 );
		
		
		// include_once( "balance3.php" );

	    // // echo " $name1, $crea1, $pname1<br> ";
		// addstock( $name1, $crea1, $pname1 );

		include_once( "balance4.php" );

//	    echo "settradeb2() : $name1, $crea1, $pname1<br> ";
		newSale( $crea1, $pname1,$crea2, $pname2, $name1 );

		
		return $mess1;
}


function edittrade3( $name1, $pass1, $tdn, $am1, $am2 )
{
	$check1 = checknamepass( $name1, $pass1 );

	if( $check1 != "goodpass" )
	{
		return $check1;
	}

	$check1 = check_number( $tdn, 1, 100000 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$result2 = myquery( "select uniqueX, type1,
						 creator1, product1,
						 creator2, product2
	                     from sales3 
	                     where uniqueX = \"$tdn\" and 
	                     user = \"$name1\"" );

	$row2 = mysqli_fetch_row( $result2 );
	if( $row2 == null )
	{
		return "trade not found";
	}

	include( "hilovalues.php" );

	$changed = false;
//	echo "wrqw $name1, $pass1, $tdn, $am1, $am2";
	if( $am1!= "" )
	{
		$check1 = check_number( $am1, $loscore, $hiscore );
		if( $check1 == "is valid" )
		{
			my2query( "update sales3 set
			amount1 = \"$am1\"
			where uniqueX = \"$tdn\"" );

			$changed = true;
		}
	}

	if( $am2!= "" )
	{
		$check1 = check_number( $am2, $loscore, $hiscore );
		if( $check1 == "is valid" )
		{
			
			if( $row2[1] == "sell" )
			{
				$price2 = 1 / $am2;
				my2query( "update sales3 set
				price1 = \"$am2\",
				price2 = \"$price2\",
				stock = \"0\"
				where uniqueX = \"$tdn\"" );
			}
			if( $row2[1] == "buy" )
			{
				$price1 = 1 / $am2;
				my2query( "update sales3 set
				price1 = \"$price1\",
				price2 = \"$am2\",
				stock = \"0\"
				where uniqueX = \"$tdn\"" );
			}
			$changed = true;
		}
	}
	if( $changed == true )
	{
		//balance
// 		include_once( "balance2.php" );
		
// 		$messb2 = balance( $row2[2], $row2[3],
// 		         		   $row2[4], $row2[5] );

		// echo "$name1, $row2[2], $row2[3]";

		include_once( "balance4.php" );
		// addstock( $name1, $row2[2], $row2[3] );

		
		newSale( $row2[2], $row2[3],
 		         		   $row2[4], $row2[5], $name1 );
		return "sale edited<br>";
	}

	return "blank1";
}

?>
