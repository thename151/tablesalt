<?php

include_once( "funcs.php" );

function deleteproduct2( $name1, $pass1, $pname )
{
	include( "hilovalues.php" );
	
	$check4 = checknamepass( $name1, $pass1 );
	if( $check4 != "goodpass" )
	{
		return $check4;
	}
	return check_mess($pname, "product name", $productlength );
}


function deleteproduct( $name1, $pass1, $pname )
{
	$check1 = deleteproduct2( $name1, $pass1, $pname );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	
	return deleteproductpassed( $name1, $pname );
}


function deleteproductpassed( $name1, $pname )
{	
	$result1 = myquery( "select * from products1 where productName = \"$pname\" and profileName = \"$name1\"" );
	$row1 = mysqli_fetch_row( $result1 );
	
	if($row1 != null )
	{
		$result3 = myquery( "select who1, amount from scores1 where creator = \"$name1\" and product = \"$pname\"" );
		while( $row3 = mysqli_fetch_array($result3) )
		{
			if( $row3[0] != $name1 )
			{
				#send it back
				include_once( "sendproduct.php" );
				sendproduct($row3[0], $name1, $pname, $row3[1], $name1, "recall" );
			}
		}
		// call delete trade here
		$q2 = myquery( "select uniqueX from sales3 where 
			( creator1 = \"$name1\" and product1 = \"$pname\")
			or
			( creator2 = \"$name1\" and product2 = \"$pname\")" );

		$var1 = 0;
		while ( $rowa = mysqli_fetch_row( ( $q2 ) ) )
		{
			$var1 = $rowa[0];
			my2query( "delete from salesactive where saleId = \"$rowa[0]\"" );
		}
		my2query( "delete from sales3 where uniqueX = \"$var1\" " );

		my2query( "update products1 set status1 = \"removed\" where productName = \"$pname\" and profileName = \"$name1\"" );
		return "product removed";
	}
	return "product not found";
}


?>
