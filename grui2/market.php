<?php

$title1 = "market";

include_once( "incs1.php" );

$cr1 = "";
$pr1 = "";

$cr2 = "";
$pr2 = "";

if (isset($_GET['cr1'])) $cr1 = $_GET['cr1'];
if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];
if (isset($_GET['cr1'])) $cr2 = $_GET['cr2'];
if (isset($_GET['pr2'])) $pr2 = $_GET['pr2'];

include '../funcss/listtrades2.php';
$mess3 = listdep($cr1, $pr1, $cr2, $pr2, 1 );
$mess5 = listdep($cr2, $pr2, $cr1, $pr1, 2 );

$mess4 = "";
$highbid = 0;

for( $i2 = 0; $i2 < sizeof($mess3); $i2++ )
{
	$sum = $mess3[$i2][0] / $mess3[$i2][1];
	$suma = $mess3[$i2][0] / $mess3[$i2][1];
	$mess4 .= "<tr><td>" . number_format((float)$sum, 3, '.', '') . "</td>";
	$mess4 .= "<td>for</td>";
	$mess4 .= "<td>" . (float)number_format($mess3[$i2][1],6) . "</td>";
	$mess4 .= "<td>each</td>";
	$mess4 .= "<td>( " . $mess3[$i2][0] * 1 . " )</td>";
	$mess4 .= "</tr>";
	if( $i2 == 0 )
	{
		$highbid = (float)number_format($mess3[$i2][1],6);
	}
}

$mess6 = "";

$lowask = 0;

for( $i2 = 0; $i2 < sizeof($mess5); $i2++ )
{
#	echo $i2 . " :; " . $mess5[$i2][0] . " :: " . $mess5[$i2][1] . " .. " . $mess5[$i2][0] * $mess5[$i2][1] . "<br>";
	$sum = $mess5[$i2][0] * $mess5[$i2][1];
	$mess6 .= "<tr><td>" . 1 * $mess5[$i2][0] . "</td>";
	$mess6 .= "<td>for</td>";
	$mess6 .= "<td>" . 1 * $mess5[$i2][1] . "</td>";
	$mess6 .= "<td>each</td>";
	$mess6 .= "<td>( " . number_format((float)$sum, 3, '.', '') . " )</td>";
	$mess6 .= "</tr>";
	if( $i2 == 0 )
	{
		$lowask = (float)number_format($mess5[$i2][1],6);
	}
}



$bidlink = '<a href="settradeb3.php?am1=' . $highbid . '
		&type1=sell
		&cr1=' . $cr1 . '
		&pr1=' . $pr1 . '
		&cr2=' . $cr2 . '
		&pr2=' . $pr2 . '"
		>bids</a></td>';

$asklink = '<a href="settradeb3.php?am1=' . $lowask . '
		&type1=buy
		&cr1=' . $cr1 . '
		&pr1=' . $pr1 . '
		&cr2=' . $cr2 . '
		&pr2=' . $pr2 . '"
		>asks</a></td>';




$revers = '<a href="market.php?
			&cr1=' . $cr2 . '			
			&pr1=' . $pr2 . '			
			&cr2=' . $cr1 . '			
			&pr2=' . $pr1 . '""><b>/</b></a>';
			
			
$mess9 = '
        <center>    <table  id="t3">
              <tr>
                 <td>
				 <a href="user.php?cr1=' . $cr1 . '">'.$cr1 .' </a>
				 
				 </td>
				 
				 <td><a href="product.php?cr1=' . $cr1 . '&pr1=' . $pr1 . '">' . $pr1 . '</a></td>
				 
				 
				 
                 <td><center>'.$revers.'</center></td>
        		  <td><div id="myText"><a href="user.php?cr1=' . $cr2 . '">'.$cr2 .' </a></div> </td>
                 <td><div id="myText"><td><a href="product.php?cr1=' . $cr2 . '&pr1=' . $pr2 . '">' . $pr2 . '</a></td></div> </td>
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

include( "stringz.php" );

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess9;
echo $content3blank2;
echo $footer;

?>
