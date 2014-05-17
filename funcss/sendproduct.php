<?php
include_once( "funcs.php" );
include_once( "hilovalues.php" );


function sendproductbalance( $name1, $pcrea, $pname, $amount, $name2, $sendsort )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $pcrea );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pname );if ($check1 != "okay" ){ return $check1;}

	$check1 = check_string( "username", $name2 );if ($check1 != "okay" ){ return $check1;}
	
	$check1 = check_string( "amount", $amount );if ($check1 != "okay" ){ return $check1;}
	
	$check1 = check_string( "sendsort", $sendsort );if ($check1 != "okay" ){ return $check1;}

	$amount = trimtodp( $amount );

	$mess = sendproduct( $name1, $pcrea, $pname, $amount, $name2, $sendsort );
	include_once ("balance4.php");
	
	newSend( $pcrea, $pname, $name1, $name2 );
	
	return $mess;
}


function sendprDiv1( $name, $cr1, $pr1, $amount )
{
	$checkr1 = invname1( $name, $cr1, $pr1, $amount );

	if( $checkr1[0] == "insufficient funds" )
	{
		return "insufficient funds" . $checkr1[1];
	}

	sendproduct5( $name, $cr1, $pr1, $checkr1[1], $checkr1[0] );
	return sendlog($name, $cr1, $pr1, $amount, "divholder", "dividend" );

	return "a success : $name, $cr1, $pr1, $amount, div, div<br>";
}


function sendprDiv2( $name, $cr1, $pr1, $amount )
{
	$checkr2 = invname2( $name, $cr1, $pr1, $amount );
	
	sendproduct5( $name, $cr1, $pr1, $checkr2[1], $checkr2[0] );
	sendlog($name, $cr1, $pr1, $amount, "divholder", "dividend" );
}

function sendproduct( $name1, $pcrea, $pname, $amount, $name2, $sendsort )
{
#	echo "sendproduct  :  $name1, $pcrea, $pname, $amount, $name2, $sendsort<br>";
	$check1 = sendproduct2( $name1, $pcrea, $pname, $amount, $name2 );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	// 	does pcrea - pname exist
	// 	does name2 exist
	// 	does name == pcrea
	// 	does name have any pcrea - pname
	// 	does pcrea == name2

	if( $name1 == $name2 )
	{
		return "you cannot send scores to yourself";
	}

	// 	does pcrea - pname exist

	$result4 = myquery( "select productName, divisible from products1 where profileName = \"$pcrea\" and productName = \"$pname\" and status1 = \"okay\"" );
	$row = mysqli_fetch_row( $result4 );

	if($row == null )
	{
		return "that profile's product does not exist";
	}

	if($row[1] == 0 )
	{
		$var1 = fmod($amount, 1);
#		echo "ww : $var1";
		if( $var1 != 0 )
		{
			return "$pcrea $pname can't have decimal places : $var1";
		}
	}

	//	product exists
	//	does name2 exist
	$check2 = profile_exist($name2);
	if( $check2 != "profile does exist")
	{
		return "$name2 : $check2";
	}
	//	name2 exists

	$checkr1 = invname1( $name1, $pcrea, $pname, $amount );

	if( $checkr1[0] == "insufficient funds" )
	{
		return "insufficient funds" . $checkr1[1];
	}
	if( $checkr1[0] == "create" )
	{
		sendproduct5( $name1, $pcrea, $pname, $checkr1[1], $checkr1[0] );
		sendproduct5( $name2, $pcrea, $pname, $checkr1[1], $checkr1[0] );
		return sendlog($name1, $pcrea, $pname, $amount, $name2, $sendsort );
	}
	$checkr2 = invname2( $name2, $pcrea, $pname, $amount );
	
	sendproduct5( $name1, $pcrea, $pname, $checkr1[1], $checkr1[0] );
	sendproduct5( $name2, $pcrea, $pname, $checkr2[1], $checkr2[0] );

	return sendlog($name1, $pcrea, $pname, $amount, $name2, $sendsort );
}

function sendlog($name1, $pcrea, $pname, $amount, $name2, $sendsort )
{
	$date1 = date("y-m-d H:i:s",time());

	my2query( "INSERT INTO sendreclog1 (from1,to1,creator,product,amount,sendsort,dateLog) VALUES (\"$name1\",\"$name2\",\"$pcrea\",\"$pname\",\"$amount\",\"$sendsort\",\"$date1\" )" );
	return "product sent ";
}


function sendproduct5( $name1, $pcrea, $pname, $newscore1, $act1 )
{
	if( $act1 == "create")
	{
		my2query( "INSERT INTO scores1 (who1,creator,product,amount)
		values (\"$name1\", \"$pcrea\", \"$pname\", \"$newscore1\")" );
	}
	if( $act1 == "update")
	{
		my2query( "update scores1 set amount = \"$newscore1\" where
		who1 = \"$name1\" and creator = \"$pcrea\" and product = \"$pname\"" );
	}
	if( $act1 == "delete")
	{
		myquery( "delete from scores1 where who1 = \"$name1\" and 
		creator = \"$pcrea\" and product = \"$pname\"" );
	}
}

function invname2( $name, $pcrea, $pname, $amount )
{
	$result1 = myquery(
		 "select amount from scores1 where who1 = \"$name\" 
		and creator = \"$pcrea\" and product = \"$pname\"" );

	$row = mysqli_fetch_row( $result1 );

	if($row == null )
	{
		$result[0] = "create";
		$result[1] = $amount;
		return $result;
	}

	$score = $row[0];

	if( $pcrea == $name )
	{
		$newscore = $score - $amount;
		$result[0] = "update";
		$result[1] = $newscore;
		if($newscore == 0 )
		{
			$result[0] = "delete";
		}
		return $result;
	}

	$newscore = $score + $amount;
	
	$result[0] = "update";
	$result[1] = $newscore;
	return $result;
}


function invname1( $name, $pcrea, $pname, $amount )
{
	$result1 = myquery(
	 "select amount from scores1 where who1 = \"$name\" 
	and creator = \"$pcrea\" and product = \"$pname\"" );
	
	$row = mysqli_fetch_row( $result1 );
	
	if($row == null )
	{
		$score = 0;
	}
	else
	{
		$score = $row[0];
	}
	if( $score == 0 )
	{
		if( $name != $pcrea )
		{
			$result[0] = "insufficient funds";
			$result[1] = "";
			return $result;
		}
		$result[0] = "create";
		$result[1] = $amount;
		return $result;
	}
//  score > 0
	if( $name == $pcrea )
	{
		include( "hilovalues.php" );
		if( $amount > ( $hiscore - $score ) )
		{
			$result[0] = "insufficient funds";
			$result[1] = ", large numbers";
			return $result;
		}
		$result[0] = "update";
		$result[1] = $amount + $score;
		return $result;
	}
// 	name != $pcrea
	if( $amount > $score )
	{
		$result[0] = "insufficient funds";
		$result[1] = "";
		return $result;
	}
	if( ( $amount - $score ) == 0 )
	{
		$result[0] = "delete";
		$result[1] = 0;
		return $result;
	}
	$result[0] = "update";
	$result[1] = $score - $amount;
	return $result;
}

?>
