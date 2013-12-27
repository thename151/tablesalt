<?php
// include( "dbfuncs.php" );

// $date1 = date("y-m-d H:i:s",time());
// $result2 = myquery( "INSERT INTO login1 ( loginName, LoginTime ) VALUES (\"blank\",\"$date1\")" );

echo "test102";

$str = $date1 = date("y-m-d H:i:s",time());;

$myFile = "/home/a6571767/public_html/testFile2.txt";
$stringData = $str;

$fh = fopen($myFile, 'w') or die("Can't open file");
fwrite($fh, $stringData);
fclose($fh);
?>