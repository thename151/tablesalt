<?php

include_once( "funcs.php" );

function removetrade( $name1, $traden )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "txno", $traden );if ($check1 != "okay" ){ return $check1;}

	$result2 = myquery( "select creator1, product1, creator2, product2, user
						 from sales3 where uniqueX = \"$traden\" and user = \"$name1\"" );

	$row = mysqli_fetch_row( $result2 );
	if($row != null )
	{
		myquery( "delete from sales3 where uniqueX = \"$traden\"" );
		myquery( "delete from salesactive where saleId = \"$traden\"" );
		
		include_once ("balance4.php");
	
		updatePair( $row[0], $row[1], $row[2], $row[3], $row[4] );
		return "trade deleted";
	}
	else
	{
		return "that profile's trade does not exist!";
	}
	return $mess1;
}


function edittrade( $amount,  $crea1, $pname1,
					$price,   $crea2, $pname2,
					$buysell, $name1, $txno, $keepon )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $crea1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pname1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $crea2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pname2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $price );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "buysell", $buysell );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "txno", $txno );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "keepon", $keepon );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );
	$price = trimtodp( $price );

	//check inputs
	
	if( ( $crea1 == $crea2 ) && ( $pname1 == $pname2 ) )
	{
		return "too many names are the same";
	}

	return edittrade20( $amount,  $crea1, $pname1,
					    $price,   $crea2, $pname2,
					    $buysell, $name1, $txno, $keepon );
	return "unknown";
}

function edittrade20( $amount,  $crea1, $pname1,
			  		  $price,   $crea2, $pname2,
					  $buysell, $name1, $txno, $keepon )
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
	keeptrade = \"$keepon\"
	where uniqueX = \"$txno\"" );

	$mess1 = "sale edited";	
	
	include_once( "balance4.php" );

	myquery( "delete from salesactive where saleId = \"$txno\"" );
		
	newSale( $crea1, $pname1,
			 $crea2, $pname2, $name1 );
	
	return $mess1;
}

function settradeb( $name1, $amount, $crea1,  $pname1,
					$price, $crea2,  $pname2, $buysell )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $crea1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pname1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $crea2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pname2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $price );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "buysell", $buysell );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );
	$price = trimtodp( $price );

	//check inputs
	if( ( $crea1 == $crea2 ) && ( $pname1 == $pname2 ) )
	{
		return "too many names are the same";
	}

	return settradeb2( $name1, $amount, $crea1, $pname1,
				$price, $crea2, $pname2, $buysell );

	return "unknown";
}


function settradeb2( $name1, $amount, $crea1, $pname1,
		$price, $crea2, $pname2, $buysell )
{
	$result4 = myquery( "select productName, divisible from products1 where profileName = \"$crea1\" and productName = \"$pname1\" and status1 = \"okay\"" );
	$row = mysqli_fetch_row( $result4 );
	if($row == null )
	{
		return "not found";#product does not exist";
	}
	if($row[1] == 0 )
	{
		$var1 = fmod($amount, 1);
#		echo "ww : $var1";
		if( $var1 != 0 )
		{
			
			return "$crea1 $pname1 can't have decimal places : $var1";
		}
	}
	
	# product exists
	# does crea2-pname2 exist

	$result5 = myquery( "select productName, divisible from products1 where profileName = \"$crea2\" and productName = \"$pname2\" and status1 = \"okay\"" );
	$row2 = mysqli_fetch_row( $result5 );
	if($row2 == null )
	{
		return "not found";#"product does not exist";
	}
	if($row2[1] == 0 )
	{
		return "$crea2 $pname2 can not contain decimal places and so can not be the second product in a trade";
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
		
		//~ include( "hilovalues.php" );
		//~ $check1 = check_number( $amount1, $loscore, $hiscore );
		//~ if( $check1 != "is valid" )
		//~ {
			//~ return "sale not added : amount, price too big";
		//~ }
		
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
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "password", $pass1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "txno", $tdn );if ($check1 != "okay" ){ return $check1;}
	
	$am1 = trimtodp( $am1 );
	$am2 = trimtodp( $am2 );
	
	$check1 = checknamepass( $name1, $pass1 );

	if( $check1 != "goodpass" )
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

	$changed = false;
//	echo "wrqw $name1, $pass1, $tdn, $am1, $am2";
	$check1 = check_string( "amount", $am1 );if ($check1 != "okay" ){ return $check1;}

	if( $check1 =="okay" )
	{
		my2query( "update sales3 set
				amount1 = \"$am1\"
				where uniqueX = \"$tdn\"" );

		$changed = true;
	}

	$check1 = check_string( "amount", $am2 );if ($check1 != "okay" ){ return $check1;}

	if( $check1 == "okay" )
	{
		if( $row2[1] == "sell" )
		{
			$price2 = 1 / $am2;
			my2query( "update sales3 set
			price1 = \"$am2\",
			price2 = \"$price2\"
			where uniqueX = \"$tdn\"" );
		}
		if( $row2[1] == "buy" )
		{
			$price1 = 1 / $am2;
			my2query( "update sales3 set
			price1 = \"$price1\",
			price2 = \"$am2\"
			where uniqueX = \"$tdn\"" );
		}
		$changed = true;
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


function gettrade( $name1, $txno )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "txno", $txno );if ($check1 != "okay" ){ return $check1;}

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

?>
