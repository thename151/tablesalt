<?php
include( "funcs.php" );


function createproduct( $name1, $pname, $pdetail, $divisible )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "new-productname", $pname );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productdetail", $pdetail );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "trueorfalse", $divisible );if ($check1 != "okay" ){ return $check1;}
	
	$result = myquery(
	"select productName from products1 where user1 = \"$name1\" and 
	productName = \"$pname\"" );

	$row = mysqli_fetch_row( $result );

	if($row != null )
	{
		return "this user has already created this product";
	}
	
	$var1 = 1;
	if( $divisible == "false" )
	{
		$var1 = 0;
	}
	
	$date1 = date("y-m-d H:i:s");
	
	$result4 = my2query( "INSERT INTO products1 
						(productName, user1, detail, divisible, dateTime) 
						VALUES 
						(\"$pname\",\"$name1\",\"$pdetail\",\"$var1\",\"$date1\")" );
	
	return "product added";
}


?>
