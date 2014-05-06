<?php

include( "funcs.php" );
include( "lib/password.php" );

function createprofile( $fname1, $pass1, $pass2 )
{
//echo "qwe 1<br>";
	$check1 = createprofile2( $fname1, $pass1, $pass2 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

//echo "qwe 2<br>";


if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
 {
    //echo "CRYPT_BLOWFISH is enabled!";
}
else
 {
    //echo "CRYPT_BLOWFISH is not available";
}

	#check name availability
	$check3 = profile_exist($fname1);

//echo "qwe 3<br>";
	if ($check3 == "profile does not exist" )
	{
		#add user

//echo phpinfo();

//echo "qwe 4<br>";

		$hashAndSalt = password_hash($pass1, PASSWORD_BCRYPT);

		$pass1 = "";
//echo "qwe 5<br>";
		$date1 = date("y-m-d H:i:s",time());

//echo "qwe 6<br>";

		 my2query( "INSERT INTO users1 (loginName,createDate, hashword )
		 VALUES ( \"$fname1\", \"$date1\", \"$hashAndSalt\" )" );

		return "$fname1 <br>user added <br><br><a href=\"index.php\">back</a>";
	}
	return "that name is not available";
}


function createprofile2( $fname1, $pass1, $pass2 )
{
	include( "hilovalues.php" );
	#check name is valid
	$check1 = check_name2( $fname1, "login", 2 );
	if ($check1 != "is valid" )
	{
		return $check1;
	}
	#check passes match
	if( $pass1 != $pass2 )
	{
		return "enter password twice";
	}
	#check pass is valid
	return check_name($pass1, "password", $passlength );
}

function hexavig2()
{
	$num2 = 0;
	$num = 0;
	while( $num2 < 200 )
	{
		$num = $num2;
		
		$converted = "";
		$remainder = "";
		
		while ( $num > 0)
		{
			$remainder = $num % 26;
			$remainder2 = 26 - $remainder;
			$converted =  chr( $remainder2 + 96 ) . $converted;
			$num = ($num - $remainder) / 26;
		}
	//	echo "$num2   $converted<br>";
		
		$num2 = $num2 + 1;
	}
}

function hexavig()
{
//	return 5;
	$result1 = myquery( "select
			uniqueX
			from users1
			order by uniqueX desc
			limit 1" );
	
	$rrow = mysqli_fetch_row(($result1));
	$num = $rrow[0] + 1;
	
	$converted = "";
	$remainder = "";
	
	while ( $num > 0)
	{
			$remainder = $num % 26;
			$converted =  $converted . chr( 26 - $remainder + 96 );
			$num = ($num - $remainder) / 26;
	}

	return $converted;	
}

?>
