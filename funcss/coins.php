<?php

include_once( "funcs.php" );


function coinbuy( $name, $amount ) // buy mbtc products
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	include_once '../sitename.inc';
	$check1 = check_string( "username", $coinPageCreator );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $coinPageHolder );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $coinPageProduct );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );
	
	echo "$amounthhhhhh<br>";
	echo "$amount<br>";
	
	if ( ( $amount ) < 0.001 )
	{
		return "number too small";
	}
	
	//	getrunintotal
	$olrunintotal = getrunintotal2($name);
		
	$amount2 = $amount * -0.001;
		
	$runintotal = $olrunintotal + $amount2;

	
	$available = $runintotal;
	if ( ($amount/1000) > $available )
	{
		return "insufficient funds";
	}
	$date1 = date("y-m-d H:i:s");
	

	$result4 = my2query( "INSERT INTO expenses2
				( user, amount, address, runintotal, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"bought products\", \"$runintotal\", \"$date1\" )" );

	include_once( "sendproduct.php" );
	
//	echo sendproductbalance( "holder", "bitcoin", "mBTC", $amount, $name,"coinbuy" );
//	sendproductbalance( "coins", "coins", "mBTC", $amount, $name,"coinbuy" );
	echo sendproductbalance( $coinPageHolder, $coinPageCreator, $coinPageProduct, $amount, $name,"coinbuy" );

	return "okay";
}


function coinsell( $name, $amount ) // sell mbtc products
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	include_once '../sitename.inc';
	$check1 = check_string( "username", $coinPageCreator );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $coinPageHolder );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $coinPageProduct );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );

	echo "$amount<br>";
	$amount = trimtoxdp( $amount, 3 );
	echo "$amount<br>";
	
	include_once( "../funcss/listtrades.php" );

//	$available = showHowMuch2( "bitcoin", "mBTC", $name );
//	$available = showHowMuch2( "coins", "mBTC", $name );
//	$available = getQuickBalance( $name );
	$available = showHowMuch2( $coinPageCreator, $coinPageProduct, $name );

	if ( $amount > $available )
	{
		return "insufficient funds";
	}


	$olrunintotal = getrunintotal2($name);
		
	$amount2 = $amount * 0.001;
	
	$runintotal = $olrunintotal + $amount2;
	
	$date1 = date("y-m-d H:i:s");

	$result4 = my2query( "INSERT INTO expenses2
				( user, amount, address, runintotal, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"sold products\", \"$runintotal\", \"$date1\" )" );
				
				
	$amount2 = $amount / 1000;
	include_once( "sendproduct.php" );
//	sendproductbalance( $name, "bitcoin", "mBTC", $amount, "holder","coinsell" );
//	sendproductbalance( $name, "coins", "mBTC", $amount, "coins","coinsell" );
	sendproductbalance( $name, $coinPageCreator, $coinPageProduct, $amount, $coinPageHolder, "coinsell" );

	return "okay";
}


function getQuickBalance( $name )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}

	return getrunintotal2($name) * 1;
}


function beforetimemins( $datetime, $mins ) // have mins passed since date and now 
{
	//~ echo "bftm $datetime, $mins <br>";

	$vars = "PT". $mins . "M";
	$dt1 = new DateTime( $datetime );
	$dt2 = new DateTime(date("Y-m-d H:i:s") );

	$dt2->sub(new DateInterval( $vars ));


	if ( $dt2 > $dt1 )
	{
		//~ echo "$mins minutes have passed <br>";
		return  "passed";
	}

	//~ echo "$mins minutes have not passed <br>";
	//~ echo "dt2 ".$dt2->format('Y-m-d H:i:s') . "<br>";
	return "notpassed";
}


function drawCode2( $addr )
{
	include_once( '../phpqrcode/dex2.php' );
	$var1 = drawCode( '../grui2/qrcodes', $addr );

	return $var1;
}


