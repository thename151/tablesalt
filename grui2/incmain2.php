<?php

$qe = '';
$messagez = '';
$title1 = '';

if (isset($_GET['qe']))
{	$qe = $_GET['qe'];	}
else
{	$qe = "blank";	}


if ( $qe == "start" )//	source : <a class="b" href=https://github.com/thename151/tablesalt target="_blank">github.com/thename151/tablesalt</a><br>
{
	$messagez = '
	<p>
	On this website products can be created and traded.
	</p>
	<p>
	You are not logged in.
	</p>
	<h2><a href="page2.php?qe=prices">view sales</a></h2>';
}


if ( $qe == "prices" )
{
	$link1 = "page2.php";
	include 'outprice.php';
}


if( $qe == "market" )
{
	$link1 = "page2.php";
	include 'outprice.php';
}


if ( $messagez == "" )
{
	$messagez = "<br>you are not logged in";
}
?>
