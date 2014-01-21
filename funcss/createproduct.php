<?php
include( "funcs.php" );


function createproduct( $name1, $pname, $pdetail, $divisible )
{
	$check1 = createproduct2( $name1, $pname, $pdetail );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	
	$result = myquery(
	"select productName from products1 where profileName = \"$name1\" and 
	productName = \"$pname\"" );

	$row = mysqli_fetch_row( $result );

	if($row != null )
	{
		return "this profile has already created this product";
	}
	
	$var1 = 1;
	if( $divisible == "false" )
	{
		$var1 = 0;
	}
	
	$date1 = date("y-m-d H:i:s");
	
	$result4 = my2query( "INSERT INTO products1 
						(productName, profileName, detail, divisible, dateTime) 
						VALUES 
						(\"$pname\",\"$name1\",\"$pdetail\",\"$var1\",\"$date1\")" );
	
	return "product added";
}

function createproduct2( $name1, $pname, $pdetail )
{
	include( "hilovalues.php" );

	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$check2 = check_name($pname, "product name", $productlength );
	if( $check2 != "is valid")
	{
		return $check2;
	}

	return check_mess($pdetail, "product detail", $detaillength );
}

?>
