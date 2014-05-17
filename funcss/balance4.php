<?php

function newSale( $cr1, $pr1, $cr2, $pr2, $user )
{
	$q1 = myquery( "select uniqueX from salesactive order by uniqueX desc limit 1" );
	$row = mysqli_fetch_row( $q1 );
	$stopId = 0;
	if($row != null )
	{	
		// 001 echo "not zero<br>";
		$stopId = $row[0];
	}

	updatePair( $cr1, $pr1, $cr2, $pr2, $user );
	updateActiveSales( $stopId );
}


function newSend( $cr1, $pr1, $user1, $user2 )
{
	$q1 = myquery( "select uniqueX from salesactive order by uniqueX desc limit 1" );
	$row = mysqli_fetch_row( $q1 );
	$stopId = 0;
	
	if($row != null )
	{
		$stopId = $row[0];
	}

	updateStock( $cr1, $pr1, $user1 );
	updateStock( $cr1, $pr1, $user2 );

	updateActiveSales( $stopId );
}


function newSendDiv( $cr1, $pr1, $user1 )
{
	$q1 = myquery( "select uniqueX from salesactive order by uniqueX desc limit 1" );
	$row = mysqli_fetch_row( $q1 );
	$stopId = 0;
	
	if($row != null )
	{
		$stopId = $row[0];
	}

	updateStock( $cr1, $pr1, $user1 );

	updateActiveSales( $stopId );
}



