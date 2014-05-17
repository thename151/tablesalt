<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style-light.css" rel="stylesheet">
<title>
new profile
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

<div id="contentblank">
<h2>Create a new Profile</h2>

<?php

$name3 = "";
$pass1 = "";
$pass2 = "";

if (isset($_POST['namex'])){ $name3 = $_POST['namex'];}else{$name3 = "";}
if (isset($_POST['pass1'])){ $pass1 = $_POST['pass1'];}else{$pass1 = "";}
if (isset($_POST['pass2'])){ $pass2 = $_POST['pass2'];}else{$pass2 = "";}


include( "../funcss/setuser.php" );
echo createprofile($name3, $pass1, $pass2);
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
</body></html>
