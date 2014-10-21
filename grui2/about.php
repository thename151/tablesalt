<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />




<?php
//<link href="style-light.css" rel="stylesheet">

session_start();
//$var = "";
if ( isset($_SESSION['cssfile'] )){ $var = $_SESSION['cssfile'];}else{$var = "style-light.css";}
echo '<link href="' . $var . '" rel="stylesheet">';
?>	




<title>
about
</title>

</head>

<div id="container">


<?php
include( '../sitename.inc' );


if ( isset($_SESSION['name1'] )){ $name1 = $_SESSION['name1'];}else{$name1 = "";}

if ( $name1 != "" )
{
	$var2 = '<div id="wrapper">
	<div id="top2">
	<h1><a href="index.php">' . 
	$sitename . '</a></h1>
	</div>
	<div id="lname">' .
	$name1 . ' logged in
	</div>';
	
	echo $var2;
}
else
{
	

$var2 = '
<div id="top">
<h1><a href="index.php">' .
$sitename . '
</a></h1>
';

	
	
	echo $var2;
}
?>






</div>










<div id="content2">source : <a class="b" href=https://github.com/thename151/tablesalt target="_blank">github.com/thename151/tablesalt </a><br><br><i>links :</i><br>
<br><a class="b" href="http://freedns.afraid.org" target="_blank">freedns.afraid.org</a>
<br><a class="b" href="http://apache.org" target="_blank">apache.org</a>
<br><a class="b" href="http://ubuntu.com" target="_blank">ubuntu.com</a>
<br><a class="b" href="http://www.apachefriends.org/index.html" target="_blank">xampp</a>
<br><a class="b" href="http://notepad-plus-plus.org/" target="_blank">notepad++</a>
<br><a class="b" href="http://www.geany.org/" target="_blank">geany</a>
<br><a class="b" href="http://sourceforge.net/projects/phpqrcode/" target="_blank">phpqrcode</a>


<br>
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
