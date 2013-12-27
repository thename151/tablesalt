<?php

function myquery( $fquery )
{
	include( "../dbdets.inc" );
	$cxn = mysqli_connect( $host1, $usrname1,$passw1, $dbname1 )
	or die ("couldn’t connect 2 server");

	$query = $fquery;

	//  echo $fquery;

	$result = mysqli_query($cxn,$query)
	or die ("Couldn’t executes query!.");

	mysqli_close($cxn);

	return $result;
}


function my2query( $fquery )
{
	include( "../dbdets.inc" );
	$cxn = mysqli_connect( $host1, $usrname1,$passw1, $dbname1 )
	or die ("couldn’t connect 2 server");


	$date1 = date("y-m-d H:i:s",time());
	$query = $fquery;

// 	echo $fquery;
	
	$result = mysqli_query($cxn,$query)
	or die ("Couldn’t executes query!1");
	
	$cleanq = mysqli_real_escape_string($cxn,$fquery);
	
	$cleanq2 = str_replace( "\"", "'", $fquery);
	
	$querylog = "INSERT INTO querylog
	            ( dateTime, theQuery )
				VALUES
				( \"$date1\" , \"$cleanq2\" )
	            ";
	
	$result2 = mysqli_query( $cxn, $querylog )
	or die ("Couldn’t executes query!3");
	
	mysqli_close($cxn);

	return $result;
}

//( \"$date1\" , \"$cleanq\" )
 


?>