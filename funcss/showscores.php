<?php
include( "funcs.php" );

function showscores( $name1 )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	include( "hilovalues.php" );
	
	$result7 = myquery( "select productName from products1 where 
						 profileName = \"$name1\" and 
						 status1 = \"okay\"" );
	$mess1a = null;
	$i1 = 0;

	while( $row2 = mysqli_fetch_array($result7) )
	{
		$result9 = myquery( "select amount from scores1 where who1 = \"$name1\" and creator = \"$name1\" and product = \"$row2[0]\"" );

		$row3 = mysqli_fetch_row($result9);
		$amt2 = "";
		$amt3 = "";
		if( $row3[0] == null )
		{
			$amt2 = $hiscore;
// 			$amt2 = "unlimited";
			$amt3 = "zero";
		}
		else
		{
			$midscore = ( ($hiscore * 1000) - ($row3[0] * 1000 ) ) / 1000 ;
			$amt3 = "-" . $row3[0];
			$amt2 = $midscore;
		}

		$messa[0] = $name1;
		$messa[1] = $row2[0];
		$messa[2] = $amt2;
		$messa[3] = $amt3;
		
		$mess1a[$i1] = $messa;
		$messa = null;
		$i1++;
	}
	

	$result8 = myquery( "select creator, product, amount from scores1 where who1 = \"$name1\"" );
	while( $row = mysqli_fetch_array($result8) )
	{
		$amt = 0;
		$name4 = $row[0];
		if( $name1 != $name4 )
		{
			$messa[0] = $row[0];
			$messa[1] = $row[1];
			$messa[3] = "";
			$messa[2] = $row[2];

			$mess1a[$i1] = $messa;
			$messa = null;
			$i1++;
		}
	}
	return $mess1a;
}


function readlog( $name1, $startfrom, $results )
{
	$check1 = check_string( "username", $name1 );if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $startfrom );;if ($check1 != "okay" ){ return $check1;}
	$check1 = check_string( "pageno", $results );if ($check1 != "okay" ){ return $check1;}

	$result4 = myquery( "select
		from1, to1, creator, product, 
		amount, sendsort, dateLog
		from sendreclog1
		where from1 = \"$name1\" or to1 = \"$name1\"
		order by dateLog desc limit $startfrom, $results " );
	
	$result5 = myquery( "select uniqueX from sendreclog1
		 where from1 = \"$name1\" or to1 = \"$name1\"
		 " );
		 
	$numrows = mysqli_num_rows( $result5 );
	
	if( $numrows == 0 )
	{
		return "there are no results here";
	}
	
	$mess1[0][0] = "okay";
	$mess1[0][1] = $numrows;
	$i1 = 1;
	
	while ($result_row = mysqli_fetch_row(($result4)))
	{
		$date1 = date( "y-m-d",strtotime($result_row[6]));
		$time1 = date( "H:i:s", strtotime($result_row[6] ) );

		$from1 = $result_row[0];
	
		if( $from1 == $name1 )
		{
			$mess4 = "sent to";
			$thename = $result_row[1];
		}
		else
		{
			$mess4 = "received from";
			$thename = $from1;
		}

		if( $result_row[5] != "ordinary" )
		{
			$thename = $result_row[5];
		}

		$to1 = $result_row[2];
		$message = $result_row[3];
	
		$messa[0] = $result_row[4];       #amount
		$messa[1] = $result_row[2];       #creator
		$messa[2] = $result_row[3];       #product

		$messa[3] = $mess4;				#which way
		$messa[4] = $thename;			#who
		$messa[5] = $date1;
		$messa[6] = $time1;
		$messa[7] = $result_row[5];
	
		$mess1 [$i1] = $messa;
		$messa = null;
		$i1++;
	}
	return $mess1;
}


?>
