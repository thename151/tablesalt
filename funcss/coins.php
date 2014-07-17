<?php

include_once( "funcs.php" );

function coinwraw( $name, $amount, $destination )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "coinamount", $amount );if ($check1 != "okay" ){ return $check1;}
	$amount = trimtoxdp( $amount, 8 );

	if ( checkAddress($destination) == false )
	{
		return "bad address";
	}

	$available = getQuickBalance( $name );
	$txfee = 0.0001;
	$amount2 = $amount + $txfee;
	if ( $amount2 > $available )
	{
		return "insufficient funds";
	}

//	getrunintotal
	$olrunintotal = getrunintotal($name);

	$runintotal = $olrunintotal - $amount2;

	$date1 = date("y-m-d H:i:s");

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, runintotal, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"$destination\", \"$runintotal\", \"$date1\" )" );

	$q1 = myquery( "select
			uniqueX
			from expenses
			where user = \"$name\" 
			order by uniqueX desc limit 1 " );

	$row = mysqli_fetch_row( $q1 );
	$ux = $row[0];

	settask( $amount, $destination, $ux );

	return "okay";
}


function settask( $amount, $destination, $ux )
{
	$date1 = date("y-m-d H:i:s");

	$file_handle = fopen("../tasks/todo/$ux.txt", "w");
	$file_contents = $amount . " ". $destination . " ". $date1;

	fwrite($file_handle, $file_contents);
	fclose($file_handle);
//	echo "file created and written to";
}


function getrunintotal( $name )
{
	$olrunintotal = 0;
	$q2 = myquery( "select
		runintotal
		from coinview
		where user = \"$name\"
		order by datetime desc limit 1 " );

	$rowb = mysqli_fetch_row( $q2 );

	if( $rowb != null )
	{
		$olrunintotal = $rowb[0];
	}

	return $olrunintotal;
}

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


function testexpenses( $name )
{
	$date1 = date("y-m-d H:i:s");
	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"2.5\", \"bought products\", \"$date1\" )" );
}

function queryAdd( $curradd )
{
	
	//~ return 0.07;
	
//	echo "queryAdd new<br>";
//	$curradd = '1Q5gjJcoDyi3nY5mg3B4EAKEJCLP65CRjC';
	//~ $curradd = 'sfsdfsdf';
	
    
	include( "../dbdets.inc" );

	require_once('easybitcoin.php');
	$bitcoin = new Bitcoin( $rpcuser, $pass1 );
 
	$var1a = $bitcoin->getinfo();
	$var2a = $var1a['version'];
	
	if( $var2a == "" )
	{
	//	echo "nogetinfo server not running \n";
		return 0;
	}
	//	echo "server  running \n";
	
	$var1 = $bitcoin->getreceivedbyaddress( $curradd );
	
	$var20 = $bitcoin->error;
	
	//~ echo "<br>error : " . $var20 . "<br>";
	//~ echo $var1;
	//~ return 0;
	
	if ( $var20 == "" )
	{
		return $var1;
	}
	else
	{
		return 0;
	}
}



function drawCode2( $addr )
{
	include_once( '../phpqrcode/dex2.php' );
	$var1 = drawCode( '../grui2/qrcodes', $addr );

	return $var1;
}


function fillTable()
{
	  	  $cars=explode(",",'
	  
	  1,"12PzvGbPk5eXBP9qyTXjgf1QF72qgrhpZu","5zzzzzzzzzz"
2,"1EtkzHX1v9H9vC4xfTtZX7qg8WZ8GEq65j","5zzzzzzzzz"
3,"15gEcsfCbaMKRpwSv6tyoD8XFwD5yNDVmh","5zzzzzzzz"

'
	  );

	$i2 = 1; 
	while ( $i2 < count( $cars ) )
	{
		echo $cars[$i2] . ",<br>";
		$i2 = $i2 + 2;
	}
}