function updatePair( $cr1, $pr1, $cr2, $pr2, $user )
{
	// 001 echo "updatePair( $cr1, $pr1, $cr2, $pr2, $user )<br>";
	include_once( "listtrades.php" );
	$var1 = showHowMuch2( $cr1, $pr1, $user );

	$q1 = myquery( "select
			type1, amount1, price2, uniqueX
			from sales3
			where creator1 = \"$cr1\" and product1 = \"$pr1\" and 
				  creator2 = \"$cr2\" and product2 = \"$pr2\" and user = \"$user\"
			order by price1 " );


	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
		$type1 = $rowa[0];
		$amount = $rowa[1];
		$price2 = $rowa[2];
		$uniqueX = $rowa[3];

		// 001 echo "updatepair price2 : $price2<br>";
		
		$var2 = 0;
		$stock = 0;
		$checkdivisible = false;
		
		if( $type1 == "buy" )
		{
			$q3 = myquery( "select
			divisible 
			from products1
			where profileName = \"$cr2\" and productName = \"$pr2\" " );
			$row4 = mysqli_fetch_row( $q3 );
			$divisible = $row4[0];
			if ( $divisible == 0 )
			{
				//~ echo "check1<br>";
				$checkdivisible = true;
			}

			$var2 = $amount * $price2;
		}
		else
		{
			$var2 = $amount;
		}
		
		if( $var1 > $var2 )
		{
			$stock = $var2;
			$var1 = $var1 - $stock;
		}
		else
		{
			$stock = $var1;
			$var1 = 0;
		}
		
		//~ echo "check 2<br>";
		if( $checkdivisible )
		{
			//~ echo "check 3<br>";
			if( $stock < $price2 )
			{
				//~ echo "check 4<br>";
				$var1 = $var1 + $stock;
				$stock = 0;
			}
		}

		$q2 = myquery( "select
			uniqueX, stock
			from salesactive
			where saleId = \"$uniqueX\"" );

		// 001 echo "find this saleID : $uniqueX<br>";
			
		$row = mysqli_fetch_row( $q2 );
		
		// // 001 echo "var1 : $var1<br>";
		// // 001 echo "var2 : $var2<br>";
		
		if( $row != null )
		{
			if( $stock == 0 )
			{
				// 001 echo "delete<br>";
		 		my2query( "delete from salesactive where uniqueX = \"$row[0]\"" );
			}
			else
			{
				// 001 echo "update : ";
				if( $stock != $row[1] )
				{
					my2query( "update salesactive set
					stock = \"$stock\"
					where uniqueX = \"$row[0]\"" );
					// 001 echo "not same<br>";
				}
				else
				{
					// 001 echo "nothing<br>";
				}
			}
		}
		else
		{
			// 001 echo "row doesn't exist<br>";
		
			if( $stock > 0 )
			{
				// 001 echo "insert<br>";
		 		my2query( "INSERT INTO salesactive
						( saleId, stock )
						values
						( \"$uniqueX\", \"$stock\" )" );
			}
		}
	}

	// 001 echo "updatepair after while<br>";
}


function updateActiveSales( $stopId )
{
	// 001 echo "update active sales  : $stopId<br>";
	$q1 = myquery( "select uniqueX from salesactive order by uniqueX desc limit 1" );
	$row = mysqli_fetch_row( $q1 );
	$thisId = 0;
	
	if($row == null )
	{
		return null;
	}
	$thisId = $row[0];
	// 001 echo "thisid  : $thisId<br>";
	
	while( $thisId > $stopId )
	{
		$var1 = findMatch( $thisId );

		if( $var1 > 0 )
		{
//			$thisId = get highestId
			$q2 = myquery( "select uniqueX from salesactive order by uniqueX desc limit 1" );
			$row = mysqli_fetch_row( $q2 );
			$thisId = 0;

			if($row == null )
			{	
				return null;
			}
			$thisId = $row[0];
		}
		else
		{
//			$thisId = highest bid less than thisId
			$q3 = myquery( "select uniqueX from salesactive 
							where uniqueX < \"$thisId\"
							order by uniqueX desc limit 1" );
			$row = mysqli_fetch_row( $q3 );
			$thisId = 0;

			if($row == null )
			{	
				// 001 echo "returnes<br>";
				return null;
			}
			$thisId = $row[0];
			// 001 echo "thisid 2 : $thisId<br>";
		}
	}	
}


function findMatch( $fid )
{
	// 001 echo "findMatch( $fid )<br>";

	$q1 = myquery( "select
					creator1, product1, creator2, product2,
					stock,    price1,   price2,   user
					from salesactive2 where
					uniqueX = \"$fid\" " );

	$row = mysqli_fetch_row( $q1 );

	$fstock = $row[4];
	
	$q2 = myquery( "select
					uniqueX
					from salesactive2 where
					creator1 = \"$row[2]\" and product1 = \"$row[3]\" and
					creator2 = \"$row[0]\" and product2 = \"$row[1]\" and
					price2 >= \"$row[5]\" and 
					user != \"$row[7]\"
					order by price1" );

	$var2 = 0;
	
	while( ($rowa = mysqli_fetch_array( $q2 )) && $fstock > 0 )
	{
		$var2 = $var2 + balance2trades( $fid, $rowa[0] );
	}
	
	// 001 echo "var2 : $var2<br>";
	return $var2;
}


function balance2trades( $fid, $oId )
{
	// 001 echo "balance2trades( $fid and $oId )<br>";
	$q1 = myquery( "select
					type1,	amount1,		stock,	user,
					creator1,	product1,	creator2,	product2,
					saleId, divisible
					from salesactive3
					where uniqueX = \"$fid\" " );
	$row1 = mysqli_fetch_row( $q1 );

	$r1type = $row1[0];
	$r1amount = $row1[1];
	$r1stock = $row1[2];
	$r1user = $row1[3];

	$cr1 = $row1[4];
	$pr1 = $row1[5];
	$cr2 = $row1[6];
	$pr2 = $row1[7];

	$r1saleId = $row1[8];
	$r1divisible = $row1[9]; //1;//
	
	$q2 = myquery( "select
					type1,	amount1,		stock,	user,
					price1,		price2,
					saleId, divisible
					from salesactive3
					where uniqueX = \"$oId\" " );
	$row2 = mysqli_fetch_row( $q2 );

	$r2type = $row2[0];
	$r2amount = $row2[1];
	$r2stock = $row2[2];
	$r2user = $row2[3];
	$r2price1 = $row2[4];
	$r2price2 = $row2[5];

	$r2saleId = $row2[6];
	$r2divisible = $row2[7];
	
	$r1sends = 0;
	$r2sends = 0;

	echo "r1 : $r1type  r2: $r2type <br>";

	if( $r1type == "buy" && $r2type == "sell" )		//"1"
	{
		if( $r1amount >= $r2stock )					//1 >= 1
		{
			$r1sends = $r2stock * $r2price1;		//10 * 0.7 = 7
			$r2sends = $r2stock;					//10
			if ( $r1sends > $r1stock )				//7 > 1.3
			{
				$r1sends = $r1stock;				//1.3
				$r2sends = $r1stock * $r2price2;	//1.3 * 1.42
			}
		}
		else										//( 2 < 10 )
		{
			$r1sends = $r1amount * $r2price1;		//( 1.4 )
			$r2sends = $r1amount;					//( 2 )
			if ( $r1sends > $r1stock )				//( 1.4 > 1.3 )
			{
				$r1sends = $r1stock;				//( 1.3 )
				$r2sends = $r1stock * $r2price2;	//( 1.3 * 1.42 )
			}
		}
		echo "q1 r1sends : $r1sends, r2sends : $r2sends<br>";
		
		if( $r2divisible == '0' )
		{
			$var1 = fmod( $r2sends, 1 );
			if( $var1 != 0 )
			{
				$r2sends = $r2sends - $var1;
				if( $r2sends == 0 )
				{
					echo "no sale<br>";
					return 0;
				}
			
				$r1sends = $r2sends * $r2price1;
			}
		}
		echo "q2 r1sends : $r1sends, r2sends : $r2sends<br>";
	}

	if ( $r1type == "sell" && $r2type == "buy" )		//"3"
	{
		$var1 = $r1stock * $r2price2;
		if( $var1 <= $r2stock )							//2 * 1.42 < 10
		{
			$r1sends = $r1stock;						//2
			$r2sends = $r1stock * $r2price2;			//2.84
		}
		if( $var1 > $r2stock )							//20 * 1.42 > 10
		{
			$r1sends = $r2stock * $r2price1;			//10 * 0.7 = 7
			$r2sends = $r2stock;						//10
		}

		echo "q3 r1sends : $r1sends, r2sends : $r2sends : $r1divisible : $r2divisible<br>";
		
		if( $r1divisible == '0' )
		{
			echo "here<br>";
			$var1 = fmod( $r1sends, 1 );
			if( $var1 != 0 )
			{
				$r1sends = $r1sends - $var1;
				$r2sends = $r1sends * $r2price2;
			}
			if( $r1sends == 0 )
			{
				echo "no sale<br>";
				return 0;
			}
		}
		echo "q4 r1sends : $r1sends, r2sends : $r2sends<br>";

	}

	if ( $r1type == "sell" && $r2type == "sell" )					//"2"
	{
		$var1 = $r1stock * $r2price2;
		if( $var1 <= $r2stock )		//2 * 1.42 < 10
		{
			$r1sends = $r1stock;						//2
			$r2sends = $r1stock * $r2price2;			//2.84
		}
		if( $var1 > $r2stock )		//20 * 1.42 > 10
		{
			$r1sends = $r2stock * $r2price1;			//10 * 0.7 = 7
			$r2sends = $r2stock;						//10
		}
	}


	if ( $r1type == "buy" && $r2type == "buy" )					//"4"
	{	
		// 001 echo "one<br>";
		if ( $r1amount <= $r2stock )					// 2 < 10
		{
			// 001 echo "two<br>";
			$r1sends = $r1amount * $r2price1;		//2 * 1.33
			$r2sends = $r1amount;
			if( $r1sends > $r1stock )
			{
				$r1sends = $r1stock;
				$r2sends = $r1stock * $r2price2;
			}
		}
		if ( $r1amount > $r2stock )
		{
			$r1sends = $r2stock * $r2price1;
			$r2sends = $r2stock;
			if ( $r1sends > $r1stock )
			{
				$r1sends = $r1stock;
				$r2sends = $r1stock * $r2price2;
			}
		}
	}

	// 001 echo "q1w r1sends : $r1sends, r2sends : $r2sends<br>";
//	1.234  // good
//	1.234567  // bad
	
	$wouldsend = 0;
	$doessend = 0;
	$odduser = "";

	$var1 = fmod( ( $r1sends * 1000 ), 1 );		// 1234.567 % 1
	if( $var1 != 0 )							// var1 = 0.567
	{
		$odduser = $r1user;
		$wouldsend = $var1  / 1000;
		$doessend = rounder( $var1 );
		$r1sends = $r1sends - $wouldsend + $doessend;
	}

	$var1 = fmod( ( $r2sends * 1000 ), 1 );


	if( $var1 > 0 )
	{
		// 001 echo "r2 : $var1  : $r2sends <br>";
		$odduser = $r2user;
		$wouldsend = $var1 / 1000;					// 0.000001 to 0.000999
		$doessend = rounder( $var1 );		// 0.001 or 0
		$r2sends = $r2sends - $wouldsend + $doessend;
	}

	$dateTime = date("y-m-d H:i:s",time());

	// 001 echo "sender : $odduser, would : $wouldsend, does : $doessend<br>";

	$query = "INSERT INTO tradelog
	( trade1ux, user1, creator1, product1, amount1, price1,
      trade2ux, user2, creator2, product2, amount2, price2, 
      dateTime,
	  odduser, wouldsend, doessend
	)
	values
	( \"$fid\", \"$r1user\", \"$cr1\", \"$pr1\", \"$r1sends\", \"$r2price1\",
	  \"$oId\", \"$r2user\", \"$cr2\", \"$pr2\", \"$r2sends\", \"$r2price2\",  
	  \"$dateTime\",
	  \"$odduser\", \"$wouldsend\", \"$doessend\" )";

	// 001 echo $query;
	my2query( $query );
	
	
	// 001 echo "r1sends : $r1sends, r2sends : $r2sends<br>";
	include_once( "sendproduct.php" );

	$send = sendproduct($r1user, $cr1, $pr1, $r1sends, $r2user, "trade" );
	$send = sendproduct($r2user, $cr2, $pr2, $r2sends, $r1user, "trade" );

	$var2 = 0;
	if( $r1type == "sell" )
	{
		$var2 = $r1sends;
	}
	if( $r1type == "buy" )
	{
		$var2 = $r2sends;
	}
	updatesalesTotal( $r1saleId, $var2 );
	
	$var2 = 0;
	if( $r2type == "sell" )
	{
		$var2 = $r2sends;
	}
	if( $r2type == "buy" )
	{
		$var2 = $r1sends;
	}
	updatesalesTotal( $r2saleId, $var2 );

	updateStock( $cr1, $pr1, $r1user );
	updateStock( $cr2, $pr2, $r2user );
	
	updateStock( $cr2, $pr2, $r1user );
	updateStock( $cr1, $pr1, $r2user );

	return 1;
}


function updatesalesTotal( $Id, $var1 )
{
	if( $var1 == 0 )
	{
		return 0;
	}
	$q1 = myquery( "select amount1 from sales3 
					where uniqueX = \"$Id\" " );

	$row1 = mysqli_fetch_row( $q1 );

	$amount = $row1[0];
	$newamount = $amount - $var1;

	// 001 echo "$Id, : newamount : $newamount<br>";
	
	if( $newamount <= 0 )
	{
		// 001 echo "update sales total : delete<br>";
		
		my2query( "update sales3 set amount1 = \"0\" where uniqueX = \"$Id\" " );

//		my2query( "delete from sales3 where uniqueX = \"$Id\" " );
		my2query( "delete from sales3 where uniqueX = \"$Id\" and keeptrade != \"dokeep\" " );

		my2query( "delete from salesactive where saleId = \"$Id\" " );
	}
	else
	{
		// 001 echo "update sales total : update<br>";
		my2query( "update sales3 set
					amount1 = \"$newamount\"
					where uniqueX = \"$Id\" " );
	}
}


function updateStock( $cr1, $pr1, $user )
{
//	echo "updateStock( $cr1, $pr1, $user )<br>";
	$curcr = "";
	$curpr = "";
	
	$q1 = myquery( "select
					creator2,  product2
					from sales3 where
					creator1 = \"$cr1\" and
					product1 = \"$pr1\" and
					user = \"$user\"
					order by creator2 and product2" );

	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
		if( ( $rowa[0] != $curcr ) || ( $rowa[1] != $curpr ) )
		{
			updatePair( $cr1, $pr1, $rowa[0], $rowa[1], $user );
			$curcr = $rowa[0];
			$curpr = $rowa[1];
		}
	}
}


function rounder( $var1 )	// .000567
{
	$var3 = $var1 * 1000;	// 567
	$var4 = 0;
	
	$xr = rand ( 1 , 1000 );
	
	// 001 echo "$xr vs. $var3<br>";

	if( $xr <= $var3 )
	{
		$var4 = 0.001;
	}
	return $var4;  //0.001 or 0
}

?>
