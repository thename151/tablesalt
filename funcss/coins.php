<?php

include_once( "funcs.php" );

function coinwraw( $name, $amount, $destination )
{
	$available = getQuickBalance( $name );
	if ( $amount > $available )
	{
		return "insufficient funds";
	}

	$date1 = date("y-m-d H:i:s");

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"$amount\", \"$destination\", \"$date1\" )" );

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


function coinbuy( $name, $amount )
{
	$available = getQuickBalance( $name );
	if ( $amount > $available )
	{
		return "insufficient funds";
	}
	
	$date1 = date("y-m-d H:i:s");
	
	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"$amount\", \"bought products\", \"$date1\" )" );

	include_once( "sendproduct.php" );
	sendproductbalance( "bitcoin", "bitcoin", "mBTC", $amount, $name,"coinbuy" );

	return "okay";
}


function coinsell( $name, $amount )
{
	include_once( "../funcss/listtrades.php" );
	$available = showHowMuch2( "bitcoin", "mBTC", $name );
//	$available = getQuickBalance( $name );

	if ( $amount > $available )
	{
		return "insufficient funds";
	}

	$date1 = date("y-m-d H:i:s");

	$negativeamount = $amount * -1;

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"$negativeamount\", \"bought products\", \"$date1\" )" );

	include_once( "sendproduct.php" );
	sendproductbalance( $name, "bitcoin", "mBTC", $amount, "bitcoin","coinsell" );

	return "okay";
}


function getQuickBalance( $name )
{
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
	if( $row == null )
	{
		return 'zero';
	}
	$curradd = $row[0];
	$q2 = myquery( "select
		total
		from addresschecks
		where address = \"$curradd\" 
		order by uniqueX desc limit 1 " );

	$previous = 0;
	$rowb = mysqli_fetch_row( $q2 );
	if( $row != null )
	{
		$previous = $rowb[0];
	}
	$newtotal = queryAdd( $curradd );
	$difference = $newtotal - $previous;
	
	$date1 = date("y-m-d H:i:s");
	$result4 = my2query( "INSERT INTO addresschecks
					( user, address, total, difference, datetime )
					VALUES 
					( \"$name\", \"$curradd\", \"$newtotal\", \"$difference\", \"$date1\" )" );
	
	//~ echo "hey";
	$result = myquery("SELECT SUM( difference ) AS value_sum FROM addresschecks where user = \"$name\" "); 

	$row = mysqli_fetch_assoc( $result );
	$sum = $row['value_sum'];
	//~ echo '  ' . $sum;
	
	//~ echo "<br>hey ";
	$result2 = myquery("SELECT SUM( amount ) AS value_sum FROM expenses where user = \"$name\" "); 

	$row = mysqli_fetch_assoc( $result2 );
	$sum2 = $row['value_sum'];
	//~ echo '  ' . $sum2;

	$balance = $sum - $sum2;

	return $balance;
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
	return 5;
	$url2 = $curradd;
	$url1 = "https://blockchain.info/q/getreceivedbyaddress/";
	$url3 = "?confirmations=1";
	return file_get_contents( $url1. $url2 . $url3 ) / 100000000 ;
}



function getAddress( $name )
{
	$q1 = myquery( "select
			address, code
			from addressesinuse
			where user = \"$name\" 
			order by uniqueX desc limit 1 " );

	$row = mysqli_fetch_row( $q1 );
	if($row != null )
	{
		$array = array( $row[0], $row[1] );

		return $array;
	}
	else	// getnew address
	{
		$arr = getNewAddress( $name );
		
		return $arr;
	}
}


function drawCode2( $addr )
{
	include_once( '../phpqrcode/dex2.php' );
	$var1 = drawCode( '../grui2/qrcodes', $addr );

	return $var1;
}


function getNewAddress( $name )
{
	$q1 = myquery( "select
			address
			from addresslist
			where status != \"used\"
			order by uniqueX limit 1 " );

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

		$array = array( $row[0], $code );
		return $array;
	}
	else
	{
		return "no more new addr esses";
	}
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
?>
