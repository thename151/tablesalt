<?php
include_once( "dbfuncs.php" );
include_once( "hilovalues.php" );
include_once( "lib/password.php" );


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
	if( $len < 2 )
	{
		return "$label must be 2 character or more";
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
//	echo "1 : " . $numstr . "<br>";
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
	
//	echo "2 : " . $numstr . "<br>";
	return "is valid";
}


function check_whole_number( $numstr ,$min1, $max1 )
{
//	echo "1 : " . $numstr . "<br>";
//  amount, tradenumber.
	$n1 = trim($numstr);
	
// 	$var1 = preg_match("/\b[0-9]+\.[0-9]\b/",$n1);
	$var1 = preg_match("/^[0-9]+$/",$n1);

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
	
//	echo "2 : " . $numstr . "<br>";
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
	$check1 = check_string("username", $name1);	if ( $check1 != "okay" ){return  $check1;}
	$check1 = check_string("password", $pass1);	if ( $check1 != "okay" ){return  $check1;}
	
	return checknamepass2b($name1, $pass1);
}



function checknamepass2b( $name1, $pass1 )
{
//	$result = myquery( "select hashword from users1 where loginName = \"$name1\" and closeDate is null" );
	$result = myquery( "select hashword from users1 where loginName = \"$name1\" " );
	$row = mysqli_fetch_row($result);
	if( $row[0] == null )
	{
		return "incorrect username or password";
	}

	if (password_verify($pass1, $row[0]))
	{
		$date1 = date("y-m-d H:i:s",time());
		$result2 = my2query( "INSERT INTO login1 ( loginName, LoginTime ) VALUES (\"$name1\",\"$date1\")" );
		return 'goodpass';
	}
	return 'bad password';
}



