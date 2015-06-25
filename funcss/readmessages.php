<?php
include_once( "funcs.php" );

function readmessages2( $name1, $startfrom, $results )
{
}

function readmessages( $name1, $startfrom, $results  )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	
	$result1 = myquery( "select 
						from1, to1, message1, datetime, type, product 
						from messages1 
						where from1 = \"$name1\" 
						or
						to1 = \"$name1\" 
						order by datetime desc 
						limit $startfrom, $results " );
	
	$result2 = myquery( "select * from messages1 where from1 = \"$name1\" or 
    to1 = \"$name1\" " );
	
	$numrows = mysqli_num_rows( $result2 ); // numrows

	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result1)))
	{
		$nomess = false;
		$date1 = date( "d-m-y",strtotime($result_row[3]));
		$time1 = date( "H:i:s", strtotime($result_row[3] ) );
		$from1 = $result_row[0];
		$to1 = $result_row[1];
		$message = $result_row[2];

		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $from1;
		$messa[3] = $to1;
		$messa[4] = $message;
		$messa[5] = $result_row[4];
		$messa[6] = $result_row[5];
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}


function readUserComments( $name1, $startfrom, $results  )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	
	$result1 = myquery( "select from1, message1, datetime from messages1 where
	to1 = \"$name1\" and
	type = \"user\"
	order by datetime desc limit $startfrom, $results " );
	
	$result2 = myquery( "select * from messages1 where 
    to1 = \"$name1\" and
	type = \"user\" " );
	
	
	
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
		$nomess = false;

		$date1 = date( "d-m-y",strtotime($result_row[2]));
		$time1 = date( "H:i:s", strtotime($result_row[2] ) );
		$from1 = $result_row[0];
		$message = $result_row[1];

		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $from1;
		$messa[3] = $message;
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}


function readProductComments( $name1, $pr1, $startfrom, $results  )
{
//	echo "( $name1, $pr1, $startfrom, $results  )";
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "productname", $pr1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}
	
	
	$result1 = myquery( "select from1, message1, datetime from messages1 where
	to1 = \"$name1\" and
	product = \"$pr1\" and
	type = \"product\"
	order by datetime desc limit $startfrom, $results " );
	
	$result2 = myquery( "select * from messages1 where 
	to1 = \"$name1\" and
	product = \"$pr1\" and
	type = \"product\" " );
	
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
		$nomess = false;

		$date1 = date( "d-m-y",strtotime($result_row[2]));
		$time1 = date( "H:i:s", strtotime($result_row[2] ) );
		$from1 = $result_row[0];
		$message = $result_row[1];

		$messa[0] = $date1;
		$messa[1] = $time1;
		$messa[2] = $from1;
		$messa[3] = $message;
		
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

	$result1 = myquery( "select 
						from1, to1, message1, datetime, type, product 
						from messages1 
						where 
						(from1 = \"$name1\" and
						to1 = \"$cr1\")
						or
						(from1 = \"$cr1\" and
						to1 = \"$name1\")
						order by datetime desc 
						limit $startfrom, $results
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

		$messa[5] = $result_row[4];
		$messa[6] = $result_row[5];
		
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}
?>
