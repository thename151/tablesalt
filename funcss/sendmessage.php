<?php
include( "funcs.php" );

function sendmessage( $name1, $name2, $message )
{
	$check1 = sendmessage2( $name1, $name2, $message );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$mess1 = profile_exist( $name1 );
	if( $mess1 == "profile does exist" )
	{
		$mess2 = profile_exist( $name2 );
		if( $mess2 == "profile does exist" )
		{
			$date1 = date("y-m-d H:i:s");
			$result4 = my2query( "INSERT INTO messages1 (message1,datetime,from1,to1) VALUES (\"$message\",\"$date1\",\"$name1\",\"$name2\")" );
			return "message sent to $name2";
		}
		return $mess2;
	}
	return $mess1;
}



function sendComment( $name1, $name2, $message )
{
	$check1 = sendmessage2( $name1, $name2, $message );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$mess1 = profile_exist( $name1 );
	if( $mess1 == "profile does exist" )
	{
		$mess2 = profile_exist( $name2 );
		if( $mess2 == "profile does exist" )
		{
			$date1 = date("y-m-d H:i:s");
			$result4 = my2query( "INSERT INTO messages1 (message1,datetime,from1,to1, type)
			VALUES (\"$message\",\"$date1\",\"$name1\",\"$name2\", \"user\")" );
			return "$name2 comment placed";
		}
		return $mess2;
	}
	return $mess1;
}


function sendProductComment( $name1, $name2, $pr1, $message )
{
	$check1 = sendmessage3( $name1, $name2, $pr1, $message );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$mess1 = profile_exist( $name1 );
	if( $mess1 == "profile does exist" )
	{
		$mess2 = profile_exist( $name2 );
		if( $mess2 == "profile does exist" )
		{
			$date1 = date("y-m-d H:i:s");
			$result4 = my2query( "INSERT INTO messages1 (message1,datetime,from1,to1, product, type)
			VALUES (\"$message\",\"$date1\",\"$name1\",\"$name2\",\"$pr1\", \"product\")" );
			return "$name2 comment placed";
		}
		return $mess2;
	}
	return $mess1;
}


function sendmessage2( $name1, $name2, $message )
{
	include( "hilovalues.php" );

	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid")
	{
		return $check1;
	}
	$check2 = check_name($name2,"name", $namelength);
	if( $check2 != "is valid")
	{
		return $check2;
	}
	return check_mess( $message, "message", $messagelength );
}


function sendmessage3( $name1, $name2, $pr1, $message )
{
	include( "hilovalues.php" );

	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid")
	{
		return $check1;
	}
	$check2 = check_name($name2,"name", $namelength);
	if( $check2 != "is valid")
	{
		return $check2;
	}
	
	$check2 = check_name($pr1, "product name", $productlength );
	if( $check2 != "is valid")
	{
		return $check2;
	}

	
	return check_mess( $message, "message", $messagelength );
}




?>
