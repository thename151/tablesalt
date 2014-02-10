<?php
include( "funcs.php" );

function readlog2( $name1, $startfrom, $results )
{
	include( "hilovalues.php" );
	$check1 = check_name($name1,"name", $namelength);
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	return checksstartresults( $startfrom, $results );
}


function readlog( $name1, $startfrom, $results )
{
	$check1 = readlog2($name1, $startfrom, $results );
	if( $check1 != "is valid" )
	{
		return $check1;
	}

	$result4 = myquery( "select * from sendreclog1
		 where from1 = \"$name1\" or to1 = \"$name1\"
		 order by dateLog desc limit $startfrom, $results " );
	
	$result5 = myquery( "select * from sendreclog1
		 where from1 = \"$name1\" or to1 = \"$name1\"
		 " );
	$numrows = mysqli_num_rows( $result5 );
	
	$mess1 [0] = $numrows;
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result4)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[7]));
		$time1 = date( "H:i:s", strtotime($result_row[7] ) );
	
		$from1 = $result_row[1];
	
		if( $from1 == $name1 )
		{
			$mess4 = "sent to";
			$thename = $result_row[2];
		}
		else
		{
			$mess4 = "received from";
			$thename = $from1;
		}
	
		if( $result_row[6] == "trade" )
		{
			$thename = "<i>trade</i>";
		}
	
		if( $result_row[6] == "recall" )
		{
			$thename = "<i>recall</i>";
		}

		if( $result_row[6] == "dividend" )
		{
			$thename = "dividend";
		}
	
		$to1 = $result_row[2];
		$message = $result_row[3];
	
		$messa[0] = $result_row[5];       #amount
		$messa[1] = $result_row[3];       #creator
		$messa[2] = $result_row[4];       #product
	
		$messa[3] = $mess4;
		$messa[4] = $thename;
		$messa[5] = $date1;
		$messa[6] = $time1;
	
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}
?>
