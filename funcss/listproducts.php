<?php
include( "funcs.php" );

function listproducts( $startfrom, $results )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result1 = myquery( "select 
            productName, user1, detail, status1, datetime
			from products1 where status1 = \"okay\" order by datetime desc
			limit $startfrom, $results " );
	
	$result2 = myquery( "select
			productName, user1, detail, status1, datetime
			from products1 where status1 = \"okay\" order by datetime desc" );
	
	$numrows = mysqli_num_rows( $result2 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;

	while ($result_row = mysqli_fetch_row(($result1)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[4]));
		$time1 = date( "H:i:s", strtotime($result_row[4] ) );
		$pname = $result_row[0];
		$pdetail = $result_row[2];
		$pcreator = $result_row[1];
		
		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $pname;
		$messa[3] = $pdetail;
		$messa[4] = $pcreator;
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}


function listproducts2( $cr1, $startfrom, $results )
{
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result1 = myquery( "select 
            productName, user1, detail, status1, datetime
			from products1 where status1 = \"okay\" and user1 = \"$cr1\" order by datetime desc
			limit $startfrom, $results " );
	
	$result2 = myquery( "select
			productName, user1, detail, status1, datetime
			from products1 where status1 = \"okay\" and user1 = \"$cr1\" order by datetime desc" );

	$numrows = mysqli_num_rows( $result2 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;

	while ($result_row = mysqli_fetch_row(($result1)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[4]));
		$time1 = date( "H:i:s", strtotime($result_row[4] ) );
		$pname = $result_row[0];
		$pdetail = $result_row[2];
		$pcreator = $result_row[1];
		
		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $pname;
		$messa[3] = $pdetail;
		$messa[4] = $pcreator;
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}



function listusersproducts( $name1, $startfrom, $results  )
{
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	

	$result1 = myquery( "select 
            productName, detail, datetime
			from products1 where user1 = \"$name1\"
			and status1 != \"removed\"
			order by datetime desc limit $startfrom, $results " );

	$result2 = myquery( "select 
            productName, detail, datetime
			from products1 where user1 = \"$name1\"
			and status1 != \"removed\"
			order by datetime desc " );

	$numrows = mysqli_num_rows( $result2 );

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;

	$i1 = 1;

	while ($result_row = mysqli_fetch_row(($result1)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[2]));
		$time1 = date( "H:i:s", strtotime($result_row[2] ) );
		$pname = $result_row[0];
		$pdetail = $result_row[1];
		
		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $pname;
		$messa[3] = $pdetail;
		
		$mess1 [$i1] = $messa;
		$i1++;
	}
	return $mess1;
}


function productdetail( $cr1, $pr1 )
{
	$check1 = check_string( "username", $cr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	
	$result1 = myquery( "select
			detail, dateTime, status1, divisible
			from products1 where
			user1 = \"$cr1\" and productName = \"$pr1\" ");
	
	$messa ="";
	$messa[0] = "blank";
	
	while( $rowa = mysqli_fetch_array( $result1 ) )
	{
		if( $rowa[2] == "removed" )
		{
			$messa[0] = "removed";
		}
		else
		{
			$messa[0] = "full";
			$messa[1] = $rowa[ 0 ];
			$messa[2] = $rowa[ 1 ];
			$messa[3] = $rowa[ 3 ];
		}
	}
	return $messa;
}


?>
