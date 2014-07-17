<?php

function escapeStr( $var1 )
{
	include( "../dbdets.inc" );
	$cxn = mysqli_connect( $host1, $usrname1,$passw1, $dbname1 )
	or die ("could not connect 2 server");

	$var1 = mysqli_real_escape_string($cxn, $var1);

	mysqli_close($cxn);

	return $var1;
}

function myquery( $fquery )
{
	include( "../dbdets.inc" );
	$cxn = mysqli_connect( $host1, $usrname1,$passw1, $dbname1 )
	or die ("could not connect 2 server");
//	or die ("couldn’t connect 2 server");

	$query = $fquery;

//	echo $fquery . '<br>';

	$result = mysqli_query($cxn,$query)
	or die ("Could not executes query! : <br>$query");

	mysqli_close($cxn);

	return $result;
}


function my2query( $fquery )
{
	include( "../dbdets.inc" );
	
	$cxn = mysqli_connect( $host1, $usrname1,$passw1, $dbname1 )
	or die ("could not connect 2 server");

	$date1 = date("y-m-d H:i:s",time());

	$cleanq = mysqli_real_escape_string($cxn,$fquery);
	$cleanq2 = str_replace( "\"", "'", $cleanq);
	
	
	//~ echo 'qz<br>';
	//~ echo "1". $fquery . '<br>';
	//~ echo "2". $cleanq . '<br>';
	//~ echo "3". $cleanq2 . '<br>';
	
	$result = mysqli_query( $cxn, $fquery )
	or die ("Could not executes query! 22 : <br>$fquery");
	
	$querylog = "INSERT INTO querylog
	            ( dateTime, theQuery )
				VALUES
				( \"$date1\" , \"$cleanq2\" )
	            ";
	
	$result2 = mysqli_query( $cxn, $querylog )
	or die ("Could not executes query! 3 : <br>$querylog");

	mysqli_close($cxn);

	return $result;
}


function my3query( $fquery )  // returns key id
{
	include( "../dbdets.inc" );
	
	$cxn = mysqli_connect( $host1, $usrname1,$passw1, $dbname1 )
	or die ("could not connect 2 server");

	$date1 = date("y-m-d H:i:s",time());

	$cleanq = mysqli_real_escape_string($cxn,$fquery);
	$cleanq2 = str_replace( "\"", "'", $cleanq);
	
	$result = mysqli_query( $cxn, $fquery )
	or die ("Could not executes query! 2 : <br>$query");
	
	$result3 = mysqli_insert_id($cxn);
	
	$querylog = "INSERT INTO querylog
	            ( dateTime, theQuery )
				VALUES
				( \"$date1\" , \"$cleanq2\" )
	            ";
	
	$result2 = mysqli_query( $cxn, $querylog )
	or die ("Could not executes query! 3 : <br>$querylog");

	mysqli_close($cxn);

	return $result3;
}

?>
