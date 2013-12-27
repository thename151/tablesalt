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
	
	$result1 = myquery( "select * from products1 where productName = \"$pname\" and profileName = \"$name1\"" );
	$row1 = mysqli_fetch_row( $result1 );
	
	if($row1 != null )
	{
		$result2 = myquery( "select * from scores1 where who1 = \"$name1\" and creator = \"$name1\" and product = \"$pname\"" );
// #		$row2 = mysqli_fetch_row( $result2 );
		
		$amount = 0;
		while ($row2 = mysqli_fetch_row(($result2)))
		{
			$amount = $row2[4];
			
			#get it sent back
			$result3 = myquery( "select * from scores1 where creator = \"$name1\" and product = \"$pname\"" );
			while( $row3 = mysqli_fetch_array($result3) )
			{
				if( $row3[1] != $name1 )
				{
					#send it back
					include_once( "sendproduct.php" );
					sendproduct($row3[1], $name1, $pname, $row3[4], $name1, "recall" );
				}
			}
		}

// 		#remove trades
// 		myquery( "delete from sales2 where creator1 = \"$name1\" and product1 = \"$pname\"" );
// 		myquery( "delete from sales2 where creator2 = \"$name1\" and product2 = \"$pname\"" );
				
// 		#get the date
// 		$date1 = date("y-m-d H:i:s",time());
		
// 		$result4 = my2query( "INSERT INTO closedproducts1
// 	     (otherX,productName,profileName,detail,amount, opendateTime, closedateTime)
// 		 VALUES
// 		 (\"$row1[0]\",\"$pname\",\"$name1\",\"$row1[3]\",\"$amount\",\"$row1[4]\",\"$date1\")" );
		

		my2query( "update products1 set status1 = \"removed\" where productName = \"$pname\" and profileName = \"$name1\"" );
		return "product removed";
	}
	return "product not found";
}

?>