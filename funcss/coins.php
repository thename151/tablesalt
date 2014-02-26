<?php

include_once( "funcs.php" );

function getAddress( $name )
{
	// if address in table, return that
	// else getnew address
	// return $address;
}


function getNewAddress( $name )
{
	include("../coindetails.inc");
	$xr = rand ( 10000 , 99999 );
	$thetime =  time();

	$secret = $name . '-' . $thetime . '-' . $xr;
	echo "<br>" . $secret . "<br>";

	$my_callback_url = 'http://sales.info.tm/page.php?qe=callback&msg1='.$secret;

	$root_url = 'https://blockchain.info/api/receive';

	$parameters = 'method=create&address=' . $my_address .'&callback='. urlencode($my_callback_url);

/*	$response = file_get_contents($root_url . '?' . $parameters);

	$object = json_decode($response);

	echo 'Send Payment To : ' . $object->input_address;

	return "success";
*/
	$newaddress = "testaddress";
	$date = date_create();
	date_timestamp_set($date, $thetime );
	$datef = date_format($date, 'U = Y-m-d H:i:s');
	$datef = date("y-m-d H:i:s",$thetime);
	echo "qwe:" . $datef;
	// add to table :	name	newaddress	myaddress	code	date

	include_once( "dbfuncs.php" );
	
	$result2 = my2query( "INSERT INTO newaddresses
						( user, newaddress, oldaddress, code, date ) 
						VALUES
						( \"$name\",\"$newaddress\" ,\"$my_address\" ,\"$secret\", \"$datef\" )" );
	return "success";
}


function callback( $msg1 )
{
	/* search for msg1 under code in table1
	 * if found
	 *  get confirmations
	 *  if greater than 1
	 *   add entry to callbacks status comlpeted
	 *   return ok
	 *  if less than 1
	 *   add entry to callbacks status waiting for more confirms
	 *   return "" waiting for more confirms
	 * else
	 *  add to callbacks status unknown code, add code to cancel
	 *  return ""
	 **/
}
?>
