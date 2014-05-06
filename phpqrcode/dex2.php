<?php
		
function drawCode( $vardir, $name )
{
//	$vardir = '../qrcodes';
	
    //set it to writable location, a place for temp generated PNG files

//  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../qrcodes'.DIRECTORY_SEPARATOR;
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR. $vardir.DIRECTORY_SEPARATOR;
    
    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

	$dir = $PNG_TEMP_DIR;
	$files1 = scandir($dir);
	$zipname = $files1[count($files1) - 2];

	//~ echo "0 " . $files1[count($files1) - 0] . "<br>";
	//~ echo "1 " . $files1[count($files1) - 1] . "<br>";
	//~ echo "2 " . $files1[count($files1) - 2] . "<br>";
	//~ echo "3 " . $files1[count($files1) - 3] . "<br>";
	//~ echo "4 " . $files1[count($files1) - 4] . "<br>";
	//~ echo "5 " . $files1[count($files1) - 5] . "<br>";
	//~ echo "6 " . $files1[count($files1) - 6] . "<br>";

	$pieces = explode(".", $zipname);

	$zip2 = $pieces[0] + 1;
	$zip3 = sprintf('%05d', $zip2);

	$var1 = substr( $name, 0, 4);
	$zip3 = $zip3 . "-" . $var1;
	
	$filename = $PNG_TEMP_DIR . $zip3 . '.png';
    QRcode::png($name, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    

	return $zip3;
}
    
