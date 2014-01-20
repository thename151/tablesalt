<?php

$title1 = "send message";

include_once( "incs1.php" );

// $nameto = $_POST["nameto"];
// $messto = $_POST["messto"];


$cr1 = '';
$pr1 = '';
$messto = '';

if (isset($_POST['nameto'])){ $cr1 = $_POST['nameto'];}else{$cr1 = "";}
if (isset($_POST['pr1'])){ $pr1 = $_POST['pr1'];}else{$pr1 = "";}
if (isset($_POST['messto'])){ $messto = $_POST['messto'];}else{$messto = "";}

echo "$cr1 $pr1 qe";

$mess2 ="";

include( "../funcss/sendmessage.php" );

if ( $pr1 == '' )
{
	$mess2 = sendComment( $name1, $cr1, $messto );
}
else
{
	$mess2 = sendProductComment( $name1, $cr1, $pr1, $messto );
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
?>