function checksstartresults( $startfrom, $results )
{
	$check1 = check_whole_number( $startfrom, 0, 5000 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$check1 = check_whole_number( $results, 1, 50 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	return "is valid";
}


function checkuser( $name1 )
{
	$check1 = check_string("username", $name1);	if ( $check1 != "okay" ){return  $check1;}
	
	$result = myquery( "select uniqueX, closeDate from users1 where loginName = \"$name1\" " );
	$row = mysqli_fetch_row($result);
	
	if( $row[0] == null )
	{
		return "user does not exist";
	}
	if( $row[1] == null )
	{
		return "good";
	}

	return "user closed";
}

function trimtodp( $num )
{
	include( "hilovalues.php" );
	// 500.000125
	// 500.000

//	echo "ato trim " . $loscore ."<br>";

	$var1 = 1 / $loscore;

	$var2 = $num * $var1;
	$var3 = fmod( $var2, 1 );
	$var4 = $var2 - $var3;
	$var5 = $var4 / $var1;
	
	return $var5;// . " " . $num;
}

function trimtoxdp( $num, $varx )
{
	include( "hilovalues.php" );
	//  5
	// 500.98747123
	// 500.98747
	
//	echo "xto trim " . $varx ."<br>";

	$var1 = pow( 10, $varx);

	$var2 = $num * $var1;
	$var3 = fmod( $var2, 1 );
	$var4 = $var2 - $var3;
	$var5 = $var4 / $var1;
	
	return $var5;// . " " . $num;
}



//	characters and lengths

function check_string( $type, $var )
{
	include( "hilovalues.php" );
	
	if( $type == "username" )
	{
		$minlen = $namelength_min;
		$maxlen = $namelength;
		$len = strlen( $var );
		
		if( $len < $minlen ){return "username must be $minlen characters or more";	}
		if( $len > $maxlen ){return "username must be $maxlen characters or less";	}
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{	return "username must contain only characters A-Z a-z 0-9 _ and -";	}
		
		if ( strpos( $var, " ") != false )
		{	return "username  must not have a space";	}

		return "okay";
	}
	
	if( $type == "password" )
	{
		$minlen = $passlength_min;
		$maxlen = $passlength;
		$len = strlen( $var );
		
		if( $len < $minlen )
		{
			return "password must be $minlen characters or more";
		}
		if( $len > $maxlen )
		{
			return "password must be $maxlen characters or less";
		}
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{
			return "password must contain only characters A-Z a-z 0-9 _ and -";
		}

		return "okay";
	}

	if( $type == "productname" )
	{
		$minlen = $productlength_min;
		$maxlen = $productlength;
		$len = strlen( $var );
		
		if( $len < $minlen )
		{
			return "product name must be $minlen characters or more";
		}
		if( $len > $maxlen )
		{
			return "product name must be $maxlen characters or less";
		}
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{
			return "product name must contain only characters A-Z a-z 0-9 _ and -";
		}

		if ( strpos( $var, " ") != false )
		{
			return "product name  must not have a space";
		}

		return "okay";
	}

	if( $type == "productdetail" )
	{
		$minlen = $detaillength_min;
		$maxlen = $detaillength;
		$len = strlen( $var );
		
		if( $len < $minlen )
		{
			return "product detail must be $minlen characters or more";
		}
		if( $len > $maxlen )
		{
			return "product detail must be $maxlen characters or less";
		}
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{
			return "product detail must contain only characters A-Z a-z 0-9 _ and -";
		}

		return "okay";
	}
	
	if( $type == "message" )
	{
		$minlen = $messagelength_min;
		$maxlen = $messagelength;
		$len = strlen( $var );
		
		if( $len < $minlen )
		{
			return "message must be $minlen characters or more";
		}
		if( $len > $maxlen )
		{
			return "message must be $maxlen characters or less";
		}
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{
			return "message must contain only characters A-Z a-z 0-9 _ and -";
		}

		return "okay";
	}
	
	if( $type == "amount" )
	{
		$len = strlen( $var );
		$len2 = strlen( $hiscore );
		
		if( $len > $len2 )
		{
			return "amount must be $len2 characters or less";
		}

//		/^\d+(?:\.\d+)?$/
//		^[\d.]+$
//		/^[0-9]+([\,\.][0-9]+)?$/g;

	//~ if (preg_match('/^[0-9]+(\.[0-9]+)?$/', $number))

		
		//~ $var2 = preg_match( "/^[0-9][0-9 .]+$/", $var );
		//~ if( $var2 == null )

		$var2 = preg_match('/^[0-9]+(\.[0-9]+)?$/', $var);

		if ( $var == 0 )
		{
			return "amount must contain only characters 0-9 and .  : $var";
		}		
		if( $var < $loscore )
		{
			return "amount must be $loscore or more";
		}
		if( $var > $hiscore )
		{
			return "amount must be $hiscore or less";
		}

		return "okay";
	}

	if( $type == "pageno" )
	{
		$len = strlen( $var );
		$len2 = 4;

		if( $len > $len2 )
		{
			return "page number must be $len2 characters or less";
		}

		$var2 = preg_match( "/^[0-9]{1,45}$/", $var );
//		$var2 = preg_match( "^[0-9]$/", $var );
		if( $var2 == null )
		{
			return "page number must contain only characters 0-9";
		}

		return "okay";
	}

	if( $type == "trueorfalse" )
	{
		$len = strlen( $var );
		$len2 = 4;
		
		if( ( $var !="true" ) && ( $var !="false" ) )
		{
			return "true or false not true or false : $var";
		}

		return "okay";
	}

	if( $type == "messagetype" )
	{
		if( ( $var !="message" ) && ( $var !="comment" ) )
		{
			return "message type not message or comment";
		}

		return "okay";
	}
	if( $type == "buysell" )
	{
		if( ( $var !="sell" ) && ( $var !="buy" ) )
		{
			return "type not buy or sell";
		}
		return "okay";
	}
	if( $type == "txno" )
	{
		$len = strlen( $var );
		$len2 = 6;

		if( $len > $len2 )
		{
			return "page number must be $len2 characters or less";
		}

		$var2 = preg_match( "/^[0-9]{1,45}$/", $var );
		if( $var2 == null )
		{
			return "txno must contain only characters 0-9 : $var";
		}

		return "okay";
	}
	if( $type == "keepon" )
	{
		if ( !(( $var == "" ) || ( $var == "dokeep" )) )
		{
			return "keepon values bad : " . $var;
		}
		return "okay";
	}
	if( $type == "sendsort" )
	{
		if ( !( 
				( $var == "ordinary" ) || 
				( $var == "trade" ) ||
				( $var == "coinbuy" ) ||
				( $var == "coinsell" ) ||
				( $var == "recall" ) ||
				( $var == "closed user" ) ||
				( $var == "dividend" )
				 ) )
		{
			return "sendsort values bad : " . $var;
		}
		return "okay";
	}

	if( $type == "coinamount" )
	{
		$len = strlen( $var );

		if( $len > 17 )
		{
			return "amount must be $len2 characters or less";
		}

		$var2 = preg_match('/^[0-9]+(\.[0-9]+)?$/', $var);

		if ( $var == 0 )
		{
			return "amount must contain only characters 0-9 and .  : $var";
		}		
		if( $var < 0.00000001 )
		{
			return "amount must be more than 0.00000001";
		}
		if( $var > 21000000 )
		{
			return "amount must be less than 21,000,000";
		}

		return "okay";
	}
	
	return "okay2";
}

?>
