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
	$amount = trimtodp( $amount );
	
	
	echo "$amounthhhhhh<br>";
	echo "$amount<br>";
	
	if ( ( $amount ) < 0.001 )
	{
		return "number too small";
	}

	$available = getQuickBalance( $name );
	if ( ($amount/1000) > $available )
	{
		return "insufficient funds";
	}
	
	//	getrunintotal
	$olrunintotal = getrunintotal($name);
		
	$amount2 = $amount * 0.001;
		
	$runintotal = $olrunintotal - $amount2;
	
	$date1 = date("y-m-d H:i:s");
	

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, runintotal, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"bought products\", \"$runintotal\", \"$date1\" )" );
echo "qweewqqq";
	

	include_once( "sendproduct.php" );
	echo sendproductbalance( "holder", "bitcoin", "mBTC", $amount, $name,"coinbuy" );
//	sendproductbalance( "coins", "coins", "mBTC", $amount, $name,"coinbuy" );

	return "okay";
}


function coinsell( $name, $amount ) // sell mbtc products
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	$amount = trimtodp( $amount );

	echo "$amount<br>";
	$amount = trimtoxdp( $amount, 3 );
	echo "$amount<br>";
	
	include_once( "../funcss/listtrades.php" );
	$available = showHowMuch2( "bitcoin", "mBTC", $name );
//	$available = showHowMuch2( "coins", "mBTC", $name );
//	$available = getQuickBalance( $name );

	if ( $amount > $available )
	{
		return "insufficient funds";
	}


	$olrunintotal = getrunintotal($name);
		
	$amount2 = $amount * -0.001;
	
	$runintotal = $olrunintotal - $amount2;
	
	$date1 = date("y-m-d H:i:s");

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, runintotal, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"sold products\", \"$runintotal\", \"$date1\" )" );
	
	$amount2 = $amount / 1000;
	include_once( "sendproduct.php" );
	sendproductbalance( $name, "bitcoin", "mBTC", $amount, "holder","coinsell" );
//	sendproductbalance( $name, "coins", "mBTC", $amount, "coins","coinsell" );

	return "okay";
}


function getQuickBalance( $name )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}

	/*
	expenses        ux amount destination datetime

	get current address
	if blank return 0
	else
	 get most current address from adrschecks
	 if blank previous = 0
	 else
	  previous = total
	 newtotal = query current address
	 difference = newtotal - previous
	 add newtotal, difference to adrschecks 
	 recd = sum name1 diferences in addrscks
	 sent = sum name1 expenses
	 return recd - sent

	*/
	$q1 = myquery( "select
			address
			from addressesinuse
			where user = \"$name\" 
			order by uniqueX desc limit 1 " );

	$row = mysqli_fetch_row( $q1 );

	$sum = 0;
	
	if( $row == null )
	{
		$sum = 0;
	//	return 'zero';
	}
	else
	{
		$curradd = $row[0];
		$q2 = myquery( "select
			total, datetime
			from addresschecks
			where address = \"$curradd\"
			order by uniqueX desc limit 1 " );

		$previous = 0;
		$timehas = "passed";
		$rowb = mysqli_fetch_row( $q2 );

		if( $rowb != null )
		{
			"error";
		}

		$previous = $rowb[0];

		$newtotal = queryAdd( $curradd );

		if( $newtotal > $previous )
		{
			$difference = $newtotal - $previous;
			
		//	getrunintotal
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

			$runintotal = $olrunintotal + $difference;
			
			$date1 = date("y-m-d H:i:s");
			$result4 = my2query( "INSERT INTO addresschecks
						( user, address, total, difference, runintotal, datetime )
						VALUES 
						( \"$name\", \"$curradd\", \"$newtotal\", \"$difference\", \"$runintotal\", \"$date1\" )" );
		}
		
		$result = myquery("SELECT SUM( difference ) AS value_sum FROM addresschecks where user = \"$name\" "); 

		$row = mysqli_fetch_assoc( $result );
		$sum = $row['value_sum'];
	}
	//~ echo '  ' . $sum;
	
	//~ echo "<br>hey ";
	$result2 = myquery("SELECT SUM( amount ) AS value_sum FROM expenses where user = \"$name\" "); 

	$row = mysqli_fetch_assoc( $result2 );
	$sum2 = $row['value_sum'];
	//~ echo '  ' . $sum2;

	$balance = $sum - $sum2;

	return $balance;
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
	echo "ch";
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

	echo "1 " . $var1['version'];
	echo " 2 " . $var1['balance'];
	echo " 3 " . $var1['blocks'];
}

?>
