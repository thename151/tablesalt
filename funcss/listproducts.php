<?php
include( "funcs.php" );

function listproducts( $startfrom, $results )
{
	$check1 = checksstartresults( $startfrom, $results );
	if( $check1 != "is valid" )
	{
		$mess1[0] = $check1;
		return $mess1;
	}
	
	$result1 = myquery( "select 
            productName, profileName, detail, status1, datetime
			from products1 where status1 = \"okay\" order by datetime desc
			limit $startfrom, $results " );
	
	$result2 = myquery( "select
			productName, profileName, detail, status1, datetime
			from products1 where status1 = \"okay\" order by datetime desc" );
	
	$mess1[0] = mysqli_num_rows( $result2 ); // numrows
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
	$check1 = checksstartresults( $startfrom, $results );
	if( $check1 != "is valid" )
	{
		$mess1[0] = $check1;
		return $mess1;
	}
	
	$result1 = myquery( "select 
            productName, profileName, detail, status1, datetime
			from products1 where status1 = \"okay\" and profileName = \"$cr1\" order by datetime desc
			limit $startfrom, $results " );
	
	$result2 = myquery( "select
			productName, profileName, detail, status1, datetime
			from products1 where status1 = \"okay\" and profileName = \"$cr1\" order by datetime desc" );
	
	$mess1[0] = mysqli_num_rows( $result2 ); // numrows
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



function listprofilesproducts( $name1, $startfrom, $results  )
{
	include( "hilovalues.php" );
	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid" )
	{
		$mess1[0] = $check1;
		return $mess1;
	}	
	$check1 = checksstartresults( $startfrom, $results );
	if( $check1 != "is valid" )
	{
		$mess1[0] = $check1;
		return $mess1;
	}
	
	$result1 = myquery( "select 
            productName, detail, datetime
			from products1 where profileName = \"$name1\"
			and status1 != \"removed\"
			order by datetime desc limit $startfrom, $results " );

	$result2 = myquery( "select 
            productName, detail, datetime
			from products1 where profileName = \"$name1\"
			and status1 != \"removed\"
			order by datetime desc " );

	$mess1[0] = mysqli_num_rows( $result2 ); // numrows
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

?>