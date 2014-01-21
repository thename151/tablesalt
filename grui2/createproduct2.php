<?php

$title1 = "create product";

include_once( "incs1.php" );

$pname = '';
$pdetail = '';
$decimalplaces = '';

if (isset($_POST['pname'])){ $pname = $_POST['pname'];}else{$pname = "";}
if (isset($_POST['pdetail'])){ $pdetail = $_POST['pdetail'];}else{$pdetail = "";}
if (isset($_POST['decimalplaces'])){ $decimalplaces = $_POST['decimalplaces'];}else{$decimalplaces = "";}

echo "$name1, $pname, $pdetail, $decimalplaces";

include( "../funcss/createproduct.php" );

$mess2 = createproduct( $name1, $pname, $pdetail, $decimalplaces );

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

?>
