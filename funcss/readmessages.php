<?php
include( "funcs.php" );

function readmessages2( $name1, $startfrom, $results )
{
	include( "hilovalues.php" );
	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	return checksstartresults( $startfrom, $results );
}

function readmessages( $name1, $startfrom, $results  )
{
	$check1 = readmessages2( $name1, $startfrom, $results  );
	if( $check1 != "is valid" )
	{
		$mess1[0] = $check1;
		return $mess1;
	}
	
	$result1 = myquery( "select * from messages1 where from1 = \"$name1\" or
	to1 = \"$name1\" order by datetime desc limit $startfrom, $results " );
	
	$result2 = myquery( "select * from messages1 where from1 = \"$name1\" or 
    to1 = \"$name1\" " );
	
	$mess1[0] = mysqli_num_rows( $result2 ); // numrows
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result1)))
	{
		$nomess = false;
		$date1 = date( "y-m-d",strtotime($result_row[4]));
		$time1 = date( "H:i:s", strtotime($result_row[4] ) );
		$from1 = $result_row[1];
		$to1 = $result_row[2];
		$message = $result_row[3];

		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $from1;
		$messa[3] = $to1;
		$messa[4] = $message;
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}


function readmessagesfew( $name1, $startfrom, $results, $cr1 )
{
	$check1 = readmessages2( $name1, $startfrom, $results  );
	if( $check1 != "is valid" )
	{
		$mess1[0] = $check1;
		return $mess1;
	}
	
	
	$result1 = myquery( "select from1, to1, message1, datetime from messages1 where 
						(from1 = \"$name1\" and
						to1 = \"$cr1\")
						or
						(from1 = \"$cr1\" and
						to1 = \"$name1\")
						order by datetime desc limit $startfrom, $results
						" );
	

	$result2 = myquery( "select * from messages1 where
						(from1 = \"$name1\" and
						to1 = \"$cr1\")
						or
						(from1 = \"$cr1\" and
						to1 = \"$name1\")
						" );
	
	$mess1[0] = mysqli_num_rows( $result2 ); // numrows
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result1)))
	{
		$nomess = false;
		$date1 = date( "y-m-d",strtotime($result_row[3]));
		$time1 = date( "H:i:s", strtotime($result_row[3] ) );
		$from1 = $result_row[0];
		$to1 = $result_row[1];
		$message = $result_row[2];

		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $from1;
		$messa[3] = $to1;
		$messa[4] = $message;
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}
?>
