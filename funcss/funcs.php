<?php
include_once( "dbfuncs.php" );
include_once( "hilovalues.php" );
include( "lib/password.php" );

function check_name($fname,$label,$flen)
{
	# username, password, productname.

	$len = strlen($fname);
	if( $len < 2 )
	{
		return "$label must be 2 characters or more";
	}
	if( $len > $flen )
	{
		return "$label must be $flen characters or less";
	}

//	$var2 = ereg("^[A-Za-z0-9_-]+$",$fname);
#	$var1 = preg_match("^[A-Za-z0-9_-]+$^",$fname);
		
	$var1 = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/",$fname);
	if( $var1 == null )
	{
		return "$label must contain only characters A-Z a-z 0-9 _ and -";
	}
	return "is valid";
}

function check_name2($fname,$label,$flen)
{
	# username, password, productname.

	$len = strlen($fname);
	if( $len < 1 )
	{
		return "$label must be 1 character or more";
	}
	if( $len > $flen )
	{
		return "$label must be $flen characters or less";
	}

	//	$var2 = ereg("^[A-Za-z0-9_-]+$",$fname);
	#	$var1 = preg_match("^[A-Za-z0-9_-]+$^",$fname);

	$var1 = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/","qqq" . $fname);
	if( $var1 == null )
	{
		return "$label must have only characters A-Z a-z 0-9 _ and -";
	}
	
	if ( strpos($fname, " ") != false )
	{
		return "$label must not have a space";
	}

	$var1 = preg_match("/[a-z]/", "123" . $fname);
	if( $var1 == null )
	{
		return "$label must have a letter";
	}
	
	return "is valid";
}




function check_number( $numstr ,$min1, $max1 )
{
//  amount, tradenumber.
	$n1 = trim($numstr);
	
// 	$var1 = preg_match("/\b[0-9]+\.[0-9]\b/",$n1);
	$var1 = preg_match("/^[0-9.]+$/",$n1);

	if( $var1 == null )
	{
		return "number is bad";
	}
	
	if( $n1 < $min1 )
	{
// 		echo "heresmall" . $n1;
		return "number is too small, it should be more than or equal to $min1";
	}
	if( $n1 > $max1 )
	{
// 		echo "herebig";
		return "number is too large, it should be less than or equal to $max1";
	}
	
	return "is valid";
}


function check_mess($fname,$label,$flen)
{
	#message, details.
	$len = strlen($fname);
	if( $len < 2 )
	{
		$message = "$label must be 2 characters or more";
	}
	else
	{
		if( $len > $flen )
		{
			$message = "$label must be $flen characters or less";
		}
		else
		{
//			$var1 = ereg("^[A-Za-z0-9 _-]+$",$fname);
//			$var1 = preg_match("^[A-Za-z0-9 _-]+$^",$fname);
			$var1 = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9 _.-]+$/",$fname);
//			/^[A-Z][a-zA-Z -]+$/
			if( $var1 == null )
			{
				$message = "$label must contain only characters A-Z a-z 0-9 _.- and space, and start with A-Z a-z 0-9";
			}
			else
			{
				$message = "is valid";
			}
		}
	}
	return $message;
}


function profile_exist($fname2)
{
	$check1 = check_name($fname2,"name",25);
	if ( $check1 == "is valid" )
	{
		
		$result = myquery( "select loginName from users1 where loginName = \"$fname2\"" );
		$row = mysqli_fetch_row( $result );
		if($row != null )
		{
			return "profile does exist";
		}
		else
		{
			return "profile does not exist";
		}
	}
	else
	{
		return "profile does not exist";
	}
}

function checknamepass( $name1, $pass1 )
{
	include( "hilovalues.php" );

	$check1 = check_name($name1, "name", $namelength);
	$check2 = check_name($pass1, "pass", $passlength);

	if ( $check1 != "is valid" )
	{
		return "incorrect username or password";
	}
	
	if ( $check2 != "is valid" )
	{
		return "incorrect username or password";
	}

	return checknamepass2b($name1, $pass1);
}



function checknamepass2b( $name1, $pass1 )
{
	$result = myquery( "select hashword from users1 where loginName = \"$name1\"" );
	$row = mysqli_fetch_row($result);
	if( $row[0] == null )
	{
		return "incorrect username or password";
	}

	if( $row[0] != null )
	{
		if (password_verify($pass1, $row[0]))
		{
			$date1 = date("y-m-d H:i:s",time());
			$result2 = my2query( "INSERT INTO login1 ( loginName, LoginTime ) VALUES (\"$name1\",\"$date1\")" );
			return 'goodpass';
		}
		return 'bad password';
	}
}



function checksstartresults( $startfrom, $results )
{
	include( "hilovalues.php" );

	$check1 = check_number( $startfrom, 0, 5000 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$check1 = check_number( $results, 1, 50 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	return "is valid";
}

?>