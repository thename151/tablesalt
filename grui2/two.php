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

if( $_SESSION['login'] != "yes" )
{
	if( isset( $_POST["namex"] ) == false || isset( $_POST["passx"] ) == false )
	{
		header("Location: index.php");
	}

	$name1 = $_POST["namex"];
	$pass1 = $_POST["passx"];

	include( "../funcss/funcs.php" );

	$mess2 = checknamepass( $name1, $pass1 );
	if( $mess2 == "goodpass" )
	{
		echo "qwe here 333";
		$_SESSION['name1'] = $name1;
		$_SESSION['login'] = "yes";
		$_SESSION['cssfile'] = "style-dark.css";

		$mess3 = "logged in";
	}
	else
	{
//		$mess3 = $mess2;
		$mess3 = "incorrect username or password";
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<body bgcolor="black">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style2.css" rel="stylesheet">
<title>
login
</title>
</head>
<body><div id="container">

<div id="top">
<h1><a href="index.php">
<?php
include( '../sitename.inc' );
echo $sitename;
?>	
</a></h1>
</div>

		
<div id="leftnavpre">
<center>
<table><form action="two.php"
method="POST">
<tr class="blank"><td><center>
login<br>
<input type="text" name="namex" maxlength="25" size="10"><br>
Password<br><input type="password" name="passx"" maxlength="25" size="10"><br>
</center>
</td></tr>
<tr class="blank"><td><center>
<input type="submit" value="Send">
</center>
</td></tr>
</form></table>
</center>
</div>

<div id="content">
bad password
</div>

<div id="footer">
	<div id="lbox">
		mess
	</div>
	<div id="rbox">
		<a href="about.php">2014</a>
	</div>
</div>
</div>
</body></html></body></html>