function getAddress( $name )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}

	$q1 = myquery( "select
			address, code
			from addressesinuse
			where user = \"$name\" 
			order by uniqueX desc limit 1 " );

	$row = mysqli_fetch_row( $q1 );
	if($row != null )
	{
		$array = array( "okay", $row[0], $row[1] );
		return $array;
	}
	else	// getnew address
	{
		$arr = getNewAddress( $name );

		return $arr;
	}
}


function getNewAddress( $name )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}

	$qb = myquery( "select
		date
		from addressesinuse
		where user = \"$name\"
		order by uniqueX desc limit 1 " );

	$timehas = "passed";
	$rowb = mysqli_fetch_row( $qb );

	if( $rowb != null )
	{
		$previous = $rowb[0];
		$timehas = beforetimemins( $rowb[0], 1 );
	}

	if( $timehas == "notpassed" )
    {
        $arr = array(
                "wait",
                 "asfdsfsafa",
                   "asddsa");

		return $arr;
    }
	if( $timehas == "passed" )
    {    
		addaddress();
	    $q1 = myquery( "select
			    address
			    from addresslist
			    where status != \"used\" 
			    order by uniqueX limit 1 " ); //and uniqueX = \"10101\"

	    $row = mysqli_fetch_row( $q1 );

	    if($row != null )
	    {
		    $code = drawCode2( $row[ 0 ] );
		    $date1 = date("y-m-d H:i:s");

		    $result4 = my2query( "INSERT INTO addressesinuse 
						    ( user, address, code, date ) 
						    VALUES 
						    ( \"$name\", \"$row[0]\", \"$code\", \"$date1\" )" );

		    my2query( "update addresslist set
			    status = \"used\",
			    user = \"$name\"
			    where address = \"$row[0]\"" );

        	$arr = array(
                "okay",
                 $row[ 0 ],
                   $code);

		    return $arr;
	    }
	    else
	    {
        	$arr = array(
                "no",
                 "",
                   "");

		    return $arr; // "no more new addresses"
	    }
    }
}


function checkAddress($address)
{
//	echo "ch";
    $origbase58 = $address;
    $dec = "0";

    for ($i = 0; $i < strlen($address); $i++)
    {
        $dec = bcadd(bcmul($dec,"58",0),strpos("123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz",substr($address,$i,1)),0);
    }

    $address = "";

    while (bccomp($dec,0) == 1)
    {
        $dv = bcdiv($dec,"16",0);
        $rem = (integer)bcmod($dec,"16");
        $dec = $dv;
        $address = $address.substr("0123456789ABCDEF",$rem,1);
    }

    $address = strrev($address);

    for ($i = 0; $i < strlen($origbase58) && substr($origbase58,$i,1) == "1"; $i++)
    {
        $address = "00".$address;
    }

    if (strlen($address)%2 != 0)
    {
        $address = "0".$address;
    }

    if (strlen($address) != 50)
    {
        return false;
    }

    if (hexdec(substr($address,0,2)) > 0)
    {
        return false;
    }

    return substr(strtoupper(hash("sha256",hash("sha256",pack("H*",substr($address,0,strlen($address)-8)),true))),0,8) == substr($address,strlen($address)-8);
}


function checkrpc()
{
	include( "../dbdets.inc" );

	require_once('easybitcoin.php');
	$bitcoin = new Bitcoin( $rpcuser, $pass1 );

	$var1 = $bitcoin->getinfo();
	$var2a = $var1['version'];

	echo "1 " . $var1['version'];
	echo " 2 " . $var1['balance'];
	echo " 3 " . $var1['blocks'];
	
	if( $var2a == "" )
	{
		return "server not running";
	}
	return "okay";
}


function getrecentprice()
{
//	echo "1<br>";
	$q1 = myquery( "select
			thevalue, datetime
			from valuepairs
			where thekey = \"usdbtc\" 
			order by datetime desc limit 1 " );
			
	$row = mysqli_fetch_row( $q1 );

	if($row != null )
	{
//		echo "2<br>";
		$date1 = date("Y-m-d H:i:s");
		$date2 = $row[1];
		$diff = strtotime($date1) - strtotime($date2);
//		echo "2b $diff<br>";
		
		if( $diff < 300 )
		{
//			echo "3<br>";
			$q2 = myquery( "select
					thevalue, datetime
					from valuepairs
					where thekey = \"eurusd\" 
					order by datetime desc limit 1 " );

			$row2 = mysqli_fetch_row( $q2 );
			if( $row2 != null )
			{
//				echo "4<br>";
				$date3 = $row2[1];
//				echo "4a strtotime($date1) - strtotime($date3)<br>";
				$diff2 = strtotime($date1) - strtotime($date3);
//				echo "4b $diff2<br>";
				if( $diff2 < 6000 )
				{
//					echo "5  $diff2 < 6000<br>";
					$var1 = $row[0] / $row2[0];

					$var1 = trimtodp( $var1 );

					$varr[0] = $var1;
					$varr[1] = $diff;

					
					return $varr;
				}
			}
		}
	}
//	echo "6<br>";
	
	$varr[0] = trimtodp(getnewprice());//"0.45";
	//$varr[0] = 51;
	$varr[1] = "0";
	return $varr;
}


function getrecentpricekrak()
{
//	echo "1<br>";
	$q1 = myquery( "select
			thevalue, datetime
			from valuepairs
			where thekey = \"btceur\" 
			order by datetime desc limit 1 " );
			
	$row = mysqli_fetch_row( $q1 );

	if($row != null )
	{
//		echo "2<br>";
		$date1 = date("Y-m-d H:i:s");
		$date2 = $row[1];
		$diff = strtotime($date1) - strtotime($date2);
//		echo "2b $diff<br>";
		
		if( $diff < 300 )
		{
			$var1 = trimtodp( $row[0] );

			$varr[0] = $var1;
			$varr[1] = $diff;

			
			return $varr;
		}
	}
	
	$varr[0] = trimtodp(getnewpricekrak());
	$varr[1] = 0;
	return $varr;
}


function getnewprice()
{
//	echo "11<br>";
	$date1 = date("Y-m-d H:i:s");
	$q1 = myquery( "select
					thevalue, datetime
					from valuepairs
					where thekey = \"eurusd\" 
					order by datetime desc limit 1 " );

	$eurusd = '';
			
	$row = mysqli_fetch_row( $q1 );

	if($row == null )
	{
		$eurusd = geteurusd();
		$q2 = my2query( "INSERT INTO valuepairs 
					( thekey, thevalue, datetime ) 
					VALUES 
					( \"eurusd\", \"$eurusd\", \"$date1\")" );
	}
	else
	{
		$var3 = $row[1];
		$diff = strtotime($date1) - strtotime($var3);
//		echo $diff;
		if( $diff > 6000 )
		{
//			echo "newprice<br>";
			$eurusd = geteurusd();
			//insert into valuepairs ( eurusd var5 datetime )
			$q2 = my2query( "INSERT INTO valuepairs 
						( thekey, thevalue, datetime ) 
						VALUES 
						( \"eurusd\", \"$eurusd\", \"$date1\")" );
		}
		else
		{
//			echo "olprice<br>";
			$eurusd = $row[0];
		}
	}
	$usdbtc = 0.001 * getbitprice();
	$q2 = my2query( "INSERT INTO valuepairs 
				( thekey, thevalue, datetime ) 
				VALUES 
				( \"usdbtc\", \"$usdbtc\", \"$date1\")" );
	$eurbtc = $usdbtc / $eurusd;
	return $eurbtc;
}



function getnewpricekrak()
{
//	return 1.02;
	$date1 = date("Y-m-d H:i:s");
	$btceur = 0.001 * getkrakprice();
	$q2 = my2query( "INSERT INTO valuepairs 
				( thekey, thevalue, datetime ) 
				VALUES 
				( \"btceur\", \"$btceur\", \"$date1\")" );

	return $btceur;
}

function getbitprice()
{
//		return 620;
//	echo "usdbtc<br>";
	$url = "https://www.bitstamp.net/api/ticker/";
	$data = file_get_contents( $url );
//	echo $data;

	$pieces = explode("\"", $data);

	return $pieces[7];
}

function getkrakprice()
{
	//~ echo "<br>krak pirce<br>";
	$url = "https://api.kraken.com/0/public/Ticker?pair=xbteur";
	$data = file_get_contents( $url );
//	echo $data;

	$pieces = explode("\"", $data);

//	echo '<br>' . $pieces[9];
//	echo '<br>' . $pieces[15];
	$ans = $pieces[9] + $pieces[15];
	$ans = $ans / 2;
	
//	echo '<br>' . $ans;
	return $ans;
}

function geteurusd()
{
//	echo "eurusd<br>";
//	return 1.34;
	$url = "https://www.bitstamp.net/api/eur_usd/";
	$data = file_get_contents( $url );
//	echo $data;

	$pieces = explode("\"", $data);

	//~ echo "\n";
	//~ echo $pieces[3];
	//~ echo "\n";
	//~ echo $pieces[7];
	//~ echo "\n";

	$var = $pieces[7] - $pieces[3];
//	echo "qw".$var. "wq\n";
	$var = $pieces[7] - ($var/2);

//	echo "qw".$var. "wq\n";

	return $var;
}

 
function euro2coin( $amount, $name1, $percent )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $percent );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );

//	$var1 = 0.481234; //getnewprice()
	$var1 = getnewpricekrak();
	$var2 = $var1 * ( 1 + ($percent * 0.01 ) );  //~0.49
	$var3 = $var2 * $amount;   //~eur4.9023764498

	$var4 = rounditup( $var3 );// ~eur4.903

	include_once '../sitename.inc';
	include_once( "../funcss/listtrades.php" );
	$available = showHowMuch2( $coinPageCreator, $coinPageEuro, $name1 );

	if ( $var4 > $available )
	{
		return "insufficient funds";
	}
	
	$var5 = rounditrand( $var3 );

	include_once( "sendproduct.php" );
	echo sendproductbalance( $name1, $coinPageCreator, $coinPageEuro, $var5, $coinPageHolder, "cointrade" );
	echo "<br> "; 
	echo sendproductbalance( $coinPageHolder, $coinPageCreator, $coinPageProduct, $amount, $name1, "cointrade");

	echo "<br> "; 
	echo "$name1, $coinPageCreator, $coinPageEuro, $var5, $coinPageHolder  <br> "; 
	echo "var1 $var1, var2 $var2, var3 $var3, var4 $var4, var5 $var5<br> "; //, var4 $var4, var5 $var5, var6 $var6, var7 $var7

//	return array price percent priceplus05 amount var6 

	$varr[0] = 'okay';
	$varr[1] = $var1;
	$varr[2] = $percent;
	$varr[3] = $var2;
	$varr[4] = $amount;
	$varr[5] = $var5;

	return $varr;
}

function coin2euro( $amount, $name1, $percent )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $percent );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );

//	$var1 = 0.481234; //getnewprice()
	$var1 = getnewpricekrak();
	$var2 = $var1 * ( 1 - ($percent * 0.01 ) );  //~0.49
	$var3 = $var2 * $amount;   //~eur4.9023764498

	$var4 = rounditup( $var3 );// ~eur4.903

	include_once '../sitename.inc';
	include_once( "../funcss/listtrades.php" );
	$available = showHowMuch2( $coinPageCreator, $coinPageEuro, $name1 );

	if ( $amount > $available )
	{
		return "insufficient funds";
	}

	$var5 = rounditrand( $var3 );

	include_once( "sendproduct.php" );
	echo sendproductbalance( $name1, $coinPageCreator, $coinPageProduct, $amount, $coinPageHolder, "cointrade" );
	echo "<br> ";
	echo sendproductbalance( $coinPageHolder, $coinPageCreator, $coinPageEuro, $var5, $name1, "cointrade");

	echo "<br> "; 
	echo "$name1, $coinPageCreator, $coinPageEuro, $var5, $coinPageHolder  <br> "; 
	echo "var1 $var1, var2 $var2, var3 $var3, var4 $var4, var5 $var5<br> "; //, var4 $var4, var5 $var5, var6 $var6, var7 $var7

//	return array price percent priceplus05 amount var6 

	$varr[0] = 'okay';
	$varr[1] = $var1;
	$varr[2] = $percent;
	$varr[3] = $var2;
	$varr[4] = $amount;
	$varr[5] = $var5;

	return $varr;
}


function addaddress()
{
//	echo "add address!";
	$var1 = checkrpc();
	if( $var1 != "okay" )
	{
		return $var1;
	}
	include( "../dbdets.inc" );
	require_once('easybitcoin.php');
	
	$bitcoin = new Bitcoin( $rpcuser, $pass1 );

	$var3 = $bitcoin->getnewaddress();
	$var2a = $var3;
	
	if( $var2a == "" )
	{
		return "address is blank";
	}
	$date1 = date("Y-m-d H:i:s");
	$q2 = my2query( "INSERT INTO addresslist 
					( address, datetime ) 
					VALUES 
					( \"$var2a\", \"$date1\" )" );
	return "new:" . $var2a . ":new";
}

function sendamount( $amount, $destination, $name1 )
{
	echo "sendamount( $amount, $destination $name1 )<br>";
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "coinamount", $amount );if ($check1 != "okay" ){ return $check1;}
	$amount = trimtoxdp( $amount, 8 );

	if ( checkAddress($destination) == false )
	{
		return "bad address";
	}

	$available = getQuickBalance( $name1 );
	$txfee = 0.0001;
	$amount2 = $amount + $txfee;
	if ( $amount2 > $available )
	{
		return "insufficient funds";
	}

	$olrunintotal = getrunintotal2($name1);
	$runintotal = $olrunintotal - $amount2;
//	echo "$amount2 = $amount + $txfee;  $runintotal = $olrunintotal - $amount2;";
	$date1 = date("y-m-d H:i:s");

	$q2 = my3query( "INSERT INTO withdrawals
					( amount, user, address, state, datetime1 )
					VALUES 
					( \"$amount\", \"$name1\",\"$destination\",\"pending\", \"$date1\" )" );

	$q2 = my2query( "INSERT INTO expenses2
					( amount, user, type, address, runintotal, datetime, ttxid )
					VALUES 
					( \"$amount2\", \"$name1\", \"withdrawal-pending\", \"$destination\", \"$runintotal\", \"$date1\", \"$q2\" )" );

	sendtransactions();

	return "okay";
}

function getrunintotal2( $name )
{
	$olrunintotal = 0;
	$q2 = myquery( "select
		runintotal
		from expenses2
		where user = \"$name\"
		order by datetime desc limit 1 " );

	$rowb = mysqli_fetch_row( $q2 );

	if( $rowb != null )
	{
		$olrunintotal = $rowb[0];
	}

	return $olrunintotal;
}


function sendtransactions()
{
	$var = checkrpc();

	if( $var == "server not running" )
	{
		return "no service<br>";
	}
	echo "getinfo server is running<br>";
	
	
	$date1 = date("Y-m-d H:i:s");

	$q1 = myquery( "select
					amount, address, uniqueX
					from withdrawals
					where state = \"pending\" 
					order by datetime1" );
			
	while( $row2 = mysqli_fetch_array( $q1 ) )
	{
		echo $row2[1] . "  " .  $row2[0] . "  ...<br>";
		
		include( "../dbdets.inc" );
		require_once('easybitcoin.php');
		$bitcoin = new Bitcoin( $rpcuser, $pass1 );
	  
		$var1 = $bitcoin->sendtoaddress( $row2[1], $row2[0]*1 ); // destination, amount

		$state2 = "";
		$message2 = "";

		if( $var1 == null )
		{
			//~ echo $bitcoin->error;
			$state2 = "pending";
			$message2 = $bitcoin->error;
		}
		//else
		{
			//~ echo $var1;
			$state2 = "sent";
			$message2 = $var1;
			echo "update expenses2 set
					type = \"withdrawal\"
					where ttxid = \"$row2[2]\"and 
					type = \"withdrawal-pending\" <br>";
					
			my2query( "update expenses2 set
					type = \"withdrawal\"
					where ttxid = \"$row2[2]\"and 
					type = \"withdrawal-pending\" " );
		}
		echo "$state2 $message2<br>";

	    my2query( "update withdrawals set
			    state = \"$state2\",
			    message = \"$message2\",
			    datetime2 = \"$date1\"
			    where uniqueX = \"$row2[2]\"" );
	}

	return "okay";	
}



function notify3( $txid )
{
	echo "<br>notify3( $txid )<br>";

	include( "../dbdets.inc" );
	require_once('easybitcoin.php');
	
	//~ $txid = "6d57dc3474e90d348372de0c2033e52d2ee652a5be787dae872f6cc3daf4161b";
	//~ $txid = "778665a483eb70f1336510bc5f158ece392cc1d9b1063c7f9723a366845e4cbd";
	
	$bitcoin = new Bitcoin( $rpcuser, $pass1 );
	$var1 = $bitcoin->gettransaction( $txid );

	$date1 = date("Y-m-d H:i:s");
	echo "error:<br>" . $bitcoin->error . "<br>";


	$date1 = date("Y-m-d H:i:s", $var1[time]);
	$date2 = date("Y-m-d H:i:s", $var1[blocktime]);

	echo "var   : " . $var1[amount] . "<br>";
	echo "var   : " . $var1[confirmations] . "<br>";
	echo "time  : " . $var1[time] . "<br>";
	echo "time2 : " . $date1 . "<br>";
	echo "time3 : " . $date2 . "<br>";
	echo "var   : " . $var1[details][0][address] . "<br>";
	
	$varr[0] = 'okay';
	$varr[1] = $bitcoin->error;
	$varr[2] = $var1[amount];
	$varr[3] = $var1[confirmations];
	$varr[4] = $var1[details][0][address];

	return $varr;
	echo "notify3 : end<br>";
}


function notify4( $txid )
{
	echo "<br>notify4( $txid )<br>";
	$varr = notify3( $txid );
	
	echo "0 " . $varr[0] . " <br>";
	echo "1 " . $varr[1] . " <br>";
	echo "2 : amount  : " . $varr[2] . " <br>";
	echo "3 : confs   : " . $varr[3] . " <br>";
	echo "4 : address : " . $varr[4] . " <br>";
	echo "5 " . $varr[5] . " <br>";
	
	if ( ($varr[2] * 1 ) <= 0 )
	{
		echo "negative or zero amount<br>";
		return "okay1";
	}
	else
	{
		echo "positive <br>";
	}


	$date1 = date("Y-m-d H:i:s");

//	$amount = 0.7;
	$amount = $varr[2];

//	$address = "1AaQmAtwdF6Lz5RVdT62eX5KcAd3BxJsrh";
	$address = $varr[4];
	
//	$confirmations = 3;
	$confirmations = $varr[3];

//	$txid = "3e09";

//	get user from address
	$user1 = "";
	$q1 = myquery( "select
				user
				from addressesinuse
				where address = \"$address\" 
				limit 1" );

	$row = mysqli_fetch_row( $q1 );

//	return "okay2";
	if($row != null )
	{
		$user1 = $row[0];
	}

	$depositrow = "";
//	if confs = 0

	$olrunintotal = getrunintotal2($user1);
	$runintotal = $olrunintotal;

	if ( $confirmations == 0 )
	{
//		select uniqueX from deposits where txid = txid
		$q1 = myquery( "select
					uniqueX, starttime
					from deposits
					where txid = \"$txid\" 
					limit 1" );

		$row = mysqli_fetch_row( $q1 );
 
 //amount, address, user, confirmations, txid     startdate enddate update

		if($row == null )
		{
//			depositrow = insert to deposit
			$depositrow = my3query( "INSERT INTO deposits
							( amount, address, user, confirmations, txid, starttime, updatetime )
							VALUES 
							( \"$amount\", \"$address\", \"$user1\", \"$confirmations\", \"$txid\", \"$date1\", \"$date1\" )" );

//			insert to expenses: unconfirmed, depositrow
			$q2 = my2query( "INSERT INTO expenses2
						( amount, user, type, address, ttxid, runintotal, datetime )
						VALUES 
						( \"$amount\", \"$user1\", \"deposit-unconfirmed\", \"$address\", \"$depositrow\", \"$runintotal\", \"$date1\" )" );
//set start date						
		}
		else
		{
//			update deposits
			my2query( "update deposits set
						amount = \"$amount\",
						address = \"$address\",
						user = \"$user1\",
						confirmations = \"$confirmations\",
						txid = \"$txid\",
						updatetime = \"$date1\"
						where uniqueX = \"$row[0]\"" );
//set update date

			$depositrow = $row[0];
			$starttime = $row[1];
//			select from expenses2 where ttxid = depositrow
			$q2 = myquery( "select
						uniqueX
						from expenses2
						where ttxid = \"$depositrow\" and ( type = \"deposit-unconfirmed\" or type = \"deposit\" )
						limit 1" );

			$row2 = mysqli_fetch_row( $q2 );

			if($row2 == null )
			{
//				insert to expenses: deposit-unconfirmed, depositrow
				$q2 = my2query( "INSERT INTO expenses2
					( amount, user, type, address, ttxid, runintotal, datetime )
					VALUES 
					( \"$amount\", \"$user1\", \"deposit-unconfirmed\", \"$address\", \"$depositrow\", \"$runintotal\", \"$starttime\" )" );
			}
			else
			{
//				update expenses: deposit-unconfirmed, depositrow

				my2query( "update expenses2 set
						amount = \"$amount\",
						user = \"$user1\",
						address = \"$address\",
						type = \"deposit-unconfirmed\",
						ttxid = \"$depositrow\",
						runintotal = \"$runintotal\",
						datetime = \"$starttime\"
						where uniqueX = \"$row2[0]\"" );
			}
		}
	}


	if ( $confirmations > 0 )
	{
		$runintotal = $olrunintotal + $amount;

//		select uniqueX from deposits where txid = txid
		$q1 = myquery( "select
					uniqueX, endtime, confirmations
					from deposits
					where txid = \"$txid\"
					limit 1" );

		$row = mysqli_fetch_row( $q1 );

		if( $row == null )
		{
//			depositrow = insert to deposit
			$depositrow = my3query( "INSERT INTO deposits
							( amount, address, user, confirmations, txid, starttime, endtime, updatetime )
							VALUES 
							( \"$amount\", \"$address\", \"$user1\", \"$confirmations\", \"$txid\", \"$date1\", \"$date1\", \"$date1\" )" );

//			insert to expenses: confirmed, depositrow
			$q2 = my2query( "INSERT INTO expenses2
						( amount, user, type, address, ttxid, runintotal, datetime )
						VALUES 
						( \"$amount\", \"$user1\", \"deposit\", \"$address\", \"$depositrow\", \"$runintotal\", \"$date1\" )" );
		}
		else
		{
			if( $row[2] == 0 )
			{
				$endtime = $row[1];
				if( $endtime == null )
				{
					$endtime = $date1;
				}
	//			update deposits
				my2query( "update deposits set
							amount = \"$amount\",
							address = \"$address\",
							user = \"$user1\",
							confirmations = \"$confirmations\",
							txid = \"$txid\",
							updatetime = \"$date1\",
							endtime = \"$endtime\"
							where uniqueX = \"$row[0]\"" );

				$depositrow = $row[0];
	//			select from expenses2 where ttxid = depositrow
				$q2 = myquery( "select
							uniqueX
							from expenses2
							where ttxid = \"$depositrow\" and ( type = \"deposit-unconfirmed\" or type = \"deposit\" )
							limit 1" );

				$row2 = mysqli_fetch_row( $q2 );

				if($row2 == null )
				{
	//				insert to expenses: deposit, depositrow
					$q2 = my2query( "INSERT INTO expenses2
						( amount, user, type, address, ttxid, runintotal, datetime )
						VALUES 
						( \"$amount\", \"$user1\", \"deposit\", \"$address\", \"$depositrow\", \"$runintotal\", \"$endtime\" )" );
				}
				else
				{
	//				update expenses: deposit, depositrow
					echo "here<br>";
					my2query( "update expenses2 set
							amount = \"$amount\",
							user = \"$user1\",
							address = \"$address\",
							type = \"deposit\",
							ttxid = \"$depositrow\",
							runintotal = \"$runintotal\",
							datetime = \"$endtime\"
							where uniqueX = \"$row2[0]\" " );
				}
			}
			
			
		}
	}

	echo "okay<br>";
	return "notify end<br>";
}


function listtransactions( $name1, $startfrom, $results )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result7 = myquery( "select amount, address, datetime, runintotal, type
							from expenses2 where user = \"$name1\" 
							order by datetime desc limit $startfrom, $results" );

	$result5 = myquery( "select amount
							from expenses2
							where user = \"$name1\"" );

	$numrows = mysqli_num_rows( $result5 );
	
	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;

	while( $row2 = mysqli_fetch_array($result7) )
	{
		$messa[0] = $row2[0];
		$messa[1] = $row2[1];
		$messa[2] = $row2[2];
		$messa[3] = $row2[3];
		$messa[4] = $row2[4];

		$mess1[$i1] = $messa;
		$messa = null;
		$i1++;
	}
	
	return $mess1;
}


function walletvtable( $prevdif )
{
	echo "<br>wallet v table : start<br>";

	include( "../dbdets.inc" );
	require_once('easybitcoin.php');
	
	
	$result = myquery("SELECT SUM( amount ) AS value_sum FROM deposits "); 
	$row = mysqli_fetch_assoc( $result );
	$tableamount = $row['value_sum'];

	$bitcoin = new Bitcoin( $rpcuser, $pass1 );
	$walletamount = $bitcoin->getreceivedbyaccount ("", 1);

	echo "table : $tableamount  <br>wallet  : $walletamount<br>";


	$var1 = $bitcoin->listtransactions();

	echo "error:<br>" . $bitcoin->error . "<br>";

	foreach ( $var1 as &$value )
	{
		echo ": " . $value['category'] . " ";
		echo $value['amount'] . "<br>";
	}
	
	
	echo "<br>wallet v table : end<br>";
	return "okay<br>";
}


/*
qwertyhgfdsa



wallettotable()
{
	wbal = get wallet balance minconf=0
	tbal = get table  balance minconf=0
	tbal2 = tbal
	
	if( wbal > tbal )
	{
		get transactions
		while( next tx && wbal > tbal2 )
			if( tx amount > 0 )
				select from transactions where txid == txid
				if null
					txamount = txid.amount
					insert to trasactions txid date confirmations
					tbal2 = tbal2 + txamount	
	}
	select from trasactions where confirmations == 0 
	while( next row )
		get transaction where txid == txid
			if ( transaction.confirmations > 0 )
				update transaction where txid ==txid
}

deposits
amount address confirmations datetime1 datetime2

withdrawals
amount address state datetime1 datetime2

expenses
amount user type runintotal datetime

view
amount user type state(pending,unconfirmed) runintotal datetime


*/ 
?>

