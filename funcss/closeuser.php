<?php

include_once( "funcs.php" );
include_once( "deleteproduct.php" );

function closeuser( $name )
{
	echo "close user";
	// delete products, close trades

	$result = myquery( "select productName from products1 where 
						 profileName = \"$name\" and 
						 status1 = \"okay\" " );

	while( $row2 = mysqli_fetch_array($result) )
	{
		deleteproductpassed( $name, $row2[0] );
	}

	// return scores, closed user
	include( "../funcss/sendproduct.php" );
		
	$result2 = myquery( "select creator, product, amount from scores1 where who1 = \"$name\"" );
	while( $row3 = mysqli_fetch_array($result2) )
	{
		$mess2 = sendproductbalance( $name, $row3[0], $row3[1], $row3[2], $row3[0], "closed user" );
	}
	
	
	// set status to closed, add close date
/*
	$date1 = date("y-m-d H:i:s",time());

	my2query( "update users1 set
				closeDate = \"$date1\"
				where loginName = \"$name\" " );
*/

	// edit user info page

}

?>
