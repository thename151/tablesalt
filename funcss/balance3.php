<?php

//trade edit log

function addstock( $user, $crea, $product )
{
	include_once( "listtrades.php" );
#	echo "addstock args $user, $crea, $product  <br>";

	$q1 = myquery( "select
			type1, amount1, stock, price2, uniqueX, creator1, product1, creator2, product2
			from sales3
			where creator1 = \"$crea\" and product1 = \"$product\" and user = \"$user\"
			order by creator1, product1, price2 desc" );
	
	$prevcr = "";
	$prevpr = "";
	$spent = 0;
	$prevupdate = false;
	
	$cr1 = "";
	$pr1 = "";
	$cr2 = "";
	$pr2 = "";

	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
		// echo "while $rowa[7] $rowa[8] $rowa[0] $rowa[1] $rowa[2] $rowa[3]<br>";

		$type = $rowa[0];
		$amount = $rowa[1];
		$stock = $rowa[2];
		$price2 = $rowa[3];
		$ux = $rowa[4];
		
		$cr1 = $rowa[5];
		$pr1 = $rowa[6];
		$cr2 = $rowa[7];
		$pr2 = $rowa[8];

		if( $cr2 != $prevcr || $pr2 != $prevpr )
		{
			if( $prevupdate == true )
			{
				updatetable( $cr1, $pr1, $cr2, $pr2 );
				$prevupdate = false;
			}
			$prevcr = $cr2;
			$prevpr = $pr2;
			$spent = 0;
		}
		
		$newsale = false;
		if( $stock == 0 )
		{
			$newsale = true;
		}
		// echo "newsale : $newsale<br>";
		
		$stock2 = 0;
		
		if( $type == "sell" )
		{
			$total = showhowmuch( $user, $crea, $product, $amount + $spent );
			// echo "total : $total<br>";
			$total = $total - $spent;
			// echo "total : $total<br>";
			
			// $x1 = showhowmuch( $user, $crea, $product, 999 );
			// echo "show howmuch 999 : $x1<br>";
			// $x1 = showhowmuch( $user, $crea, $product, 5 );
			// echo "show howmuch 5 : $x1<br>";

			// if( $total == 0 )
			// {
				// return true;
			// }

			if( $total >= $amount )
			{
				$stock2 = $amount;
				// echo "stock a : $stock2<br>";
			}
			if( $total < $amount )
			{
				$stock2 = $total;
				// echo "stock b : $stock2<br>";
			}
		}

		if( $type == "buy" )
		{
			$total = showhowmuch( $user, $crea, $product, ( $amount * $price2 ) + $spent );
			// echo "total : $total<br>";
			$total = $total - $spent;
			if( $total == 0 )
			{
				// return true;
			}
			if( $total > ( $amount * $price2 ) )
			{
				$stock2 = $amount * $price2;
				// echo "stock c : $stock2<br>";
			}
			if( $total <= $amount * $price2 )
			{
				$stock2 = $total;
				// echo "stock d : $stock2<br>";
			}
		}
		
		// echo "spent before : $spent<br>";
		$spent = $spent + $stock2;
		// echo "spent after  : $spent<br>";

		if ( $stock2 != $stock )
		{
			if( $newsale == true )
			{
				$prevupdate = true;
				
				$date2 = date("y-m-d H:i:s",time());
				// 			updatesale( date2, stock )
				my2query( "update sales3 set
				dateTime2 = \"$date2\",
				stock = \"$stock2\"
				where uniqueX = \"$ux\"" );
			}
			if( $newsale == false )
			{
				// 			updatesale( stock )
				my2query( "update sales3 set
				stock = \"$stock2\"
				where uniqueX = \"$ux\"" );
				// echo "update dont update table<br>";
			}	
		}
		else
		{
			// echo "no change in stock level<br>";
		}
	}
	if( $prevupdate == true )
	{
		// echo "update stock update table2<br>";
		updatetable( $cr1, $pr1, $cr2, $pr2 );
		$prevupdate = false;
	}
}

