<?php

$title1 = "order";

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

for( $i2 = 0; $i2 < sizeof($mess3); $i2++ )
{
	$suma = $mess3[$i2][0] / $mess3[$i2][1];
	$sum = $suma * $mess3[$i2][1];
	// $mess4 .= "<tr><td>" . (float)number_format($mess3[$i2][0],3) . "</td>";
	$mess4 .= "<tr><td>" . (float)number_format($suma,3) . "</td>";
	$mess4 .= "<td>for</td>";
	$mess4 .= "<td>" . (float)number_format($mess3[$i2][1],6) . "</td>";
	$mess4 .= "<td>each</td>";
	$mess4 .= "<td>( " . (float)number_format($sum,3) . " )</td>";
	$mess4 .= "</tr>";
}

$mess6 = "";

for( $i2 = 0; $i2 < sizeof($mess5); $i2++ )
{
	$sum = $mess5[$i2][0] * $mess5[$i2][1];
	$mess6 .= "<tr><td>" . ($mess5[$i2][0]*1) . "</td>";
	$mess6 .= "<td>for</td>";
	$mess6 .= "<td>" . (float)number_format($mess5[$i2][1],6) . "</td>";
	$mess6 .= "<td>each</td>";
	$mess6 .= "<td>( " . (float)number_format($sum,3) . " )</td>";
	$mess6 .= "</tr>";
}
$revers = '<a href="market.php?
			&cr1=' . $cr2 . '			
			&pr1=' . $pr2 . '			
			&cr2=' . $cr1 . '			
			&pr2=' . $pr1 . '"">/</a>';
			
			
$mess9 = '
        <center>    <table  id="t3">
              <tr>
                 <td>'.$cr1.'</td>
        		  <td>'.$pr1.'</td>
                 <td><center>'.$revers.'</center></td>
        		  <td><div id="myText">'.$cr2.'</div> </td>
                 <td><div id="myText">'.$pr2.'</div> </td>
              </tr>
          </table>
		  <center>
		  <br><br>
		  
        	<table  id="t1">
              <tr>
                 <td><b>bids<b></td><td></td><td></td><td></td><td></td>
              </tr>';

$mess92 =  '
		</table>
        	
            <!-- Table 2 markup-->
        <table id="t2"> 
              <tr>
                 <td><b>asks<b></td><td></td><td></td><td></td><td></td>
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
echo '</body></html>';

?>