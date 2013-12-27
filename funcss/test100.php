<?php
// include( "dbfuncs.php" );

// $date1 = date("y-m-d H:i:s",time());
// $result2 = my2query( "INSERT INTO login1 ( loginName, LoginTime ) VALUES (\"blank\",\"$date1\")" );



echo "test100<br><br>";

$date1 = date("y-m-d H:i:s",time());
$date2 = strtotime("2013-04-18 00:00:00");
$date3 = time();
$dif1 = $date2 - $date3;
$dif1 = $dif1 / 3600;

$dif1 = (int)$dif1;

echo "<br>$date1<br>";
echo "<br>$date2<br>";
echo "<br>$date3<br>";
echo "<br>$dif1<br>";

echo "<br><br>";

$p = 10;
$s = 0.00000228;

$bp = 0;
$sp = 0;

for( $i = 1; $i < $dif1+3; $i++ )
{
	$sp = $p;
	$p = $p - ($p * $s );
	$bp = $p;
	$date4 = date("y-m-d H:i:s",$date2 - (3600 * $i ));
	echo "$i : $date4 : $p<br>";
}
echo "<br>";
echo "<br>";
echo "bp : $bp<br>";
echo "sp : $sp<br>";

?>