<?php

include( "funcs.php" );

function changepass( $name1, $pass1, $pass2a, $pass2b )
{
	$check1 = checknamepass( $name1, $pass1 );
	
	
	if( $check1 != "goodpass" )
	{
		return $check1;
	}
	if( $pass2a != $pass2b )
	{
		return "new passwords do not match";
	}

	include( "hilovalues.php" );
	$check2 = check_name( $pass2a, "password", $passlength );
	#check pass is valid
	if ($check2 != "is valid" )
	{
		return $check2;
	}

	$hashAndSalt = password_hash($pass2a, PASSWORD_BCRYPT);

	my2query( "update users1 set hashword = \"$hashAndSalt\" where loginName = \"$name1\"" );
	return "password changed";
}

?>