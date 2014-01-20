<?php
include_once( "funcs.php" );
include_once( "hilovalues.php" );

function sendproduct2( $name1, $pcrea, $pname, $amount, $name2 )# name1 sends to name2
{
	include( "hilovalues.php" );
	
	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	$check2 = check_name($name2,"name", $namelength);
	if( $check2 != "is valid" )
	{
		return $check2;
	}
	$check3 = check_name($pcrea,"name", $namelength);
	if( $check3 != "is valid" )
	{
		return $check3;
	}
	$check4 = check_name($pname,"product name", $productlength);
	if( $check4 != "is valid" )
	{
		return $check4;
	}
	
	return check_number( $amount, $loscore, $hiscore );
}

function sendproductbalance( $name1, $pcrea, $pname, $amount, $name2, $sendsort )
{
	$mess = sendproduct( $name1, $pcrea, $pname, $amount, $name2, $sendsort );
// 	include_once ("balance2.php");
	
// 	return $mess . balanceuser( $name2, $pcrea, $pname );

	// include_once ("balance3.php");
	// subtract stock
	// subtractstock( $name1, $pcrea, $pname, $amount );
	
	// add stock
	// addstock( $name2, $pcrea, $pname );
	
	include_once ("balance4.php");
	
	newSend( $pcrea, $pname, $name1, $name2 );
	
	return $mess;
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

	$result4 = myquery( "select productName from products1 where profileName = \"$pcrea\" and productName = \"$pname\" and status1 = \"okay\"" );
	$row = mysqli_fetch_row( $result4 );

	if($row == null )
	{
		return "that profile's product does not exist";
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