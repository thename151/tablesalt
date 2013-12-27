<?php

$head1  = "<html>
<head><title>$title1</title></head>
<body TEXT='#FFFFFF' BGCOLOR='#000000' LINK='#00ff00' VLINK='#4444ff' ALINK='#ffff00'>";
$foot1 = "</body></html>";
$back1 = "<br<br><br><a href='pagetwo.php'>back</a>";

session_start();
$name1 = $_SESSION['name1'];
if( $_SESSION['login'] != "yes" )
{
	header("Location: logout.php");
}

$messli = "$name1 logged in<br><a href='logout.php'>logout</a><br><br>";

# $messli = "<a href='changepass.php'>$name1</a> logged in<br>";
# $messli .= "<a href='logout.php'>logout</a><br><br>";


?>