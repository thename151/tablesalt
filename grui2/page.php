<?php
session_start();
$name1 = $_SESSION['name1'];
if( $_SESSION['login'] != "yes" )
{
	session_start();
	session_destroy();
	unset( $_SESSION );
	header("Location: page2.php");
}

include_once( "incmain.php" );
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
echo $title1;
?>

</title>
</head>

<body bgcolor="black">
<div id="container">

<div id="wrapper">
<div id="top2">
<h1><a href="index.php">
<?php
include( '../sitename.inc' );
echo $sitename;
?>	
</a></h1>
</div>
<div id="lname">



<?php
echo $name1; //<a href="page.php?qe=settins"></a>
?>



 logged in

</div>
</div>

<div id="leftnav">

<a href="page.php?qe=scores">scores</a><br>
<a href="page.php?qe=prices">prices</a><br><br>
<a href="page.php?qe=myproducts">my products</a><br>
<a href="page.php?qe=mytrades">my trades</a><br><br>
<a href="page.php?qe=users">users</a><br>
<a href="page.php?qe=products">products</a><br><br>
<a href="page.php?qe=sendproduct1">send product</a><br>
<a href="page.php?qe=transactions">transactions</a><br><br>
<a href="page.php?qe=dividends">dividends</a><br><br>
<a href="page.php?qe=sendmessage1">send message</a><br>
<a href="page.php?qe=readmessages&startfrom=0&results=5">read messages</a><br><br>
<a href="page.php?qe=settins">settins</a><br>
<a href="logout.php">logout</a>
		</div>

<div id="content">

<?php
echo "$messagez";
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
</body>
</html>
