<?php

include_once( "funcs.php" );

function getAddress( $name )
{
	// if address in table, return that

/*
	$qq = 0;

	while( $qq < 98 )
	{
		$xr = rand ( 10000 , 99999 );
		
		$result4 = my2query( "INSERT INTO addresslist 
						( address ) 
						VALUES
						( \"$xr\" )" );

		$qq = $qq + 1;
	}
*/

	$q1 = myquery( "select
			address, code
			from newaddresses
			where user = \"$name\" 
			order by uniqueX desc limit 1 " );

	$row = mysqli_fetch_row( $q1 );
	$stopId = 0;
	if($row != null )
	{
		//~ echo $row[0];
		//~ echo "<br>" . $row[1];
		$array = array( $row[0], $row[1] );

		return $array;
	}
	else	// getnew address
	{
		$arr = getNewAddress( $name );
		//~ echo $arr[0];
		//~ echo $arr[1];
		
		return $arr;
	}
}


function drawCode2( $addr )
{
	$dir = '../qrcodes/';

	include_once( '../phpqrcode/dex2.php' );
	$var1 = drawCode( $addr );

	//~ echo '<img src="'.$dir.basename($var1).'.png" />';
	
	return $var1;
}


function getNewAddress( $name )
{
	$q1 = myquery( "select
			address
			from addresslist
			where status != \"used\"
			order by uniqueX limit 1 " );

/* table addresslist
 * uniqueX address status user
 */

	//~ echo "q1 <br>";
	$row = mysqli_fetch_row( $q1 );
	
	if($row != null )
	{
		//~ echo "q3 <br>";
		$code = drawCode2( $row[ 0 ] );
		$date1 = date("y-m-d H:i:s");

		$result4 = my2query( "INSERT INTO newaddresses 
						( user, address, code, date ) 
						VALUES 
						( \"$name\", \"$row[0]\", \"$code\", \"$date1\" )" );

		my2query( "update addresslist set
			status = \"used\",
			user = \"$name\"
			where address = \"$row[0]\"" );

		//~ echo $code . "qweqwe";
		$array = array( $row[0], $code );
		return $array;
	}
	else
	{
		//~ echo "q2 <br>";
		return "no more new addr esses";
	}
}

?>
