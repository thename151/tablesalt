<?php
session_start();

if( isset($_SESSION['login'] ) == false )
{
	$_SESSION['login'] = "";
}


if( $_SESSION['login'] == 'yes' )
{
	$name1 = $_SESSION['name1'];
	include( "stringz.php" );

	echo $header1;
	echo "now";
	echo $header2;
	echo $top1;
	echo $leftnav3;
	echo $content3blank1;
	echo $content11;
	
	$srclink = 'source : <a href=https://github.com/thename151/tablesalt>github.com/thename151/tablesalt</a><br>';
	echo $srclink;
	
	echo $content3blank2;
	echo $footer;

	echo '</body></html>';

}
else
{
	$name1 = ""; #//defined variable
	include( "stringz.php" );

	$srclink = 'source : <a href=https://github.com/thename151/tablesalt>github.com/thename151/tablesalt</a><br>';
	
	echo $header1;
	echo "start";
	echo $header2;
	echo $top1original;
	echo $leftnav2;
	echo $content3blank1pre;
	echo $content11;
	
	echo $srclink;
	
	echo $content12;
	echo $content3blank2;
	echo $footer;
	echo '</body></html>';
}

?>