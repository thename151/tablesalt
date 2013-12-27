<?php

/*
qqq		1	euro	gbp		0.850000	1.176451
kkk		10	euro	dollar	1.300000	0.769151
kkk		10	euro	dollar	1.400000	0.714286
qqq		1	dollar	euro	0.700000	1.428571
*/

function balancerepeat( $ca, $pa, $cb, $pb )
{
	$news = true;
  	while( $news == true )
	{
		$news = false;
		$messaget = balance( $ca, $pa, $cb, $pb );
		if( $messaget == "things were sent" )
		{
			$news = true;
		}
	}
}

function balance( $ca, $pa, $cb, $pb )
{
	// echo "<br>Newbalance $pa  $pb";
	
/*
	news = true
 	while 0 news == true
  		news = false
		while 1
		select trade a,b newest first
	 
			while 2
			select trade b,a order price2 highest first
	  			message = balance2trades( trade1Ux, trade2Ux )	
				if message == things were sent
  					news = true
  
 */
 
 	$message = "message";
		
//  while 1
//  select trade a,b newest first
	$q1 = myquery( "select
			uniqueX
			from sales3
			where creator1 = \"$ca\" and product1 = \"$pa\"
			and   creator2 = \"$cb\" and product2 = \"$pb\" 
			order by datetime desc" );
		
	while( $rowa = mysqli_fetch_array( $q1 ) ) 
	{
	//  while 2			
	//  select trade b,a order price2 highest first
		$q2 = myquery( "select
				uniqueX
				from sales3
				where creator1 = \"$cb\" and product1 = \"$pb\"
				and   creator2 = \"$ca\" and product2 = \"$pa\" 
				order by price2 desc" );

		while( $rowz = mysqli_fetch_array( $q2 ) )
		{
			$messaget = balance2trades( $rowa[0], $rowz[0] );
			if( $messaget == "things were sent" )
			{
				$message = "things were sent";
			}
		}
	}
}


function balance2trades( $xa, $xb )
{
/*
	rowa = xa
	rowz = xb
	
	if rowz[price2] < rowa price1
		return price too low
	
  	aavail = showhowmuch( rowa[user], rowa[product1] rowa[amount1])
  	zavail = showhowmuch( rowz[user], rowz[product1] rowz[amount1])
	
	maxsale = rowz[price2] * aavail

  	if maxsale < zavail
		rowa[user] recvs maxsale, rowz[user] recvs aavail
		zsends = maxsale
 		asends = aavail

   	if maxsale > zavail
  		rowa[user] recvs zavail, rowz[user] recvs zavail * rowz[price1]
		zsends = zavail
 		asends = zavail * rowz[price1]

  	sendp( rowa[user] rowz[user] rowa[product1] aavail )
  	sendp( rowz[user] rowa[user] rowz[product1] maxsale )
	updatetrade( xa, asends )
	updatetrade( xb zsends )
	
	balanceuser( rowa[user] rowa[product2] )
	balanceuser( rowz[user] rowz[product2] )
	
	return things were sent
	
*/

//	echo "<br>balance 2 trades  $xa, $xb  ";

	// rowa = xa	
	$q1 = myquery( "select
			amount1,
			creator1, product1, creator2, product2,
			price1, price2,
			user, type1
			from sales3
			where uniqueX = \"$xa\"" );

	$rowa = mysqli_fetch_array( $q1 ); 

	// rowz = xb
	$q2 = myquery( "select
			amount1,
			creator1, product1, creator2, product2,
			price1, price2,
			user, type1
			from sales3
			where uniqueX = \"$xb\"" );

	$rowz = mysqli_fetch_array( $q2 ); 

	
//	echo "<br>rowa-z  $rowa[7] $rowz[7]";

	if ($rowz[7] == $rowa[7])
	{
		return "traders are the same";
	}		

//  if rowz[price2] < rowa price1
	if ($rowz[6] < $rowa[5])
	{
		return "price too low";
	}	
	include_once( "listtrades.php" );

//  if type = sell, the amount offered is amount * rowz[price2]
	$aamount = $rowa[0];
	if($rowa[8] == "buy")
	{
		// echo "<br> a buys";
		$aamount = $rowa[0] * $rowz[5] ;
	}
	$zamount = $rowz[0];
	if($rowz[8] == "buy")
	{
		// echo "<br> z buys";
		$zamount = $rowz[0] * $rowz[6] ;
	}

	// echo "<br>amount a-z  $aamount $zamount";
	
//  aavail = showhowmuch( rowa[user], rowa[product1] rowa[amount1])
 	$aavail = showhowmuch( $rowa[7], $rowa[1], $rowa[2], $aamount );

//  zavail = showhowmuch( rowz[user], rowz[product1] rowz[amount1])
  	$zavail = showhowmuch( $rowz[7], $rowz[1], $rowz[2], $zamount );

//	if either equal zero return things not sent 

	// echo "<br>avail a-z  $aavail $zavail";

//  maxsale = rowz[price2] * aavail
	$maxsale = $rowz[6] * $aavail;

	// echo "<br>maxsale  $maxsale";
	
	
	$zsends = 0;
 	$asends = 0;
		
  	// if maxsale < zavail
  	if ( $maxsale < $zavail )
	{
		// rowa[user] recvs maxsale, rowz[user] recvs aavail
		$zsends = $maxsale;
 		$asends = $aavail;
	}

   	// if maxsale > zavail
   	if ( $maxsale > $zavail )
	{
  		// rowa[user] recvs zavail, rowz[user] recvs zavail * rowz[price1]
		$zsends = $zavail;
 		// asends = zavail * rowz[price1]
 		$asends = $zavail * $rowz[5];
	}
	// echo "<br>a-z sends  $asends  $zsends";
	
	include( "hilovalues.php" );
		
	$asends = roundwdown1( $asends, (1 / $loscore ) );
	$zsends = roundwdown1( $zsends, (1 / $loscore ) );
	
	// echo "<br>a-z sends  $asends  $zsends";
							
	if( ( $asends < $loscore ) || ( $zsends < $loscore ) || ( $asends > $hiscore ) || ( $zsends > $hiscore ) )
	{
		// echo "<br>too small<br>";
		return "<br>too small<br>";
	}
		
	
  	// sendp( rowa[user] rowz[user] rowa[product1] aavail )
  	// sendp( rowz[user] rowa[user] rowz[product1] maxsale )
  	include_once( "sendproduct.php" );
	$send1 = sendproduct($rowa[7], $rowa[1], $rowa[2], $asends, $rowz[7], "trade" );
	$send2 = sendproduct($rowz[7], $rowz[1], $rowz[2], $zsends, $rowa[7], "trade" );
  	
	// updatetrade( xa, asends )
	if( $rowa[8] == "sell")
	{
		updatesale5( $xa, $rowa[0] - $asends );
	}
	if( $rowa[8] == "buy" )
    {
    	updatesale5( $xa, $rowa[0] - $zsends );
	}
	
	// updatetrade( xb zsends )
	if( $rowz[8] == "sell")
	{
		updatesale5( $xb, $rowz[0] - $zsends );
	}
	if( $rowz[8] == "buy" )
    {
    	updatesale5( $xb, $rowz[0] - $asends );
	}
	
	

	// balanceuser( rowa[user] rowa[product2] )
	balanceuser( $rowa[7], $rowa[3], $rowa[4] );
	
	// balanceuser( rowz[user] rowz[product2] )
	balanceuser( $rowz[7], $rowz[3], $rowz[4] );
	
	return "things were sent";
}

function balanceuser( $user1, $cr1, $pr1 )
{
/*
	while
	select user1 product1 = product1
	balance( product1 product2 )
*/

	// echo "<br>blance user   $user1, $cr1, $pr1";

	$q1 = myquery( "select
			creator2, product2
			from sales3
			where creator1 = \"$cr1\" and product1 = \"$pr1\" and user = \"$user1\"
			order by datetime desc" );

	while( $rowa = mysqli_fetch_array( $q1 ) ) 
	{
		echo "<br>while $rowa[0] $rowa[1]";
		// balance( $cr1, $pr1, $rowa[0], $rowa[1] );
	}
	return "okay";
}


function roundwdown1( $n1, $f1 )
{
	$n1 = $n1 * $f1;
	
	$n1 = ( int )$n1 ;
	$n1 = $n1 / $f1;
		
	return $n1;
}




function updatesale5( $uX, $amount1 )
{
	if( $amount1 <= 0 )
	{
		myquery( "delete from sales3 where uniqueX = \"$uX\"" );
	}
	else
	{
		my2query( "update sales3 set amount1 = \"$amount1\" where uniqueX = \"$uX\"" );
	}
}




?>