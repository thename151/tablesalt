<?php

include_once( "funcs.php" );
include_once( "deleteproduct.php" );

function createprofile( $fname1, $pass1, $pass2 )
{
//	echo "enabled!<br>";
	$check1 = createprofile2( $fname1, $pass1, $pass2 );
	if( $check1 != "okay" )
	{
		return $check1;
	}


	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
	{
		//echo "CRYPT_BLOWFISH is enabled!";
	}
	else
	{
		//echo "CRYPT_BLOWFISH is not available";
	}

	#check name availability
	$check3 = checkuser($fname1);

//	echo "enabled! $check3<br>";

//echo "qwe 3<br>";
	if ($check3 == "user does not exist" )
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
	#check name is valid
	$check1 = check_string( "new-username", $fname1 );
	if ($check1 != "okay" )
	{
		return $check1;
	}
	#check passes match
	if( $pass1 != $pass2 )
	{
		return "enter password twice";
	}
	#check pass is valid
	return check_string( "password", $pass1 );
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

	$check1 = check_string("password", $pass1);	if ( $check1 != "okay" ){return  $check1;}

	$hashAndSalt = password_hash($pass2a, PASSWORD_BCRYPT);

	my2query( "update users1 set hashword = \"$hashAndSalt\" where loginName = \"$name1\"" );
	return "password changed";
}




function closeuser( $name )
{
	echo "close user1 $name 14"; 
	include_once( "settrade.php" );
	
	echo "close user!!<br>";

	// close trades
	
	$result3 = myquery( "select uniqueX
						 from sales3 where
						 user = \"$name\"" );
						 
	echo "query3!!<br>";

	while( $row3 = mysqli_fetch_array($result3) )
	{
		echo "while in query3!! $row3[0] <br>";
		removetrade( $name, $row3[0] );
	}
	
	// delete products

	$result = myquery( "select productName from products1 where 
						 user1 = \"$name\" and 
						 status1 = \"okay\" " );

	while( $row = mysqli_fetch_array($result) )
	{
		echo " dp ( $name, $row[0] )<br>";
		deleteproductpassed( $name, $row[0] );
//		include_once( "sendproduct.php" );
	}

	// return scores, closed user
	echo "query2!!<br>";
	include_once( "../funcss/sendproduct.php" );
		
	echo "query22!!<br>";



	$result2 = myquery( "select creator, product, amount from scores1 where who1 = \"$name\"" );
	while( $row3 = mysqli_fetch_array($result2) )
	{
		echo "here wh ( $name, $row3[0], $row3[1], $row3[2], $row3[0], ) <br>";
		$mess2 = sendproductbalance( $name, $row3[0], $row3[1], $row3[2], $row3[0], "closed user" );
	}

	
	// set status to closed, add close date
echo "// set status to closed, add close date<br";

	$date1 = date("y-m-d H:i:s",time());

	my2query( "update users1 set
				closeDate = \"$date1\"
				where loginName = \"$name\" " );


	// edit user info page
	
}

function stylenow( $name, $var )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}

	if( ( $var == "style-dark.css" ) || ( $var == "style-light.css" ) )
	{
		my2query( "update users1 set thestyle = \"$var\" where loginName = \"$name\"" );
		$_SESSION['cssfile'] = $var;
	}
}


function getstyle( $name )
{
	$check1 = check_string( "username", $name );if ($check1 != "okay" ){ return $check1;}

	$var = "";
	$result1 = myquery( "select thestyle from users1 where loginName = \"$name\"" );
	
	$row = mysqli_fetch_row( $result1 );
	
	if($row != null )
	{
		$var = $row[0];
	}

	if( $var =="" )
	{
		return "style-light.css";
	}

	return $var;
}



function listusers2( $startfrom, $results  )
{	
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	
	$result1 = myquery( "select loginName from users1 where closeDate is null order by loginName limit $startfrom, $results " );
	$result2 = myquery( "select loginName from users1 where closeDate is null" );
	
	$numrows = mysqli_num_rows( $result2 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;

	$i1 = 1;
	
	while($noticia = mysqli_fetch_array($result1))
	{
		$mess1 [$i1] = $noticia[0];
		$i1++;
	}
	return $mess1;
}

?>