function addstock2( $user, $crea, $product )
{
	include_once( "listtrades.php" );
#	echo "addstock args $user, $crea, $product  <br>";

	$q1 = myquery( "select
			type1, amount1, stock, price2, uniqueX, creator1, product1, creator2, product2
			from sales3
			where creator1 = \"$crea\" and product1 = \"$product\" and user = \"$user\"
			order by datetime desc" );
	
	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
//		echo "while $rowa[0] $rowa[1] $rowa[2] $rowa[3]<br>";

		$type = $rowa[0];
		$amount = $rowa[1];
		$stock = $rowa[2];
		$price2 = $rowa[3];
		$ux = $rowa[4];

		$newsale = false;
		if( $stock == 0 )
		{
			$newsale = true;
		}
		// echo "newsale : $newsale<br>";
		
		$stock2 = 0;
		
		if( $type == "sell" )
		{
			$total = showhowmuch( $user, $crea, $product, $amount );
			// echo "total : $total<br>";
			if( $total == 0 )
			{
				return true;
			}
			if( $total >= $amount )
			{
				$stock2 = $amount;
				// echo "stock a : $stock2<br>";
			}
			if( $total < $amount )
			{
				$stock2 = $total;
				// echo "stock b : $stock2<br>";
			}
		}

		if( $type == "buy" )
		{
			$total = showhowmuch( $user, $crea, $product, ( $amount * $price2 ) );
			// echo "total : $total<br>";
			if( $total == 0 )
			{
				return true;
			}
			if( $total > ( $amount * $price2 ) )
			{
				$stock2 = $amount * $price2;
				// echo "stock c : $stock2<br>";
			}
			if( $total <= $amount * $price2 )
			{
				$stock2 = $total;
				// echo "stock d : $stock2<br>";
			}
		}
		
		if ( $stock2 != $stock )
		{
			if( $newsale == true )
			{
				$date2 = date("y-m-d H:i:s",time());
				// 			updatesale( date2, stock )
				my2query( "update sales3 set
				dateTime2 = \"$date2\",
				stock = \"$stock2\"
				where uniqueX = \"$ux\"" );
				
				// echo "update stock update table<br>";
				updatetable( $rowa[5], $rowa[6], $rowa[7], $rowa[8] );
			}
			if( $newsale == false )
			{
				// 			updatesale( stock )
				my2query( "update sales3 set
				stock = \"$stock2\"
				where uniqueX = \"$ux\"" );
				// echo "update dont update table<br>";
			}	
		}
		else
		{
			// echo "no change in stock level<br>";
		}
	}
}




