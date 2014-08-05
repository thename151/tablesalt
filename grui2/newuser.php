<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<body bgcolor="black">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style-light.css" rel="stylesheet">
<title>
new user
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

<div id="content2">
<h2>Create a new user</h2>
<p><center>
<form action="newuser2.php"
method="POST">
<TABLE >
<tr class="blank2"><td>user name</td><td><input type="text" name="namex" maxlength="25" value="

<?php
include_once( "../funcss/setuser.php" );
echo hexavig();
?>


"></td></tr>
<tr class="blank2"><td>password</td><td><input type="password" name="pass1" maxlength="25"></td></tr>
<tr class="blank2"><td>re-type password</td><td><input type="password" name="pass2" maxlength="25"></td></tr>
<tr class="blank2"><td></td><td><input type="submit" value="send"></td></tr>
</TABLE >
</form>
</center>
</p>
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
</body></html>
