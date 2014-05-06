<?php
session_start();
if( isset( $_SESSION['login'] )  )
{
	if( $_SESSION['login'] == "yes" )
	{
		header("Location: page.php");
	}
}

include( "incmain2.php" );

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style2.css" rel="stylesheet">
<title>
<?php

include( '../sitename.inc' );

echo $sitename;

?>	
</title>
</head>
<body bgcolor="black">
<div id="container">

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
<form action="two.php"
method="POST">
<table>
<tr class="blank"><td><center>
login<br>
<input type="text" name="namex" maxlength="25" size="10"><br>
Password<br><input type="password" name="passx" maxlength="25" size="10"><br>
</center>
</td></tr>
<tr class="blank"><td><center>
<input type="submit" value="Send">
</center>
</td></tr>
</table>
</form>
<br><br>
<a href="newprofile.php">sign up</a>
</center>
</div>

<div id="contentpre">
<?php

echo $messagez;

?>
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
