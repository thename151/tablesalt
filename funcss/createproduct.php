<?php
include( "funcs.php" );


function createproduct( $name1, $pname, $pdetail )
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
	
// 	$result2 = myquery(
// 	"select productName from closedproducts1 where profileName = \"$name1\" and 
// 	productName = \"$pname\"" );

// 	$row2 = mysqli_fetch_row( $result2 );
	
// 	if($row2 != null )
// 	{
// 		echo "here4";
// 		return "this profile has already created, and deleted, this product";
// 	}
	
	$date1 = date("y-m-d H:i:s");
	$result4 = my2query( "INSERT INTO products1 (productName,profileName,detail,dateTime) VALUES (\"$pname\",\"$name1\",\"$pdetail\",\"$date1\")" );
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