function updatetable( $cr1, $pr1, $cr2, $pr2 )
{
	// echo "updatetable args $cr1, $pr1, $cr2, $pr2 <br>";
	
	$q1 = myquery( "select
			uniqueX, price2, stock, user
			from sales3
			where creator1 = \"$cr1\" and product1 = \"$pr1\"
			and   creator2 = \"$cr2\" and product2 = \"$pr2\"
			order by datetime desc" );  // most recent
	
	$row1 = mysqli_fetch_row( $q1 );
	
	$r1ux = $row1[0];
	$r1price2 = $row1[1];
	$r1stock = $row1[2];
	$r1user = $row1[3];
	
	// echo "row1 : $row1[0]<br>";
	
	$qstring = "select
			uniqueX, price1
			from sales3
			where creator1 = \"$cr2\" and product1 = \"$pr2\"
			and   creator2 = \"$cr1\" and product2 = \"$pr1\"
			and   stock > \"0\"
			and   user != \"$r1user\"
			order by price2 desc" ;
	
	// echo $qstring . "<br>";
	
	$q2 = myquery( $qstring );  // most recent
	
// 	$row3 = mysqli_fetch_row( $q2 );
// 	echo "$row3[0] <br>";
	
	$done = false;
	
	while( $row2 = mysqli_fetch_array( $q2 ) )// && ( $done == false) )
	{
		if ( $done == false )
		{
			// echo "row2 : $row2[0]<br>";

			$r2ux = $row2[0];
			$r2price1 = $row2[1];
			if ( $r2price1 <= $r1price2 )
			{
				// echo"r2p1 less than r1p2 <br>";
				// echo "r1stock : $r1stock<br>";
				balance2trades( $r1ux,  $r2ux );

				$q3 = myquery( "select
						stock
						from sales3
						where uniqueX = \"$r1ux\"
						order by datetime desc" );  // most recent
					
				$row3 = mysqli_fetch_row( $q3 );
				$r1stock = $row3[0];

				// echo "r1stock : $r1stock<br>";
					
				if ( $r1stock == 0 )
				{
					// echo "done = true;<br>";
					$done = true;
				}
			}
		}
	}
}


function balance2trades( $ux1, $ux2 )
{
#	echo "balance2trades args $ux1, $ux2 <br>";
	
// 	my2query( "update sales3 set
// 	stock = \"0\"
// 	where uniqueX = \"$ux1\"" );

	$q1 = myquery( "select
			type1, amount1, stock, user, creator1, product1
			from sales3
			where uniqueX = \"$ux1\"" );  // most recent
	
	$row1 = mysqli_fetch_row( $q1 );
	
	$r1type = $row1[0];
	$r1amount = $row1[1];
	$r1stock = $row1[2];
	$r1user = $row1[3];
	
echo "r1 : $r1type $r1amount $r1stock<br>";
	
	$q2 = myquery( "select
			type1, stock, price1, price2, user, creator1, product1, amount1
			from sales3
			where uniqueX = \"$ux2\"" );  // most recent
	
	$row2 = mysqli_fetch_row( $q2 );
	
	$r2type = $row2[0];
	$r2stock = $row2[1];
	$r2price1 = $row2[2];
	$r2price2 = $row2[3];
	$r2user = $row2[4];
	$r2amount = $row2[7];
	
echo "r2 : $r2type $r2stock $r2price1  $r2price2<br>";
	
	$r1sends = 0;
	$r2sends = 0;
	$oddsend = "";
	if( $r1type == "buy" && $r2type == "sell" )						//"1"
	{
		// echo "r1 : buy  r2: sell <br>";
		
		if( $r1amount > $r2stock )					//12 > 10
		{
			$r1sends = $r2stock * $r2price1;		//10 * 0.7 = 7
			$oddsend = 1;
			$r2sends = $r2stock;					//10
			if ( $r1sends > $r1stock )				//7 > 1.3
			{
				$r1sends = $r1stock;				//1.3
				$r2sends = $r1stock * $r2price2;	//1.3 * 1.42
				$oddsend = 2;
			}
		}
	
		if ( $r1amount < $r2stock )					//( 2 < 10 )
		{
			$r1sends = $r1amount * $r2price1;		//( 1.4 )
			$oddsend = 1;
			$r2sends = $r1amount;					//( 2 )
			if ( $r1sends > $r1stock )				//( 1.4 > 1.3 )
			{
				$r1sends = $r1stock;				//( 1.3 )
				$r2sends = $r1stock * $r2price2;		//( 1.3 * 1.42 )
				$oddsend = 2;
			}
		}
	}

// 	ux	user	pr1		pr2		price1	price2	type	date1	date2	amount	stock
// 	1	ub		usd		eur		0.7		1.42	sell					10		10
// 	2	uc		eur		usd		1.33	0.75	sell					 2		 2

	if ( $r1type == "sell" && $r2type == "sell" )					//"2"
	{
		// echo "r1 : sell  r2: sell <br>";
		
		if( ( $r1stock * $r2price2 ) < $r2stock )		//2 * 1.42 < 10
		{
			$r1sends = $r1stock;						//2
			$r2sends = $r1stock * $r2price2;			//2.84
			$oddsend = 2;
		}
		if( ( $r1stock * $r2price2 ) > $r2stock )		//20 * 1.42 > 10
		{
			$r1sends = $r2stock * $r2price1;			//10 * 0.7 = 7
			$oddsend = 1;
			$r2sends = $r2stock;						//10
		}
	}

// 	ux	user	pr1		pr2		price1	price2	type	date1	date2	amount	stock
// 	1	ub		usd		eur		0.7		1.42	sell					10		10
// 	2	uc		eur		usd		1.33	0.75	sell					 2		 2
	
	if ( $r1type == "sell" && $r2type == "buy" )					//"3"
	{
		// echo "r1 : sell  r2: buy <br>";
		
		if( ( $r1stock * $r2price2 ) < $r2stock )		//2 * 1.42 < 10
		{
			$r1sends = $r1stock;						//2
			$r2sends = $r1stock * $r2price2;			//2.84
			$oddsend = 2;
		}
		if( ( $r1stock * $r2price2 ) > $r2stock )		//20 * 1.42 > 10
		{
			$r1sends = $r2stock * $r2price1;			//10 * 0.7 = 7
			$oddsend = 1;
			$r2sends = $r2stock;						//10
		}
	}
	
// 	ux	user	pr1		pr2		price1	price2	type	date1	date2	amount	stock
// 	1	ub		usd		eur		0.7		1.42	sell					10		10
// 	2	uc		eur		usd		1.33	0.75	sell					 2		 2
	
	if ( $r1type == "buy" && $r2type == "buy" )					//"4"
	{
		if ( $r1amount < $r2stock )					// 2 < 10
		{
echo "$r1amount < $r2stock<br>";
			$r1sends = $r1amount * $r2price1;		//2 * 1.33
			$oddsend = 1;
			$r2sends = $r1amount;
			if( $r1sends > $r1stock )
			{
echo "$r1sends > $r1stock<br>";
				$r1sends = $r1stock;
				$r2sends = $r1stock * $r2price2;
				$oddsend = 2;
			}
		}
		if ( $r1amount > $r2stock )
		{
			$r1sends = $r2stock * $r2price1;
			$oddsend = 1;
			$r2sends = $r2stock;
			if ( $r1sends > $r1stock )
			{
				$r1sends = $r1stock;
				$r2sends = $r1stock * $r2price2;
				$oddsend = 2;
			}
		}
	}

echo "oddsends : $oddsend<br>";
echo "r1sends : $r1sends r2sends : $r2sends<br>";

$r1sends_orig = $r1sends ;
$r2sends_orig = $r2sends ;

	$oddnum = 0;
	$odduser = "";
	
	if( $oddsend == 1 )
	{
		$oddnum = $r1sends;
		$odduser = $r1user;
	}
	if( $oddsend == 2 )
	{
		$oddnum = $r2sends;
		$odduser = $r2user;
	}

	$xn1 =  floor( $oddnum * 1000 ) / 1000;
	
	$wouldsend = $oddnum - $xn1;
	// echo sprintf("%01.20f", $wouldsend) . "<br>";

	$test1 = $wouldsend * 1000000000;
	
	$test1 =  floor( $test1 );
	
	$doessend = "0";
	$xr = 0;
	if ( $test1 >= 1 )
	{
		$xr = rand ( 1 , 1000000 );
		if( $xr <= $test1 )
		{
			// echo "the odd sender sends 0.001<br>";
			$doessend = 0.001;
		}
		// echo " rn : $xr test: $test1  $odduser   $wouldsend   $doessend<br>";

		// echo "r1sends : $r1sends r2sends : $r2sends<br>";

		if( $oddsend == 1 )
		{
			// echo "r1sends 1 : $r1sends<br>";
			$r1sends = $r1sends - $wouldsend;
			// echo "r1sends 2 : $r1sends<br>";
			$r1sends = $r1sends + $doessend;
			// echo "r1sends 3 : $r1sends<br>";
		}
		if( $oddsend == 2 )
		{
			// echo "r2sends 1 : $r2sends<br>";
			$r2sends = $r2sends - $wouldsend;
			// echo "r2sends 2 : $r2sends<br>";
			$r2sends = $r2sends + $doessend;
			// echo "r2sends 3 : $r2sends<br>";
		}
	}
	// echo "<br>";
	// echo "r1sends : $r1sends r2sends : $r2sends<br>";
	
	$dateTime = date("y-m-d H:i:s",time());
	
	$query = "INSERT INTO tradelog
	( trade1ux, user1, creator1, product1, amount1, price1,
      trade2ux, user2, creator2, product2, amount2, price2, 
      dateTime,
	  odduser, wouldsend, doessend
	)
	values
	( \"$ux1\", \"$r1user\", \"$row1[4]\", \"$row1[5]\", \"$r1sends\", \"$r2price1\",
	  \"$ux2\", \"$r2user\", \"$row2[5]\", \"$row2[6]\", \"$r2sends\", \"$r2price2\",  
	  \"$dateTime\",
	  \"$odduser\", \"$wouldsend\", \"$doessend\" )";
	
	// echo $query;
	
	my2query( $query );

	include_once( "sendproduct.php" );
	
	if( $r1sends_orig > 0 )
	{
		if( $r1sends > 0 )
		{
			$send1 = sendproduct($r1user, $row1[4], $row1[5], $r1sends, $r2user, "trade" );
		}
		if( $r1type == "sell" )
		{
			updatesale( $ux1, ( $r1amount - $r1sends_orig ) );
		}
		if( $r1type == "buy" )
		{
			updatesale( $ux1, ( $r1amount - $r2sends_orig ) );
		}
		if( $r1sends > 0 )
		{
			subtractstock( $r1user, $row1[4], $row1[5], $r1sends );
		}
	}
	
	if( $r2sends_orig > 0 )
	{
		if( $r2sends > 0 )
		{	
			$send2 = sendproduct($r2user, $row2[5], $row2[6], $r2sends, $r1user, "trade" );
		}

		if( $r2type == "sell" )
		{
			updatesale( $ux2, ( $r2amount - $r2sends ) );
		}
		if( $r2type == "buy" )
		{
			updatesale( $ux2, ( $r2amount - $r1sends ) );
		}
		if( $r2sends > 0 )
		{	
			subtractstock( $r2user, $row2[5], $row2[6], $r2sends );
		}
	}
	
	if( $r2sends > 0 )
	{
		addstock( $r2user, $row1[4], $row1[5] );
	}
	if( $r1sends > 0 )
	{
		addstock( $r1user, $row2[5], $row2[6] );
	}
}


function subtractstock( $user, $crea, $product, $subtract )
{
	 // echo "subtractstock args $user, $crea, $product, $subtract  <br>";

	// showhowmuch might be adding stock...
	
	include_once( "listtrades.php" );
	
	$q1 = myquery( "select
			type1, amount1, stock, price2, uniqueX
			from sales3
			where creator1 = \"$crea\" and product1 = \"$product\" and user = \"$user\"
			order by datetime desc" );

	while( $rowa = mysqli_fetch_array( $q1 ) )
	{
		// echo "$user $rowa[0] $rowa[1] $rowa[2] $rowa[3]<br>";

		$type = $rowa[0];
		// $amount = $rowa[1];
		$stocka = $rowa[2];
		// $price2 = $rowa[3];
		$ux = $rowa[4];
		
		// echo "stocka : $stocka<br>";

		$stock = $stocka - $subtract;
		
		// echo "stocka2: $stock<br>";
		
		if( $stock < 0 )
		{
			$stock = 0;
		}

		// if( $type == "sell" )  //...sell
		// {
			// $total = showhowmuch( $user, $crea, $product, $amount );
		
			// if ( $total >= $rowa[1] )
			// {
				// $stock = $amount;
			// }
			// if ( $total < $rowa[1] )
			// {
				// $stock = $total;
			// }
		// }

		// if( $type == "buy" )
		// {
			// $total = showhowmuch( $user, $crea, $product, $amount * $price2 ); 

			// if ( $total > ( $amount * $price2 ) )  //amount * price2
			// {
				// $stock = $amount * $price2;
			// }
			// if ( $total <= $amount * $price2  )
			// {
				// $stock = $total;
			// }
		// }
		// echo "stock : $stock stocka : $stocka <br>";
		if( $stock != $stocka )
		{
			// echo "update subtract<br>";
			my2query( "update sales3 set stock = \"$stock\" where uniqueX = \"$ux\"" );
		}
	}
}


function updatesale( $ux, $amount )
{
	// echo "updatesale args $ux, $amount <br>";
	
	if( $amount <= 0 )
	{
 		myquery( "delete from sales3 where uniqueX = \"$ux\"" );
	}
	else
	{
 		my2query( "update sales3 set amount1 = \"$amount\" where uniqueX = \"$ux\"" );
	}
}

?>