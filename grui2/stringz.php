<?php 

//$randomcolor = '#' . strtoupper(dechex(rand(0,10000000)));

//$randomcolor = '#' . sprintf("%06s\n", strtoupper(dechex(rand(0,10000000))));
$randomcolor = 'black';

$header1 = 
'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<body bgcolor="' . $randomcolor  . '">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style2.css" rel="stylesheet">
<title>
';

$sitename = "tradesss";

$header2 ='
</title>
</head>
<body><div id="container">
';

$hey1 = 'hey';

$top1 = '
<div id="wrapper">
<div id="top2">
<h1><a href="index.php">'.$sitename.'</a></h1>
</div>
<div id="lname">
'. $name1 . ' logged in
</div>
</div>
';

$top1original = '
<div id="top">
<h1><a href="index.php">'.$sitename.'</a></h1>
</div>
';



$top2a = '
<div id="wrapper">
<div id="top2">
<h1><a href="index.php">table13</a></h1>
</div>
<div id="lname">';

$top2b = '
not blank
</div>
</div>
';


$leftnav = '
<div id="leftnav">
<p>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut.
</p>
</div>
';


$leftnav2 = '
		
<div id="leftnavpre">
<center>
<table><form action="two.php"
method="POST">
<tr class="blank"><td><center>
login<br>
<input type="text" name="namex" maxlength="25"><br>
Password<br><input type="password" name="passx"" maxlength="25"><br>
</center>
</td></tr>
<tr class="blank"><td><center>
<input type="submit" value="Send">
</center>
</td></tr>
</form></table>
</center>
</div>
';


$leftnav3 = '
<div id="leftnav">

<a href="listprofiles.php">list profiles</a><br>
<a href="showscores1.php">scores</a><br><br>
<a href="listproducts1.php">products</a><br>
<a href="listpproducts1.php">my products</a><br><br>
<a href="sendproduct1.php">send product</a><br>
<a href="readlog1.php">send receive log</a><br><br>
<a href="listprices2.php">prices</a><br>
<a href="listtrades1.php">trades</a><br>
<a href="listptrades1.php">my trades</a><br><br>
<a href="sendmessage1.php">send message</a><br>
<a href="readmessages1.php?startfrom=0&results=5">read messages</a><br><br>
<a href="changepass1.php">change password</a><br>
<a href="logout.php">logout</a>
		</div>
';


$content11 = '
<h2>'.$sitename.'</h2>
<p>
On this website products can be created and traded.
</p>
';


$content12 = '
<p>You are not logged in.<br>
Log in, or <a href="newprofile.php">create a new profile.</a>
</p>
';

$content3blank1 = '
<div id="content">
';
$content3blank1pre = '
<div id="contentpre">
';

$content3blank2 = '
</div>
';


$content21 = '
<div id="content2">
<h2>Create a new Profile</h2>
<p><center>
<form action="newprofile2.php"
method="POST">
<TABLE >
<tr class="blank2"><td>profile name</td><td><input type="text" name="namex" maxlength="25" value="';


$content22 = '
"></td></tr>
<tr class="blank2"><td>password</td><td><input type="password" name="pass1" maxlength="25"></td></tr>
<tr class="blank2"><td>re-type password</td><td><input type="password" name="pass2" maxlength="25"></td></tr>
<tr class="blank2"><td></td><td><input type="submit" value="send"></td></tr>
</TABLE >
</form>
</center>
</p>
</div>
';

$contentblank1 = '
<div id="contentblank">
<h2>Create a new Profile</h2>
<p>';

$contentblank2 = '
</p>
</div>
';


$footer = '
<div id="footer">
	<div id="lbox">
		mess
	</div>
	<div id="rbox">
		<a href="about.php">2013</a>
	</div>
</div>
</div>
</body></html>'
;

?>