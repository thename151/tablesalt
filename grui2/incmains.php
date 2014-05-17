<?php


if( $qe == "prices" )
{
	$title1 = "prices";
	include '../funcss/listtrades2.php';
	
	$startfrom = '';
	$results = '';
	$cr1 = '';
	$pr1 = '';
	$cr2 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
	if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}
	if (isset($_GET['cr2'])){ $cr2 = $_GET['cr2'];}else{$cr2 = "";}

	$mess1 = "";

	if(( $cr1 != "") && ($pr1 != "") )
	{
		$mess1 = listtrades46($startfrom, $results, $cr1, $pr1 );
		$title1 = "list $cr1 $pr1 prices";
	}
	else
	{
		if( $cr2 != "" )
		{	
			$mess1 = listtrades64($startfrom, $results, $cr2 );
			$title1 = "list $cr2 prices";
		}
		else
		{
			$mess1 = listtrades23($startfrom, $results);
		}
	}



	$mess2a = "";
	$mess4 = "$link1?qe=prices&";

	include_once( "incs3.php" );

	if($mess1[0][0] == "okay" )
	{
		$mess2 = $displayResults . "<br>";
		$th1 = '';

		$sz = sizeof($mess1);
		if ( $sz < 2 )
		{
			//$mess2a =  "no prices!";
			$sz = -1;
		}
		else
		{
			$th1 = '
				<tr><td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>bid</td>
				<td>ask</td></tr>';
		}

	//	$x1 = $startfrom;
	//	$x1 = $startfrom;
	//	$mess2 .= $mess1[0][0];

		for( $i2 = 1; $i2 < $sz; $i2++ )
		{
			$mess2a .= '<tr><td><a href="'.$link1.'?qe=user&cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a> </td>';
			$mess2a .= '<td> <a href="'.$link1.'?qe=product
					&cr1=' . $mess1[$i2][0] . '			
					&pr1=' . $mess1[$i2][1] . '">' . $mess1[$i2][1] . '</a> </td>';
			$mess2a .= '<td> <a href="'.$link1.'?qe=market
					&cr1=' . $mess1[$i2][0] . '			
					&pr1=' . $mess1[$i2][1] . '			
					&cr2=' . $mess1[$i2][2] . '			
					&pr2=' . $mess1[$i2][3] . '">_/&#175</a> </td>';

			$mess2a .= '<td><a href="'.$link1.'?qe=user&cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a> </td>';		
			$mess2a .= '<td> <a href="'.$link1.'?qe=product
					&cr1=' . $mess1[$i2][2] . '			
					&pr1=' . $mess1[$i2][3] . '">' . $mess1[$i2][3] . '</a> </td>';

			if( $mess1[$i2][6] == 0 )
			{
				$mess2a .= '<td>' . $mess1[$i2][4] . '</td>';
				$mess2a .= '<td>' . $mess1[$i2][5] . '</td>';
			}
			else
			{
				$mess2a .= '<td> <a href="'.$link1.'?qe=settrade1&am1=' . $mess1[$i2][4] . '
					&type1=sell
					&cr1=' . $mess1[$i2][0] . '
					&pr1=' . $mess1[$i2][1] . '
					&cr2=' . $mess1[$i2][2] . '
					&pr2=' . $mess1[$i2][3] . '"
					> ' . $mess1[$i2][4] . '</a>  </td>';
			
				$mess2a .= '<td> <a href="'.$link1.'?qe=settrade1&am1=' . $mess1[$i2][5] . '
					&type1=buy
					&cr1=' . $mess1[$i2][0] . '			
					&pr1=' . $mess1[$i2][1] . '			
					&cr2=' . $mess1[$i2][2] . '			
					&pr2=' . $mess1[$i2][3] . '"			
					>' . $mess1[$i2][5] . '</a></td>'; //'.$mess1[$i2][6].'
			}		
			$mess2a .= '</tr>';
		}

		$mess2 .= '<table class="blue">' . $th1 . $mess2a . '</table>';
		$mess2 .= "<br>" . $mess3 . "<br>";

		$messagez = $mess2;
	}
	else
	{
		$messagez = $mess1;
	}

}


