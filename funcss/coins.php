<?php

include_once( "funcs.php" );

function coinwraw( $name, $amount, $destination )
{
	$available = getQuickBalance( $name );
	$txfee = 0.0002;
	$amount2 = $amount + $txfee;
	if ( $amount2 > $available )
	{
		return "insufficient funds";
	}

	$date1 = date("y-m-d H:i:s");

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"$destination\", \"$date1\" )" );

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
	
	$amount2 = $amount / 1000;

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"$amount2\", \"bought products\", \"$date1\" )" );

	
	include_once( "sendproduct.php" );
	sendproductbalance( "bitcoin", "bitcoin", "mBTC", $amount, $name,"coinbuy" );
//	sendproductbalance( "coins", "coins", "mBTC", $amount, $name,"coinbuy" );

	return "okay";
}


function coinsell( $name, $amount )
{
	include_once( "../funcss/listtrades.php" );
	$available = showHowMuch2( "bitcoin", "mBTC", $name );
//	$available = showHowMuch2( "coins", "mBTC", $name );
//	$available = getQuickBalance( $name );

	if ( $amount > $available )
	{
		return "insufficient funds";
	}

	$date1 = date("y-m-d H:i:s");

	$negativeamount = $amount * -0.001;

	$result4 = my2query( "INSERT INTO expenses
				( user, amount, destination, datetime )
				VALUES 
				( \"$name\", \"$negativeamount\", \"bought products\", \"$date1\" )" );
	
	$amount2 = $amount / 1000;
	include_once( "sendproduct.php" );
	sendproductbalance( $name, "bitcoin", "mBTC", $amount, "bitcoin","coinsell" );
//	sendproductbalance( $name, "coins", "mBTC", $amount, "coins","coinsell" );

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
		total, datetime
		from addresschecks
		where address = \"$curradd\"
		order by uniqueX desc limit 1 " );

	$previous = 0;
	$timehas = "passed";
	$rowb = mysqli_fetch_row( $q2 );

	if( $rowb != null )
	{
		$previous = $rowb[0];
		$timehas = beforetimemins( $rowb[1], 1 );
	}
	
	if( $timehas == "passed" )
	{
		$newtotal = queryAdd( $curradd );
		$difference = $newtotal - $previous;
	
		$date1 = date("y-m-d H:i:s");
		$result4 = my2query( "INSERT INTO addresschecks
					( user, address, total, difference, datetime )
					VALUES 
					( \"$name\", \"$curradd\", \"$newtotal\", \"$difference\", \"$date1\" )" );
	}

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
	return 5;
	$url2 = $curradd;
	$url1 = "https://blockchain.info/q/getreceivedbyaddress/";
	$url3 = "?confirmations=1";
	return file_get_contents( $url1. $url2 . $url3 ) / 100000000 ;
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

?>
