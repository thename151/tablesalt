<?php

$name1 = "";

include( "stringz.php" );

echo $header1;
echo "source";
echo $header2;
echo $top1original;

echo '<div id="content2">';

	$dir = 'source/';
	$files1 = scandir($dir);
	$zipname = $files1[count($files1) - 1];
	
	$srclink = 'source : <a href=source/' .$zipname . '>' . $zipname . '</a><br>';
	
$otherlinks = '<br><i>powered by:</i><br><br>freedns.afraid.org<br>www.apache.org<br>
www.ubuntu.com<br>xampp<br>notepad++<br>';
echo $srclink;
echo $otherlinks;
		
echo '</div>';
echo $footer;
echo '</body></html>';




?>
