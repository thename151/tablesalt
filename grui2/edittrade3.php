<?php

$title1 = "order";

include_once( "incs1.php" );

$nm1 = "";
$passw = "";
$tdn = "";

$cr1 = "";
$pr1 = "";

$cr2 = "";
$pr2 = "";

$am1 = "";
$am2 = "";

if (isset($_GET['nm1'])) $nm1 = $_GET['nm1'];
if (isset($_GET['passw'])) $passw = $_GET['passw'];
if (isset($_GET['tdn'])) $tdn = $_GET['tdn'];

if (isset($_GET['amount'])) $am1 = $_GET['amount'];
if (isset($_GET['price'])) $am2 = $_GET['price'];

if( $nm1 == "" && $passw == "" ) // && $tdn == ""
{
	if( $tdn == "" )
	{
		$tdn = "<i>tradenumber</i>";
	}
	else
	{
		$tdn = "<b>$tdn</b>";
	}
	$mess2 ="			
edittrade3.php?<br>
nm1=<b>$name1</b>&<br>
passw=<i>password</i>&<br>
tdn=$tdn&<br>
amount=<i>amount</i>&<br>
price=<i>price</i>
			<br><br>
";
//edittrade3.php?nm1=name&passw=pass&tdn=65&am1=1&am2=1.25				
}
else
{
	include( "../funcss/settrade.php" );

//echo "q" . $am1;
	$mess2 = edittrade3( $nm1, $passw, $tdn, $am1, $am2 );
}
include( "stringz.php" );

echo $header1;
echo $title1;
echo $header2;
echo $top1;
echo $leftnav3;
echo $content3blank1;
echo $mess2;
echo $content3blank2;
echo $footer;
echo '</body></html>';

?>