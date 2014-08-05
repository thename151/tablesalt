<?php
include_once( "dbfuncs.php" );
include_once( "hilovalues.php" );

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

function checknamepass( $name1, $pass1 )
{
	$check1 = check_string("username", $name1);	if ( $check1 != "okay" ){return  $check1;}
	$check1 = check_string("password", $pass1);	if ( $check1 != "okay" ){return  $check1;}
	
	return checknamepass2b($name1, $pass1);
}


function maskcr( $cr1 )
{
//	return "ewq";
	$numbera = "0";
	$q1 = myquery( "select
			uniqueX
			from users1
			where loginName = \"$cr1\"
			limit 1" );

	$row = mysqli_fetch_row( $q1 );
	if($row != null )
	{
		$numbera = "" . $row[0];
	}
	return $numbera;
}

function unmaskcr( $cr1 )
{
	$numbera = "0";
	$q1 = myquery( "select
			loginName
			from users1
			where uniqueX = \"$cr1\"
			limit 1" );

	$row = mysqli_fetch_row( $q1 );
	if($row != null )
	{
		$numbera = "" . $row[0];
	}
	return $numbera;
}

function unmaskpr( $pr1 )
{
	$numbera = "0";
	$q1 = myquery( "select
			productName
			from products1
			where uniqueX = \"$pr1\"
			limit 1" );

	$row = mysqli_fetch_row( $q1 );
	if($row != null )
	{
		$numbera = "" . $row[0];
	}
	return $numbera;
}


function maskpr( $pr1 )
{
	$numbera = "0";
	$q1 = myquery( "select
			uniqueX
			from products1
			where productName = \"$pr1\"
			limit 1" );

	$row = mysqli_fetch_row( $q1 );
	if($row != null )
	{
		$numbera = "" . $row[0];
	}
	return $numbera;
}


function checknamepass2b( $name1, $pass1 )
{
//	$result = myquery( "select hashword from users1 where loginName = \"$name1\" and closeDate is null" );
//	$result = myquery( "select hashword from users1 where loginName = \"$name1\" " );
	$result = myquery( "select hashword, closeDate from users1 where loginName = \"$name1\" " );
	$row = mysqli_fetch_row($result);
	
	//~ echo "qwe " . $row[0];
	//~ echo "qwe " . $row[1];
	if( $row[0] == null )
	{
		return "incorrect username or password!";
	}
	if( $row[1] != null )
	{
		return "user closed : $row[1]";
	}

	if (password_verify($pass1, $row[0]))
	{
		$date1 = date("y-m-d H:i:s",time());
		$result2 = my2query( "INSERT INTO login1 ( loginName, LoginTime ) VALUES (\"$name1\",\"$date1\")" );
		return 'goodpass';
	}
	return 'bad password';
}


function rounditup( $num )
{
	$var1 = trimtodp( $num );
	
	if( $var1 == $num )
	{
		return $num;
	}
	
	include( "hilovalues.php" );

	$var5 = $var1 + $loscore;

	echo "roundit-up : num $num, var1 $var1, var5 $var5, var3 $var3, var4 $var4, var5 $var5, var6 $var6, var7 $var7<br> ";
	return $var5;
}


function rounditrand( $num1 )	// 21.234567
{
//	21.234567
	$var1 = trimtodp( $num1 );
	if( $var1 == $num1 )
	{
		return $num1;
	}
	
	$var2 = ( 1000000 * $num1 ) - ( 1000000 * $var1 ); //567
//	$var2 = ( 1 * $num1 ) - ( 1 * $var1 ); //567
//	$var3 = $var2 / 1000000; //567

//	$var3 = $num1 * 1000;	// 567

	$var4 = 0;
	
	$xr = rand ( 1 , 1000 );
	
	// 001 echo "$xr vs. $var3<br>";
//~ 
	if( $xr <= $var2 )
	{
		$var4 = 0.001;
	}
	//~ return $var4;  //0.001 or 0
	
	$var5 = $var4 + $var1;
	
	echo "roundit-rand : num1 $num1, var1 $var1, var2 $var2, var3 $var3, var4 $var4, xr $xr, var5 $var5, var7 $var7<br> ";
	return $var5;
}


function trimtodp( $num )
{
	include( "hilovalues.php" );
	// 500.000125
	// 500.000

//	echo "ato trim " . $loscore ."<br>";

	$var1 = 1 / $loscore;

	$var2 = $num * $var1;
//	echo "intval1" . intval( $var2 );
//	echo "intval2" . intval( $var2. '' , 10  );
	$var6 = intval( $var2. '' , 10 );
	$var7 = $var6 / $var1;
	
//	var1 1000, var2 160, var3 0.99999999999997, var4 159, var5 0.159, var6 159, var7 0.159
//	echo "var1 $var1, var2 $var2, var3 $var3, var4 $var4, var5 $var5, var6 $var6, var7 $var7<br> ";
	
//	echo "var5 " . $var5;// . " " . $num;
	return $var7;//$num;// . " " . $num;
}

function trimtoxdp( $num, $varx )
{
	include( "hilovalues.php" );
	//  5
	// 500.98747123
	// 500.98747
	
//	echo "xto trim $num to $varx<br>";

	$var1 = pow( 10, $varx);

	$var2 = $num * $var1;
	$var3 = fmod( $var2, 1 );
	$var4 = $var2 - $var3;
	$var5 = $var4 / $var1;
	
	$var6 = intval( $var2. '' , 10 );
	$var7 = $var6 / $var1;
	
//	echo "xto $num, $varx, $var7<br>";
	return $var7;// . " " . $num;
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
	
	if( $type == "new-username" )
	{
		$minlen = $namelength_min;
		$maxlen = $namelength;
		$len = strlen( $var );
		
		if( $len < $minlen ){return "username must be $minlen characters or more";	}
		if( $len > $maxlen ){return "username must be $maxlen characters or less";	}
		
		$var2 = preg_match( "/^[a-zA-Z][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{	return "username must begin with a letter and contain only characters A-Z a-z 0-9 _ and -";	}
		
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

	if( $type == "productname2" )
	{
		echo "here we are<br>";
		
		$varr1 = pr2check( $var );
		
		if( $varr1[0] == 'okay' )
		{
			return $varr1;
		}
		
		$varr[0] = 'notokay';
		
echo "wer<br>";
		$minlen = $productlength_min;
		$maxlen = $productlength;
		$len = strlen( $var );
		
		if( $len < $minlen )
		{
			$varr[1] = "product name must be $minlen characters or more";
			return $varr;
		}
		if( $len > $maxlen )
		{
			$varr[1] = "product name must be $maxlen characters or less";
			return $varr;
		}
		
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{
			$varr[1] = "product name must contain only characters A-Z a-z 0-9 _ and -";
			return $varr;
		}

		if ( strpos( $var, " ") != false )
		{
			$varr[1] = "product name  must not have a space";
			return $varr;
		}

		$varr[0] = 'okay';
		$varr[1] = $var;
		return $varr;
	}

	if( $type == "new-productname" )
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
		
		$var2 = preg_match( "/^[a-zA-Z][a-zA-Z0-9 _-]+$/", $var );
		if( $var2 == null )
		{
			return "product name must begin with a letter and contain only characters A-Z a-z 0-9 _ and -";
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
		
		$var2 = preg_match( "/^[a-zA-Z0-9][a-zA-Z0-9 _.-]+$/", $var );
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
				( $var == "cointrade" ) ||
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

function pr2check( $var )
{
	$var2 = preg_match('/^\d{1,9}$/', $var);

	if ( $var2 == 0 )
	{
		echo "here10<br>";
		return null;
	}

	$result = myquery( "select productName from products1 where uniqueX = \"$var\" " );
	$row = mysqli_fetch_row($result);

	if( $row[0] == null )
	{
		$varr[0] = 'okay';
		$varr[1] = "product does not exist";
		echo "here11<br>";
		return $varr;
	}
	$varr[0] = 'okay';
	$varr[1] = $row[0];
	echo $row[0];
	
	echo " here12<br>";
	
	return $varr;
		
	// if only numbers 
	//   search products for id 
	//     if not null return var[0]okay var[1]pname
	//     if null product not found 
}


?>
