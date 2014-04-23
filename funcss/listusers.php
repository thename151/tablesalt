<?php

include( "funcs.php" );


function listusers2( $startfrom, $results  )
{	
	$check1 = checksstartresults( $startfrom, $results );
	if( $check1 != "is valid" )
	{
		return $check1;
	}
	
	$result1 = myquery( "select loginName from users1 where closeDate is null order by loginName limit $startfrom, $results " );
	$result2 = myquery( "select loginName from users1 where closeDate is null" );
	
	$numrows = mysqli_num_rows( $result2 );

	$mess1 [0] = $numrows;
	$i1 = 1;
	
	while($noticia = mysqli_fetch_array($result1))
	{
		$mess1 [$i1] = $noticia[0];
		$i1++;
	}
	return $mess1;
}

?>
