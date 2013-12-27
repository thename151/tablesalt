<?php

include_once( "funcs.php" );

function balancetable()
{
	$count = 0;
	$change1 = "table unbalanced";
	while( $count < 25 && $change1 == "table unbalanced")
	{
		$change1 = balancetable2();
		$count = $count + 1;
	}
	if( $change1 == "table unbalanced" )
	{
		return "table unbalanced after $count tries";
	}
	if( $change1 == "table balanced" )
	{
		return "table balanced after $count tries";
	}
	return $change1;
}

function roundwdown( $n1, $f1 )
{
	$n1 = $n1 * $f1;
	
	$n1 = ( int )$n1 ;
	$n1 = $n1 / $f1;
		
	return $n1;
}

function balancetable2()
{
// 						include( "hilovalues.php" );
// 						echo "<br> " . roundwdown(0.1275, (1/$loscore ));
	$n2 = 0.012;
	$n3 = $n2 * 1000;

	$n3 = (int )$n3 ;
	$n3 = $n3 / 1000;
	
	echo "<br>new balance table 2 $n2 $n3<br>";
	
	// 	start with most recent
	// 	find cheapest price for it
	// 	if table is changed exit

	$tablechanged = "table balanced";
	$result = myquery( "select
			uniqueX,amount1,creator1,product1,amount2,creator2,product2,price1,price2,user,dateTime
			from sales2 order by datetime desc" );

	// rowa , most recent ( buyer )
	while( ($rowa = mysqli_fetch_array($result) ) && ( $tablechanged == "table balanced" ) )
	{
		// 	find cheapest price for it
		$crea1 = $rowa[2];
		$pname1 = $rowa[3];		#product1, the money
// 		echo "p1 $rowa[4] " . $rowa[3];
		
		$crea2 = $rowa[5];
		$pname2 = $rowa[6];		#product2, the thing
// 		echo "p2 " . $rowa[6];
		
		$sq1 = "select
		uniqueX,amount1,creator1,product1,amount2,creator2,product2,price1,price2,user,dateTime
		from sales2 where creator1 = \"$crea2\" and product1 = \"$pname2\"
		and creator2 = \"$crea1\" and product2 = \"$pname1\" order by price1";
		$result2 = myquery( $sq1 );

		// rowb , cheapest price for rowa, ( seller )
		while( ( $rowb = mysqli_fetch_array($result2) ) && ( $tablechanged == "table balanced" ) )
		{
			if( $rowa[9] == $rowb[9] ) // self trade
			{
			}
			else
			{
				// 				rowa8, buyer offers this much money for one thing
				// 				rowb7, seller asks  this much money for one thing
				// 				if money seller asks for is less than what buyer offers
				if( $rowb[7] <= $rowa[8] )
				{
					include_once( "listtrades.php" );

					//how much money has buyer
					$maxatprice = $rowb[7] * $rowa[4];
// 					$buyermoney = showhowmuch( $rowa[9], $crea1, $pname1, $rowa[1] );
					$buyermoney = showhowmuch( $rowa[9], $crea1, $pname1, $maxatprice );
					 // 0.92 eur
// 					echo "<br>buy " . $buyermoney . "qwe" . $rowa[9] . "<br>";
						
					//how many things has seller
					$sellerthings = showhowmuch( $rowb[9], $crea2, $pname2, $rowb[1] );
					 // 14 dollar
// 					echo "sell " . $sellerthings . "qwe" . $rowb[9];
					
					//if the buyer has money and the seller has things
					if( ($buyermoney > 0) && ($sellerthings > 0) )
					{
// 						echo" <br>here000 $sellerthings  $rowa[4] <br>";

						$ssendsb = 0;
						$bsendss = 0;

						if( $sellerthings >= $buyermoney )
						{
// 							echo" <br> $buyermoney here1 $rowa[4] <br>";
							
							//seller sends 1.3( rowa4 ) to buyer
							//buyer sends 0.92( buyermoney ) to seller
							$ssendsb = $buyermoney * $rowb[8];
							$bsendss = $buyermoney;
						}
						if( $sellerthings < $buyermoney ) //  seller only has .5 dollar 
						{   
							$rewq = $sellerthings * $rowb[7]; 
// 							echo "  $sellerthings here22 $rewq<br>";
							
							//seller sends .5( sellerthings ) to buyer
							//buyer sends .5 * .71 ( sellerthings * rowb7 ) to seller

							$ssendsb = $sellerthings;
							$bsendss = $rewq;
						}
						include( "hilovalues.php" );
// 						echo "<br> " . roundwdown(0.1275, (1/$loscore ));

						$ssendsb = roundwdown($ssendsb, (1 / $loscore ));
						$bsendss = roundwdown($bsendss, (1 / $loscore ));
							
						if( ( $bsendss < $loscore ) || ( $ssendsb < $loscore ) || ( $bsendss > $hiscore ) || ( $ssendsb > $hiscore ) )
						{
							// echo "<br>too small<br>";
							return "<br>too small<br>";
						}
						else
						{
							include_once( "sendproduct.php" );

// 							echo " <br>s1  $rowa[9], $crea1, $pname1, $bsendss, $rowb[9] <br> ";
// 							echo " <br>s2  $rowb[9], $crea2, $pname2, $ssendsb, $rowa[9] <br> ";
								
							$send1 = sendproduct($rowa[9], $crea1, $pname1, $bsendss, $rowb[9], "trade" );
							if($send1 != "product sent<br>")
							{
								return "send 1 failed : $send1";
							}
							$send2 = sendproduct($rowb[9], $crea2, $pname2, $ssendsb, $rowa[9], "trade" );
							if($send2 != "product sent<br>")
							{
								//reverse send 1
								return "send 2 failed : $send2";
							}
							
							$nm2a = $rowa[4] - $ssendsb;
							$nm1a = $nm2a * $rowa[8];  

							$nm2b = $rowb[4] - $bsendss;
							$nm1b = $nm2b * $rowb[8];
							if( ( $nm1a < $loscore ) || ( $nm2a < $loscore ) )
							{
								$nm1a = 0;
								$nm2a = 0;
							}
							if( ( $nm1b < $loscore ) || ( $nm2b < $loscore ) )
							{
								$nm1b = 0;
								$nm2b = 0;
							}
								
// 							echo "<br>end1 $nm1a, $nm2a <br>";
// 							echo "<br>end2 $nm1b, $nm2b <br>";
								
							updatesale3( $rowa[ 0 ], $nm1a, $nm2a );
							updatesale3( $rowb[ 0 ], $nm1b, $nm2b );

							return "table unbalanced";
						}
					}
					else
					{
						//do nothing,, out of stock
					}
				}
				else 
				{
					//do nothing, price too high
				}
			}
		}
	}
	return $tablechanged;
}




function updatesale3( $uX, $amount1, $amount2 )
{
	if(( $amount1 <= 0 ) || ( $amount2 <= 0 ))
	{
		myquery( "delete from sales2 where uniqueX = \"$uX\"" );
	}
	else
	{
		my2query( "update sales2 set amount1 = \"$amount1\" where uniqueX = \"$uX\"" );
		my2query( "update sales2 set amount2 = \"$amount2\" where uniqueX = \"$uX\"" );
	}
}
?>