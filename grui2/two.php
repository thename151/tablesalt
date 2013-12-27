<?php

session_start();

if( isset($_SESSION['name1']) == false )
{
	$_SESSION['name1'] = "";
}

if( isset($_SESSION['login'] ) == false )
{
	$_SESSION['login'] = "";
}

$name1 = $_SESSION['name1'];

if( $_SESSION['login'] == "no" )
{
	header("Location: logout.php");
}

if( $_SESSION['login'] != "yes" )
{
	if( isset( $_POST["namex"] ) == false && isset( $_POST["passx"] ) == false )
	{
		header("Location: index.php");
	}
	
	
	
	
	if( isset( $_POST["namex"] ) == false )
	{
		$_POST["namex"] = "";
	}
	if( isset( $_POST["passx"] ) == false )
	{
		$_POST["passx"] = "";
	}

	$name1 = $_POST["namex"];
	$pass1 = $_POST["passx"];

	include( "../funcss/funcs.php" );

	$mess2 = checknamepass( $name1, $pass1 );
	if( $mess2 == "goodpass" )
	{
		//session_start();
		$_SESSION['name1'] = $name1;
		$_SESSION['login'] = "yes";

		$mess3 = "logged in";
	}
	else
	{
		$mess3 = "bad password";
	}
}
else
{
	$mess3 = "logged in";
}



if( $mess3 == "logged in")
{
	header("Location: index.php");
}

if( $mess3 == "bad password")
{
	include( "stringz.php" );

	echo $header1;
	echo "now";
	echo $header2;
	echo $top1original;
	echo $leftnav2;
	echo $content3blank1;
	echo $mess3;
	echo $content3blank2;
	echo $footer;

	echo '</body>';
	echo '</html>';
}

?>