<?php
include( "funcs.php" );

function sendmessage( $name1, $name2, $message )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $name2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "message", $message );if ($check1 != "okay" ){ return $check1;}

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
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $name2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "message", $message );if ($check1 != "okay" ){ return $check1;}

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
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $name2 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "message", $message );if ($check1 != "okay" ){ return $check1;}

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

?>