if( $qe == "market" )
{
	$title1 = "market";

	$cr1 = "";
	$pr1 = "";

	$cr2 = "";
	$pr2 = "";

	if (isset($_GET['cr1'])) $cr1 = $_GET['cr1'];
	if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];
	if (isset($_GET['cr1'])) $cr2 = $_GET['cr2'];
	if (isset($_GET['pr2'])) $pr2 = $_GET['pr2'];

	include '../funcss/listtrades2.php';

	$mess7 = listdep2( $cr1, $pr1, $cr2, $pr2, 2 );


	if( $mess7[0][0] == "okay" )
	{

		$mess4 = "";
		$highbid = 0;

		$var1 = $mess7[0][1];

		for( $i2 = 0; $i2 < sizeof( $mess7[1] ); $i2++ )
		{
			$sum = $mess7[1][$i2][0] / $mess7[1][$i2][1];
			$mess4 .= "<tr><td>" . number_format((float)$sum, 3, '.', '') * 1 . "</td>";
			$mess4 .= "<td>for</td>";
			$mess4 .= "<td>" . $mess7[1][$i2][1] * 1 . "</td>";
			$mess4 .= "<td>each</td>";
			$mess4 .= "<td>( " . $mess7[1][$i2][0] * 1 . " )</td>";
			$mess4 .= "</tr>";
			if( $i2 == 0 )
			{
				$highbid = (float)number_format( $mess7[1][$i2][1],6);
			}
		}

		$mess6 = "";

		$lowask = 0;

		for( $i2 = 0; $i2 < sizeof($mess7[2]); $i2++ )
		{
			$sum = $mess7[2][$i2][0] * $mess7[2][$i2][1];
			$mess6 .= "<tr><td>" . 1 * $mess7[2][$i2][0] . "</td>";
			$mess6 .= "<td>for</td>";
			$mess6 .= "<td>" . 1 * $mess7[2][$i2][1] . "</td>";
			$mess6 .= "<td>each</td>";
			$mess6 .= "<td>( " . number_format((float)$sum, 3, '.', '') * 1 . " )</td>";
			$mess6 .= "</tr>";
			if( $i2 == 0 )
			{
				$lowask = (float)number_format( $mess7[2][$i2][1],6);
			}
		}

		if ( $var1 == 0 )
		{
			$bidlink = "bids";
			$asklink = "asks";
		}
		else
		{
		$bidlink = '<a href="'.$link1.'?qe=settrade1&am1=' . $highbid . '
				&type1=sell
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '
				&cr2=' . $cr2 . '
				&pr2=' . $pr2 . '"
				>bids</a></td>';

		$asklink = '<a href="'.$link1.'?qe=settrade1&am1=' . $lowask . '
				&type1=buy
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '
				&cr2=' . $cr2 . '
				&pr2=' . $pr2 . '"
				>asks</a></td>';
		}
					
		$var10 = '' . "_/&#175;";

		$revers = '<a href="'.$link1.'?qe=market
					&cr1=' . $cr2 . '			
					&pr1=' . $pr2 . '			
					&cr2=' . $cr1 . '			
					&pr2=' . $pr1 . '">' . $var10 . '</a>';
					
		$mess9 = '
				<center> <table  id="t3">
					  <tr>
						 <td>
						 <a href="'.$link1.'?qe=user&cr1=' . $cr1 . '">'.$cr1 .' </a>
						 </td>
						 <td>
						 <a href="'.$link1.'?qe=product&cr1=' . $cr1 . '&pr1=' . $pr1 . '">' . $pr1 . '</a>
						 </td>
						 
						 <td nowrap>
						 <center>'.$revers.'</center>
						 </td>
						 
						  <td>
						  <div id="myText">
						  <a href="'.$link1.'?qe=user&cr1=' . $cr2 . '">'.$cr2 .' </a>
						  </div>
						  </td>
						  <td>
						  <div id="myText">
						  <a href="'.$link1.'?qe=product&cr1=' . $cr2 . '&pr1=' . $pr2 . '">' . $pr2 . '</a>
						  </div>
						  </td>
					  </tr>
				  </table>
				  <center>
				  <br><br>
				  
					<table  id="t1">
					  <tr>
						 <td><b>' . $bidlink . '</b></td><td></td><td></td><td></td><td></td>
					  </tr>';
		$mess92 =  '
				</table>
					
					<!-- Table 2 markup-->
				<table id="t2"> 
					  <tr>
						 <td><b>'.$asklink.'</b></td><td></td><td></td><td></td><td></td>
					  </tr>';
					  
		$mess93 = '  
				</table>  
				</div>
				</body>
				</html>
		';

		$mess93 = '</table>';

		$mess9 = $mess9 . $mess4 . $mess92 . $mess6 . $mess93;

		$messagez = $mess9;
 
	}
	else
	{
		$messagez = $mess7;
	}
	
}

?>