function fillTable2()
{

	$cars=array(

"12PzvGbPk5eXBP9qyTXjgf1QF72qgrhpZu",
"19fwoqJPeP8FnC1SaVFt6VFJfZQVH8w8pt",
"1EkQKa4PwwUfH7cNMkTE4PZxBoeZtQfdXx"

	);	
	
	$i2 = 0; 
	while ( $i2 < count( $cars ) )
	{
		echo $cars[$i2] . "<br>";
		$result4 = my2query( "INSERT INTO addresslist 
						( address ) 
						VALUES 
						( \"$cars[$i2]\" )" );

		$i2 = $i2 + 1;
	}
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

function listtransactions( $name1, $startfrom, $results )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result7 = myquery( "select difference, address, datetime, runintotal, tablename
							from coinview where user = \"$name1\" 
							order by datetime desc limit $startfrom, $results" );


	$result5 = myquery( "select difference
							from coinview
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
		$price1 = $row[0];
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
			$price1 = $var2;
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

	$var1 = 0.481234; //getnewprice()
//	$var1 = getnewprice();
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

	$var1 = 0.481234; //getnewprice()
//	$var1 = getnewprice();
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
	echo "add address!";
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
//	$amount = trimtoxdp( $amount, 8 );

	if ( checkAddress($destination) == false )
	{
//		return "bad address";
	}

	$available = getQuickBalance( $name1 );
	$txfee = 0.0001;
	$amount2 = $amount + $txfee;
	if ( $amount2 > $available )
	{
//		return "insufficient funds";
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

//	sendtransactions();

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

	if( $var == "" )
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


function notify2( $txid )
{
	echo "<br>notify2( $txid )<br>";

	include( "../dbdets.inc" );
	require_once('easybitcoin.php');
	$bitcoin = new Bitcoin( $rpcuser, $pass1 );
	$var1 = $bitcoin->gettransaction( $txid );

	$date1 = date("Y-m-d H:i:s");
	echo "error:<br>" . $bitcoin->error . "<br>";

//	$amount = $var1[amount];
	$amount = 250.3;

//	$address = $var1[address];
	$address = "19yDE6uk5K1Uo4DLWDmsB7QiQVtW9d8PiW";
	
//	$confirmations = $var1[confirmations];
	$confirmations = 10;
	$txid = "3e06";

//	get user from address
	$user1 = "";
	$q1 = myquery( "select
				user
				from addressesinuse
				where address = \"$address\" 
				limit 1" );

	$row = mysqli_fetch_row( $q1 );

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
					uniqueX
					from deposits
					where txid = \"$txid\" 
					limit 1" );

		$row = mysqli_fetch_row( $q1 );

		if($row == null )
		{
//			depositrow = insert to deposit
			$depositrow = my3query( "INSERT INTO deposits
							( amount, address, user, confirmations, txid, datetime1 )
							VALUES 
							( \"$amount\", \"$address\", \"$user1\", \"$confirmations\", \"$txid\", \"$date1\" )" );

//			insert to expenses: unconfirmed, depositrow
			$q2 = my2query( "INSERT INTO expenses2
						( amount, user, type, address, ttxid, runintotal, datetime )
						VALUES 
						( \"$amount\", \"$user1\", \"deposit-unconfirmed\", \"$address\", \"$depositrow\", \"$runintotal\", \"$date1\" )" );
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
						datetime1 = \"$date1\"
						where uniqueX = \"$row[0]\"" );

			$depositrow = $row[0];
//			select from expenses2 where ttxid = depositrow
			$q2 = myquery( "select
						uniqueX
						from expenses2
						where ttxid = \"$depositrow\" and type = \"deposit-unconfirmed\"
						limit 1" );

			$row2 = mysqli_fetch_row( $q2 );

			if($row2 == null )
			{
//				insert to expenses: deposit-unconfirmed, depositrow
				$q2 = my2query( "INSERT INTO expenses2
					( amount, user, type, address, ttxid, runintotal, datetime )
					VALUES 
					( \"$amount\", \"$user1\", \"deposit-unconfirmed\", \"$address\", \"$depositrow\", \"$runintotal\", \"$date1\" )" );
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
						datetime = \"$date1\"
						where uniqueX = \"$row2[0]\"" );
			}
		}
	}


	if ( $confirmations > 0 )
	{
		$runintotal = $olrunintotal + $amount;

//		select uniqueX from deposits where txid = txid
		$q1 = myquery( "select
					uniqueX
					from deposits
					where txid = \"$txid\" 
					limit 1" );

		$row = mysqli_fetch_row( $q1 );

		if( $row == null )
		{
//			depositrow = insert to deposit
			$depositrow = my3query( "INSERT INTO deposits
							( amount, address, user, confirmations, txid, datetime1, datetime2 )
							VALUES 
							( \"$amount\", \"$address\", \"$user1\", \"$confirmations\", \"$txid\", \"$date1\", \"$date1\" )" );

//			insert to expenses: confirmed, depositrow
			$q2 = my2query( "INSERT INTO expenses2
						( amount, user, type, address, ttxid, runintotal, datetime )
						VALUES 
						( \"$amount\", \"$user1\", \"deposit\", \"$address\", \"$depositrow\", \"$runintotal\", \"$date1\" )" );
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
						datetime2 = \"$date1\"
						where uniqueX = \"$row[0]\"" );

			$depositrow = $row[0];
//			select from expenses2 where ttxid = depositrow
			$q2 = myquery( "select
						uniqueX
						from expenses2
						where ttxid = \"$depositrow\" and type = \"deposit-unconfirmed\"
						limit 1" );

			$row2 = mysqli_fetch_row( $q2 );

			if($row2 == null )
			{
//				insert to expenses: deposit, depositrow
				$q2 = my2query( "INSERT INTO expenses2
					( amount, user, type, address, ttxid, runintotal, datetime )
					VALUES 
					( \"$amount\", \"$user1\", \"deposit\", \"$address\", \"$depositrow\", \"$runintotal\", \"$date1\" )" );
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
						datetime = \"$date1\"
						where uniqueX = \"$row2[0]\" " );
			}
		}
	}

	echo "okay<br>";
	return "notify2 end<br>";
}


function listtransactions2( $name1, $startfrom, $results )
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

